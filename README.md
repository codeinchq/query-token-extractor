# Query tokens extractor

Extract tokens from a query using regex defined tokens. The library is written in [PHP 8.2](https://www.php.net/releases/8.2/en.php).

## Installation

The package is [available on Packagist](https://packagist.org/packages/codeinc/query-tokens-extractor) and can be installed using Composer:
```bash
composer req codeinc/query-token-extractor
```

## Usage

```php
use CodeInc\QueryTokenExtractor\QueryTokenExtractor;
use CodeInc\QueryTokensExtractor\Type\RegexType;
use CodeInc\QueryTokensExtractor\Type\WordType;
use CodeInc\QueryTokensExtractor\Type\FrenchPhoneNumberType;
use CodeInc\QueryTokensExtractor\Type\FrenchPostalCodeType;
use CodeInc\QueryTokensExtractor\Type\YearType;
use CodeInc\QueryTokensExtractor\Dto\QueryToken;

$tokensExtractor = new QueryTokensExtractor([
    new FrenchPhoneNumberType(),
    new FrenchPostalCodeType(),
    new YearType(),
    new RegexType('my_custom_token', '/^this a custom token/ui'),
    new WordType(),
]);

$tokens = $tokensExtractor->extract('paris (75001) these are words 01.00.00.00.00 this a custom token 2023');

/** @var QueryToken $token */
foreach ($tokens as $token) {
    echo "Position: " . $token->position . "\n"
        ."Class: " . get_class($token->type) . "\n"
        ."Name: " . $token->type->name . "\n"
        ."Value: " . $token->value . "\n";
}
```

The above exemple will generate the following output:
```text
Position: 0
Class: CodeInc\QueryTokensExtractor\Type\WordType
Name: word
Value: paris

Position: 1
Class: CodeInc\QueryTokensExtractor\Type\FrenchPostalCodeType
Name: french_postal_code
Value: 75001

Position: 2
Class: CodeInc\QueryTokensExtractor\Type\WordType
Name: word
Value: these

Position: 3
Class: CodeInc\QueryTokensExtractor\Type\WordType
Name: word
Value: are

Position: 4
Class: CodeInc\QueryTokensExtractor\Type\WordType
Name: word
Value: words

Position: 5
Class: CodeInc\QueryTokensExtractor\Type\FrenchPhoneNumberType
Name: french_phone_number
Value: 01 00 00 00 00 (the original value without punctuation)

Position: 6
Class: CodeInc\QueryTokensExtractor\Type\CustomTokenType
Name: my_custom_token
Value: this a custom token

Position: 7
Class: CodeInc\QueryTokensExtractor\Type\YearType
Name: year
Value: 2023
```

## Token types
### Available token types 
- `WordType`: extract words from the query
- `YearType`: extract years from the query
- `FrenchPhoneNumberType`: extract French phone numbers from the query
- `FrenchPostalCodeType`: extract French postal codes from the query
- `HashtagType`: extract hashtags from the query
- `RegexTokenType`: extract tokens from the query using a regex

### Token type priority
The token type priority is determined by the order in which the token types are passed to the `QueryTokensExtractor` constructor. 

The priority is used to determine the order in which the tokens are extracted. The higher the priority, the sooner the token will be extracted. 

⚠️ The `WordType` should always be used last as it will match any string.

```php
use CodeInc\QueryTokenExtractor\QueryTokenExtractor;
use CodeInc\QueryTokensExtractor\Type\WordType;
use CodeInc\QueryTokensExtractor\Type\FrenchPhoneNumberType;
use CodeInc\QueryTokensExtractor\Type\FrenchPostalCodeType;
use CodeInc\QueryTokensExtractor\Type\YearType;

$tokensExtractor = new QueryTokensExtractor([
    new FrenchPhoneNumberType(), // highest priority
    new FrenchPostalCodeType(),
    new YearType(),
    new WordType(), // lowest priority
]);
```

### Creating custom token types
Custom token types can be created by instantiating or extending `RegexTokenType`. The constructor of `RegexTokenType` takes four arguments:
- `string $name`: the name of the token type
- `string $regex`: the regex used to extract the token
- `\Closure $valueFormatter`: a closure used to format the extracted value (optional)

The regexp `value` capturing group is used as the extracted value (for instance the `HashtagType` type uses the regex `'/^#(?<value>.[a-z0-9_]+)/ui'`). If no group named `value` is defined, the whole match is used as the token value. 

The regexp should always start with `^` and do not constrain the end of the string with `$` as the query is split into tokens using the [`preg_replace_callback()`](https://www.php.net/manual/en/function.preg-replace-callback.php) function.

```php
use CodeInc\QueryTokensExtractor\Type\RegexType;

class MyCustomTokenType extends RegexType
{
    public function __construct()
    {
        parent::__construct(
            name: 'my_custom_token',
            regexp: '/^this a custom token/ui'
        );
    }
}

// alternatively tokens can be defined directly using the RegexType class
$myCustomToken2 = new RegexType(
    name: 'my_custom_token',
    regexp: '/^this a custom token/ui'
);
```

### Token value formatting
The extracted token value can be formatted using the `valueFormatter` closure. The closure takes the extracted value as argument and must return the formatted value.

```php
use CodeInc\QueryTokensExtractor\Type\RegexType;

$tokensExtractor = new QueryTokensExtractor([
    new RegexType(
        name: 'my_custom_token',
        regexp: '/^this a custom token/ui',
        priority: 10,
        // a simple closure called by QueryToken::getFormattedValue()
        valueFormatter: fn($value) => strtoupper($value)
    )
]);
$tokens = $tokensExtractor->extract('this a custom token');
$tokens->getByPosition(0)->getFormattedValue(); // THIS A CUSTOM TOKEN
```

## License
This library is published under the MIT license (see the [LICENSE](https://github.com/codeinchq/query-tokens-extractor/blob/main/LICENSE) file).
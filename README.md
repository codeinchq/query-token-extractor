# Query tokens extractor

Extract tokens from a query using regex defined tokens. The library is written in [PHP 8.2](https://www.php.net/releases/8.2/en.php).

## Installation

```bash
composer req codeinc/query-token-extractor
```

## Usage

```php
use CodeInc\QueryTokenExtractor\QueryTokenExtractor;
use CodeInc\QueryTokensExtractor\Type\CustomTokenType;
use CodeInc\QueryTokensExtractor\Type\WordType;
use CodeInc\QueryTokensExtractor\Type\FrenchPhoneNumberType;
use CodeInc\QueryTokensExtractor\Type\FrenchPostalCodeType;

$tokensExtractor = new QueryTokensExtractor([
    new WordType(),
    new FrenchPhoneNumberType(),
    new FrenchPostalCodeType(),
    new CustomTokenType('my_custom_token', '/^this a custom token/ui', 10)
]);

$tokens = $tokensExtractor->extract('paris (75001) these are words 01.00.00.00.00 this a custom token');

echo count($tokens);

// Output: 7

/** @var \CodeInc\QueryTokensExtractor\Dto\QueryToken $token */
foreach ($tokens as $token) {
    echo "Position: {$token->position}\n"
        ."Class: ".get_class($token->type)."\n"
        ."Name: {$token->type->name}\n"
        ."Value: {$token->value}\n";
}

// Output:

// Position: 0
// Class: CodeInc\QueryTokensExtractor\Type\WordType
// Name: word
// Value: paris

// Position: 1
// Class: CodeInc\QueryTokensExtractor\Type\FrenchPostalCodeType
// Name: french_postal_code
// Value: 75001

// Position: 2
// Class: CodeInc\QueryTokensExtractor\Type\WordType
// Name: word
// Value: these

// Position: 3
// Class: CodeInc\QueryTokensExtractor\Type\WordType
// Name: word
// Value: are

// Position: 4
// Class: CodeInc\QueryTokensExtractor\Type\WordType
// Name: word
// Value: words

// Position: 5
// Class: CodeInc\QueryTokensExtractor\Type\FrenchPhoneNumberType
// Name: french_phone_number
// Value: 01 00 00 00 00 (the original value without punctuation)

// Position: 6
// Class: CodeInc\QueryTokensExtractor\Type\CustomTokenType
// Name: my_custom_token
// Value: this a custom token

```


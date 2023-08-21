<?php
declare(strict_types=1);

namespace CodeInc\QueryTokensExtractor\Type;

final readonly class FrenchPhoneNumberType extends CustomTokenType
{
    public const NAME = 'french_phone_number';

    public function __construct(int $priority = 10)
    {
        parent::__construct(
            name: self::NAME,
            /**
             * @see https://stackoverflow.com/a/46127278/1839947
             * @lang RegExp
             */
            parsingRegex: '/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})/ui',
            priority: $priority
        );
    }
}
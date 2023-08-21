<?php
declare(strict_types=1);

namespace CodeInc\QueryTokensExtractor\Type;

final readonly class FrenchPostalCodeType extends CustomTokenType
{
    private const NAME = 'french_postal_code';

    public function __construct(int $priority = 10)
    {
        parent::__construct(
            name: self::NAME,
            /**
             * @see https://rgxdb.com/r/354H8M0X
             * @lang RegExp
             */
            parsingRegex: '/^(?:[0-8]\d|9[0-8])\d{3}/ui',
            priority: $priority);
    }
}
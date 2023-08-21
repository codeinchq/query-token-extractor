<?php
declare(strict_types=1);

namespace CodeInc\QueryTokensExtractor\Type;

/**
 * @implements RegexType<int>
 */
final readonly class FrenchPostalCodeType extends RegexType
{
    private const NAME = 'french_postal_code';

    public function __construct()
    {
        parent::__construct(
            name: self::NAME,
            /**
             * @see https://rgxdb.com/r/354H8M0X
             * @lang RegExp
             */
            regex: '/^(?:[0-8]\d|9[0-8])\d{3}/ui',
            valueFormatter: fn($value) => (int)$value
        );
    }
}
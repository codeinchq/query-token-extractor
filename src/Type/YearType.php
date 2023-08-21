<?php
declare(strict_types=1);

namespace CodeInc\QueryTokensExtractor\Type;

/**
 * @implements RegexType<int>
 */
final readonly class YearType extends RegexType
{
    public const NAME = 'year';

    public function __construct()
    {
        parent::__construct(
            name: self::NAME,
            regex: '/^\d{4}/u',
            valueFormatter: fn($value) => (int)$value
        );
    }
}
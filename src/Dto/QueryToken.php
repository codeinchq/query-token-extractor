<?php
declare(strict_types=1);

namespace CodeInc\QueryTokensExtractor\Dto;

use CodeInc\QueryTokensExtractor\Type\RegexType;

/**
 * @template TFormattedValueType
 */
final readonly class QueryToken
{
    /**
     * @param RegexType<TFormattedValueType> $type
     * @param string $value
     * @param int $position
     */
    public function __construct(public RegexType $type,
                                public string    $value,
                                public int       $position
    )
    {
    }

    /**
     * @return TFormattedValueType
     */
    public function getFormattedValue(): mixed
    {
        return $this->type->valueFormatter !== null ? ($this->type->valueFormatter)($this->value) : $this->value;
    }
}
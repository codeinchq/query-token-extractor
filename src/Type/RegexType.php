<?php
declare(strict_types=1);

namespace CodeInc\QueryTokensExtractor\Type;

use Closure;

/**
 * @template TValueFormatterReturnType
 */
readonly class RegexType
{
    public function __construct(public mixed    $name,
                                public string   $regex,
                                public ?Closure $valueFormatter = null)
    {
    }
}
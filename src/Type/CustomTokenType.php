<?php
declare(strict_types=1);

namespace CodeInc\QueryTokensExtractor\Type;

readonly class CustomTokenType
{
    public function __construct(public mixed  $name,
                                /** @lang RegExp */
                                public string $parsingRegex,
                                public int    $priority = 0)
    {
    }
}
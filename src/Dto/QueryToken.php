<?php
declare(strict_types=1);

namespace CodeInc\QueryTokensExtractor\Dto;

use CodeInc\QueryTokensExtractor\Type\CustomTokenType;

final readonly class QueryToken
{
    public function __construct(public CustomTokenType $type,
                                public string          $value,
                                public int             $position
    )
    {
    }
}
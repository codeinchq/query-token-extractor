<?php
declare(strict_types=1);

namespace CodeInc\QueryTokensExtractor\Type;

final readonly class WordType extends CustomTokenType
{
    public const NAME = 'word';

    public function __construct(int $priority = 0)
    {
        parent::__construct(self::NAME, '/^\S+/ui', $priority);
    }
}
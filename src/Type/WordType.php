<?php
declare(strict_types=1);

namespace CodeInc\QueryTokensExtractor\Type;

final readonly class WordType extends RegexType
{
    public const NAME = 'word';

    public function __construct()
    {
        parent::__construct(self::NAME, '/^\S+/ui');
    }
}
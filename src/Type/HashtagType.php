<?php
declare(strict_types=1);

namespace CodeInc\QueryTokensExtractor\Type;

final readonly class HashtagType extends RegexType
{
    public const NAME = 'hashtag';

    public function __construct()
    {
        parent::__construct(
            name: self::NAME,
            regex: '/^#(?<value>.[a-z0-9_]+)/ui',
        );
    }
}
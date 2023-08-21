<?php
declare(strict_types=1);

namespace CodeInc\QueryTokensExtractor\Dto;

use ArrayIterator;
use CodeInc\QueryTokensExtractor\Type\CustomTokenType;
use Countable;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<QueryToken>
 */
final class QueryTokens implements IteratorAggregate, Countable
{
    /**
     * @var array<QueryToken>
     */
    private array $tokens = [];

    public function addToken(CustomTokenType $type, string $value): void
    {
        $this->tokens[] = new QueryToken($type, $value, position: count($this->tokens));
    }

    /**
     * @return ArrayIterator<QueryToken>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->tokens);
    }

    public function getByPosition(int $position): ?QueryToken
    {
        foreach ($this->tokens as $token) {
            if ($token->position === $position) {
                return $token;
            }
        }
        return null;
    }

    public function count(): int
    {
        return count($this->tokens);
    }
}
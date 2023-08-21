<?php
declare(strict_types=1);

namespace CodeInc\QueryTokensExtractor\Dto;

use ArrayIterator;
use CodeInc\QueryTokensExtractor\Type\RegexType;
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

    public function addToken(RegexType $type, string $value): void
    {
        $position = count($this->tokens);
        $this->tokens[$position] = new QueryToken($type, $value, $position);
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
        return $this->tokens[$position] ?? null;
    }

    public function count(): int
    {
        return count($this->tokens);
    }
}
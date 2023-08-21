<?php
/******************************************************************************
 * Copyright (c) 2023 Code Inc. - All Rights Reserved                         *
 * Unauthorized copying of this file, via any medium is strictly prohibited   *
 * Proprietary and confidential                                               *
 * Visit https://www.codeinc.co for more information                          *
 ******************************************************************************/

declare(strict_types=1);

namespace CodeInc\QueryTokensExtractor;

use CodeInc\QueryTokensExtractor\Dto\QueryTokens;
use CodeInc\QueryTokensExtractor\Type\CustomTokenType;

readonly class QueryTokensExtractor
{
    /**
     * @param array<CustomTokenType> $types
     */
    public function __construct(private array $types)
    {
    }

    public function extract(string $query): QueryTokens
    {
        $tokens = new QueryTokens();
        if ($query) {
            // cleaning query up
            $query = preg_replace('#[*\\-\'"«»<>()\\[\\]+/|\\\\.!? ]+#ui', ' ', $query);
            $query = preg_replace('/\s{2,}/ui', ' ', $query);
            $query = trim($query);

            // extracting tokens
            if (!empty($query)) {
                do {
                    // testing each token type regex in order
                    foreach ($this->getSortedTypes() as $type) {
                        $count = 0;
                        $query = trim(
                            preg_replace_callback(
                                pattern: $type->parsingRegex,
                                callback: function (array $matches) use ($type, $tokens) {
                                    $tokens->addToken($type, $matches[0]);
                                    return '';
                                },
                                subject: $query,
                                limit: 1,
                                count: $count
                            )
                        );
                        if ($count) {
                            break;
                        }
                    }
                } while (trim($query) !== '');
            }
        }
        return $tokens;
    }

    /**
     * @return CustomTokenType[]
     */
    private function getSortedTypes(): array
    {
        $types = $this->types;
        usort($types, fn(CustomTokenType $a, CustomTokenType $b) => $b->priority <=> $a->priority);
        return $types;
    }
}

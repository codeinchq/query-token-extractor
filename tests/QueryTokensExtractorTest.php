<?php
declare(strict_types=1);

namespace CodeInc\QueryTokensExtractor\Tests;

use CodeInc\QueryTokensExtractor\Type\HashtagType;
use CodeInc\QueryTokensExtractor\Type\RegexType;
use CodeInc\QueryTokensExtractor\QueryTokensExtractor;
use CodeInc\QueryTokensExtractor\Type\FrenchPhoneNumberType;
use CodeInc\QueryTokensExtractor\Type\FrenchPostalCodeType;
use CodeInc\QueryTokensExtractor\Type\WordType;
use CodeInc\QueryTokensExtractor\Type\YearType;
use PHPUnit\Framework\TestCase;

final class QueryTokensExtractorTest extends TestCase
{
    public function testExtractor()
    {
        $tokensExtractor = new QueryTokensExtractor([
            new FrenchPhoneNumberType(),
            new FrenchPostalCodeType(),
            new YearType(),
            new HashtagType(),
            new RegexType('custom', '/^this a custom token/ui'),
            new WordType(),
        ]);

        $tokens = $tokensExtractor->extract('paris (75001) these are words 01.00.00.00.00 this a custom token 2023 #OMGAHashtag');

        self::assertCount(9, $tokens);

        $parisToken = $tokens->getByPosition(0);
        self::assertNotNull($parisToken);
        self::assertEquals('paris', $parisToken->value);
        self::assertInstanceOf(WordType::class, $parisToken->type);

        $zipCodeToken = $tokens->getByPosition(1);
        self::assertNotNull($zipCodeToken);
        self::assertEquals('75001', $zipCodeToken->value);
        self::assertInstanceOf(FrenchPostalCodeType::class, $zipCodeToken->type);

        $wordToken = $tokens->getByPosition(2);
        self::assertNotNull($wordToken);
        self::assertEquals('these', $wordToken->value);
        self::assertInstanceOf(WordType::class, $wordToken->type);

        $wordToken = $tokens->getByPosition(3);
        self::assertNotNull($wordToken);
        self::assertEquals('are', $wordToken->value);
        self::assertInstanceOf(WordType::class, $wordToken->type);

        $wordToken = $tokens->getByPosition(4);
        self::assertNotNull($wordToken);
        self::assertEquals('words', $wordToken->value);
        self::assertInstanceOf(WordType::class, $wordToken->type);

        $phoneNumberToken = $tokens->getByPosition(5);
        self::assertNotNull($phoneNumberToken);
        self::assertEquals('01 00 00 00 00', $phoneNumberToken->value);
        self::assertInstanceOf(FrenchPhoneNumberType::class, $phoneNumberToken->type);

        $customToken = $tokens->getByPosition(6);
        self::assertNotNull($customToken);
        self::assertEquals('this a custom token', $customToken->value);
        self::assertInstanceOf(RegexType::class, $customToken->type);
        self::assertEquals('custom', $customToken->type->name);

        $yearToken = $tokens->getByPosition(7);
        self::assertNotNull($yearToken);
        self::assertEquals('2023', $yearToken->value);
        self::assertIsInt($yearToken->getFormattedValue());
        self::assertInstanceOf(YearType::class, $yearToken->type);

        $hashtagToken = $tokens->getByPosition(8);
        self::assertNotNull($hashtagToken);
        self::assertEquals('OMGAHashtag', $hashtagToken->value);
        self::assertInstanceOf(HashtagType::class, $hashtagToken->type);
    }
}
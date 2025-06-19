<?php

namespace Tests\Unit\Validationable\Helpers;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\RuleArgumentParser;

class RuleArgumentParserTest extends TestCase
{
    /**
     * RuleArgumentParser::parseArguments メソッドのテストクラス。
     *
     * テスト対象メソッド:
     * parseArguments - 引数の文字列をパースして配列に変換する。
     */

    #[Test]
    public function 空文字列をパースする(): void
    {
        $instance = new RuleArgumentParser([]);
        $expected = [];
        $actual = $instance->parseArguments('');

        self::assertSame($expected, $actual, '空文字列をパースした結果が正しくありません。');
    }

    #[Test]
    public function 単一の引数をパースする(): void
    {
        $instance = new RuleArgumentParser([]);
        $expected = ['example'];
        $actual = $instance->parseArguments('example');

        self::assertSame($expected, $actual, '単一の引数をパースした結果が正しくありません。');
    }

    #[Test]
    public function 複数の引数をパースする(): void
    {
        $instance = new RuleArgumentParser([]);
        $expected = ['first', 'second', 'third'];
        $actual = $instance->parseArguments('first,second,third');

        self::assertSame($expected, $actual, '複数の引数をパースした結果が正しくありません。');
    }

    #[Test]
    public function クォート付きの引数をパースする(): void
    {
        $instance = new RuleArgumentParser([]);
        $expected = ['first', 'second value', 'third'];
        $actual = $instance->parseArguments('first,"second value",third');

        self::assertSame($expected, $actual, 'クォート付きの引数をパースした結果が正しくありません。');
    }

    #[Test]
    public function セミコロン付きの引数をパースする(): void
    {
        $instance = new RuleArgumentParser([]);
        $expected = ['H:i:s'];
        $actual = $instance->parseArguments('"H:i:s"');

        self::assertSame($expected, $actual, 'セミコロン付きの引数をパースした結果が正しくありません。');
    }

    #[Test]
    public function シングルクォート付きの引数はパースできない(): void
    {
        $instance = new RuleArgumentParser([]);
        $expected = ['first', "it's complicated", 'third'];
        $actual = $instance->parseArguments("first,'it\'s complicated',third");

        self::assertNotSame($expected, $actual, 'シングルクォート付きの引数をパースした結果が正しくありません。');
    }

    #[Test]
    public function 空白を含む引数をパースする(): void
    {
        $instance = new RuleArgumentParser([]);
        $expected = ['first', 'second', 'third'];
        $actual = $instance->parseArguments('first , second , third');

        self::assertSame($expected, $actual, '空白を含む引数をパースした結果が正しくありません。');
    }

    #[Test]
    public function エスケープされたクォートを含む引数をパースする(): void
    {
        $instance = new RuleArgumentParser([]);
        $expected = ['first', 'value with "escaped" quotes', 'third'];
        $actual = $instance->parseArguments('first,"value with ""escaped"" quotes",third');

        self::assertSame($expected, $actual, 'エスケープされたクォートを含む引数をパースした結果が正しくありません。');
    }

    #[Test]
    public function 不正なフォーマットの引数をパースする(): void
    {
        $instance = new RuleArgumentParser([]);
        $expected = ['first', 'second,third'];
        $actual = $instance->parseArguments('first,second",third');

        self::assertSame($expected, $actual, '不正なフォーマットの引数をパースした結果が正しくありません。');
    }

    #[Test]
    public function 引数なしのルールをパースする(): void
    {
        $rules = ['rule' => $this->createDummyRule()];
        $instance = new RuleArgumentParser($rules);
        $expected = [$this->createDummyRule(), []];
        $actual = $instance->parse('rule');

        self::assertInstanceOf(RuleInterface::class, $actual[0], '適切にルールインスタンスが生成されていません。');
        self::assertEquals($expected[1], $actual[1], '引数なしのルールをパースした結果が正しくありません。');
    }

    #[Test]
    public function 引数ありのルールをパースする(): void
    {
        $rules = ['rule' => $this->createDummyRule()];
        $instance = new RuleArgumentParser($rules);
        $expected = [$this->createDummyRule(), ['arg1', 'arg2']];
        $actual = $instance->parse('rule:arg1,arg2');

        self::assertInstanceOf(RuleInterface::class, $actual[0], '適切にルールインスタンスが生成されていません。');
        self::assertEquals($expected[1], $actual[1], '引数ありのルールをパースした結果が正しくありません。');
    }

    #[Test]
    public function RuleInterfaceインスタンスをパースする(): void
    {
        $instance = new RuleArgumentParser([]);
        $dummyRule = $this->createDummyRule();
        $expected = [$dummyRule, []];
        $actual = $instance->parse($dummyRule);

        self::assertSame($expected[0], $actual[0], 'RuleInterfaceインスタンスを渡した場合のパース結果が正しくありません。');
        self::assertEquals($expected[1], $actual[1], 'RuleInterfaceインスタンスの配列引数のパースが正しくありません。');
    }

    #[Test]
    public function 無効なルールフォーマットをパースする(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The rule [invalid format] is not a valid rule.');

        $instance = new RuleArgumentParser([]);
        $instance->parse('invalid format');
    }

    #[Test]
    public function 存在しないルールキーをパースする(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The rule [missing_key] does not exist.');

        $instance = new RuleArgumentParser([]);
        $instance->parse('missing_key');
    }
}
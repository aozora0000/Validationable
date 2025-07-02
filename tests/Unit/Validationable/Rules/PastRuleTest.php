<?php

namespace Tests\Unit\Validationable\Rules;

use Carbon\Carbon;
use DateTime;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\PastRule;

class PastRuleTest extends TestCase
{
    /**
     * PastRule クラスの passes メソッドをテストします。
     * 値が DateTime オブジェクトかつ現在より過去の日付であることを確認します。
     */
    #[Test]
    public function 値が日時オブジェクト_かつ過去の日付の場合にtrueを返す(): void
    {
        $instance = new PastRule();
        $parameters = $this->createParameter([]);
        $actual = $instance->passes('test', Carbon::yesterday(), $parameters);
        $this->assertTrue($actual, '過去の日付が true として認識されるべきです。');
    }

    /**
     * 値が null の場合、false を返すことを確認します。
     */
    #[Test]
    public function 値がnullの場合にfalseを返す(): void
    {
        $instance = new PastRule();
        $parameters = $this->createParameter([]);
        $actual = $instance->passes('test', null, $parameters);
        $this->assertFalse($actual, '値が null の場合に false を返すべきです。');
    }

    /**
     * 値が文字列で過去を表している場合、true を返すことを確認します。
     */
    #[Test]
    public function 値が文字列で過去を表す場合にtrueを返す(): void
    {
        $instance = new PastRule();
        $parameters = $this->createParameter([]);
        $actual = $instance->passes('test', '2023-01-01', $parameters);
        $this->assertTrue($actual, '過去の日付の文字列が true として認識されるべきです。');
    }

    /**
     * 値が文字列だが未来を表している場合、false を返すことを確認します。
     */
    #[Test]
    public function 値が文字列で未来を表す場合にfalseを返す(): void
    {
        $instance = new PastRule();
        $parameters = $this->createParameter([]);
        $actual = $instance->passes('test', '2100-01-01', $parameters);
        $this->assertFalse($actual, '未来の日付の文字列が false として認識されるべきです。');
    }

    /**
     * 値が無効な日時形式の文字列の場合、false を返すことを確認します。
     */
    #[Test]
    public function 値が無効な日時文字列の場合にfalseを返す(): void
    {
        $instance = new PastRule();
        $parameters = $this->createParameter([]);
        $actual = $instance->passes('test', 'invalid-date', $parameters);
        $this->assertFalse($actual, '無効な日時形式の文字列が false として認識されるべきです。');
    }

    /**
     * 日時が引数で設定された基準日時より過去である場合、true を返すことを確認します。
     */
    #[Test]
    public function 値が基準日時より過去の場合にtrueを返す(): void
    {
        $instance = new PastRule();
        $parameters = $this->createParameter([]);
        $actual = $instance->passes('test', '2023-01-01', $parameters, ['2023-12-31']);
        $this->assertTrue($actual, '基準日時より過去の場合に true として認識されるべきです。');
    }

    /**
     * 日時が引数で設定された基準日時より未来である場合、false を返すことを確認します。
     */
    #[Test]
    public function 値が基準日時より未来の場合にfalseを返す(): void
    {
        $instance = new PastRule();
        $parameters = $this->createParameter([]);
        $actual = $instance->passes('test', '2024-01-01', $parameters, ['2023-12-31']);
        $this->assertFalse($actual, '基準日時より未来の場合に false として認識されるべきです。');
    }
}
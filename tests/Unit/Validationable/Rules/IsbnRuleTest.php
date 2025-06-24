<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\IsbnRule;

class IsbnRuleTest extends TestCase
{
    /**
     * @description ISBN-10の形式が正しい場合のテスト
     */
    #[Test]
    public function ISBN10が正しい場合(): void
    {
        $instance = new IsbnRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('isbn', '0-19-852663-6', $params);

        $this->assertTrue($actual, 'ISBN-10が正しい場合、passes()はtrueを返す必要があります');
    }

    /**
     * @description ISBN-10の形式が誤っている場合のテスト
     */
    #[Test]
    public function ISBN10が誤っている場合(): void
    {
        $instance = new IsbnRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('isbn', '0-19-852663-7', $params);

        $this->assertFalse($actual, 'ISBN-10が誤っている場合、passes()はfalseを返す必要があります');
    }

    /**
     * @description ISBN-13の形式が正しい場合のテスト
     */
    #[Test]
    public function ISBN13が正しい場合(): void
    {
        $instance = new IsbnRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('isbn', '978-3-16-148410-0', $params);

        $this->assertTrue($actual, 'ISBN-13が正しい場合、passes()はtrueを返す必要があります');
    }

    /**
     * @description ISBN-13の形式が誤っている場合のテスト
     */
    #[Test]
    public function ISBN13が誤っている場合(): void
    {
        $instance = new IsbnRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('isbn', '978-3-16-148410-1', $params);

        $this->assertFalse($actual, 'ISBN-13が誤っている場合、passes()はfalseを返す必要があります');
    }

    /**
     * @description 無効なフォーマットまたは空白の値のテスト
     */
    #[Test]
    public function 無効なフォーマットまたは空白の値(): void
    {
        $instance = new IsbnRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('isbn', 'invalid-isbn', $params);

        $this->assertFalse($actual, '無効なフォーマットまたは空白の値の場合、passes()はfalseを返す必要があります');
    }

    /**
     * @description 値が空文字の場合のテスト
     */
    #[Test]
    public function 空文字の場合(): void
    {
        $instance = new IsbnRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('isbn', '', $params);

        $this->assertFalse($actual, '値が空文字の場合、passes()はfalseを返す必要があります');
    }

    /**
     * @description 値がnullの場合のテスト
     */
    #[Test]
    public function nullの場合(): void
    {
        $instance = new IsbnRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('isbn', null, $params);

        $this->assertFalse($actual, '値がnullの場合、passes()はfalseを返す必要があります');
    }
}
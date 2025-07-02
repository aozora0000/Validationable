<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\SqlInjectionRule;

class SqlInjectionRuleTest extends TestCase
{
    /**
     * 正常な文字列が渡された場合にtrueを返すことを確認します。
     */
    #[Test]
    public function 正常な文字列を検証する(): void
    {
        $attribute = 'username';
        $value = 'normal_value';
        $parameters = $this->createParameter([]);
        $arguments = [];

        $instance = new SqlInjectionRule();
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertTrue($actual, '正常な文字列に対してfalseが返却されました。');
    }

    /**
     * 危険なSQLキーワード"UNION SELECT"が含まれている場合falseを返すことを確認します。
     */
    #[Test]
    public function UNIONキーワードを含む文字列を検証する(): void
    {
        $attribute = 'query';
        $value = 'SELECT * FROM users UNION SELECT * FROM admin';
        $parameters = $this->createParameter([]);
        $arguments = [];

        $instance = new SqlInjectionRule();
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, '危険なキーワード"UNION SELECT"が含まれているにも関わらずtrueが返却されました。');
    }

    /**
     * コメント形式"--"が含まれている場合falseを返すことを確認します。
     */
    #[Test]
    public function コメント形式を含む文字列を検証する(): void
    {
        $attribute = 'query';
        $value = 'SELECT * FROM users -- コメント';
        $parameters = $this->createParameter([]);
        $arguments = [];

        $instance = new SqlInjectionRule();
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, 'コメント形式"--"が含まれているにも関わらずtrueが返却されました。');
    }

    /**
     * 危険な構文"OR 1=1"が含まれている場合falseを返すことを確認します。
     */
    #[Test]
    public function OR構文を含む文字列を検証する(): void
    {
        $attribute = 'query';
        $value = 'SELECT * FROM users WHERE username = "admin" OR 1=1';
        $parameters = $this->createParameter([]);
        $arguments = [];

        $instance = new SqlInjectionRule();
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, '危険な構文"OR 1=1"が含まれているにも関わらずtrueが返却されました。');
    }

    /**
     * DLC構文"DROP TABLE"が含まれている場合falseを返すことを確認します。
     */
    #[Test]
    public function DROP構文を含む文字列を検証する(): void
    {
        $attribute = 'query';
        $value = 'DROP TABLE users';
        $parameters = $this->createParameter([]);
        $arguments = [];

        $instance = new SqlInjectionRule();
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, '危険な構文"DROP TABLE"が含まれているにも関わらずtrueが返却されました。');
    }

    /**
     * SQLキーワードを含まない文字列が渡された場合にtrueを返すことを確認します。
     */
    #[Test]
    public function SQLキーワードを含まない文字列を検証する(): void
    {
        $attribute = 'query';
        $value = 'これは安全な文字列です';
        $parameters = $this->createParameter([]);
        $arguments = [];

        $instance = new SqlInjectionRule();
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertTrue($actual, 'SQLキーワードを含まない文字列に対してfalseが返却されました。');
    }
}
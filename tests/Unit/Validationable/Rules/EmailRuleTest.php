<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Helpers\Str;
use Validationable\Parameters;
use Validationable\Rules\EmailRule;

class EmailRuleTest extends TestCase
{
    /**
     * 有効なメールアドレス（MXレコードが存在する）をテストします。
     */
    #[Test]
    public function 有効なメールアドレス_MXレコードが存在する()
    {
        $instance = new EmailRule();
        $attribute = 'email';
        $value = 'user@google.co.jp';
        $parameters = $this->createMock(Parameters::class);
        $arguments = ['dns'];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertTrue($actual, '有効なメールアドレスである場合、trueを期待します。');
    }

    /**
     * 無効なメールアドレス（@を含まない）をテストします。
     */
    #[Test]
    public function 無効なメールアドレス_アットマークがない()
    {
        $instance = new EmailRule();
        $attribute = 'email';
        $value = 'invalidemail.com';
        $parameters = $this->createMock(Parameters::class);
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, '@記号を含まない無効なメールアドレスに対してfalseを期待します。');
    }

    /**
     * @記号の後が空の場合をテストします。
     */
    #[Test]
    public function 無効なメールアドレス_アットマークの後が空()
    {
        $instance = new EmailRule();
        $attribute = 'email';
        $value = 'user@';
        $parameters = $this->createMock(Parameters::class);
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, 'アットマークの後が空の無効なメールアドレスに対してfalseを期待します。');
    }

    /**
     * 無効なメールアドレス（形式が正しくない）をテストします。
     */
    #[Test]
    public function 無効なメールアドレス_形式が正しくない()
    {
        $instance = new EmailRule();
        $attribute = 'email';
        $value = 'user@@example.com';
        $parameters = $this->createMock(Parameters::class);
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, '形式が正しくない無効なメールアドレスに対してfalseを期待します。');
    }

    /**
     * 有効なメールアドレス（Aレコードがある場合）をテストします。
     */
    #[Test]
    public function 有効なメールアドレス_Aレコードが存在する()
    {
        $instance = new EmailRule();
        $attribute = 'email';
        $value = 'user@anotherdomain.com';
        $parameters = $this->createMock(Parameters::class);
        $arguments = ['dns'];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertTrue($actual, 'Aレコードが存在する有効なメールアドレスに対してtrueを期待します。');
    }

    /**
     * DNSレコードが存在しないドメインをテストします。
     */
    #[Test]
    public function 無効なメールアドレス_DNSレコードが存在しない()
    {
        $instance = new EmailRule();
        $attribute = 'email';
        $value = sprintf('user@nonexistentdomain.%s.xyz', Str::rand());
        $parameters = $this->createMock(Parameters::class);
        $arguments = ['dns'];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, 'DNSレコードが存在しないドメインの無効なメールアドレスに対してfalseを期待します。');
    }
}
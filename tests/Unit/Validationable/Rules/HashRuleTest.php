<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\HashRule;

class HashRuleTest extends TestCase
{
    /**
     * HashRule::passes() メソッドの正常系（md5検証が成功する場合）をテストします。
     */
    #[Test]
    public function md5ハッシュが正しい場合は成功する()
    {
        $instance = new HashRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('attribute', 'd41d8cd98f00b204e9800998ecf8427e', $params, ['md5']);
        $this->assertTrue($actual, 'md5ハッシュが正しい場合、passesはtrueを返す必要があります');
    }

    /**
     * HashRule::passes() メソッドの異常系（md5検証が失敗する場合）をテストします。
     */
    #[Test]
    public function md5ハッシュが正しくない場合は失敗する()
    {
        $instance = new HashRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('attribute', 'invalidhash', $params, ['md5']);
        $this->assertFalse($actual, 'md5ハッシュが正しくない場合、passesはfalseを返す必要があります');
    }

    /**
     * HashRule::passes() メソッドの正常系（sha1検証が成功する場合）をテストします。
     */
    #[Test]
    public function sha1ハッシュが正しい場合は成功する()
    {
        $instance = new HashRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('attribute', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', $params, ['sha1']);
        $this->assertTrue($actual, 'sha1ハッシュが正しい場合、passesはtrueを返す必要があります');
    }

    /**
     * HashRule::passes() メソッドの異常系（sha1検証が失敗する場合）をテストします。
     */
    #[Test]
    public function sha1ハッシュが正しくない場合は失敗する()
    {
        $instance = new HashRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('attribute', 'invalidhash', $params, ['sha1']);
        $this->assertFalse($actual, 'sha1ハッシュが正しくない場合、passesはfalseを返す必要があります');
    }

    /**
     * HashRule::passes() メソッドの正常系（sha256検証が成功する場合）をテストします。
     */
    #[Test]
    public function sha256ハッシュが正しい場合は成功する()
    {
        $instance = new HashRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('attribute', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', $params, ['sha256']);
        $this->assertTrue($actual, 'sha256ハッシュが正しい場合、passesはtrueを返す必要があります');
    }

    /**
     * HashRule::passes() メソッドの異常系（sha256検証が失敗する場合）をテストします。
     */
    #[Test]
    public function sha256ハッシュが正しくない場合は失敗する()
    {
        $instance = new HashRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('attribute', 'invalidhash', $params, ['sha256']);
        $this->assertFalse($actual, 'sha256ハッシュが正しくない場合、passesはfalseを返す必要があります');
    }

    /**
     * HashRule::passes() メソッドの正常系（bcrypt検証が成功する場合）をテストします。
     */
    #[Test]
    public function bcryptハッシュが正しい場合は成功する()
    {
        $instance = new HashRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('attribute', '$2y$12$wSP4gNWDhJRkJ5TQo27QqOVfr3YiqeIXxN1nLx987DeTGL.DXnmZe', $params, ['bcrypt']);
        $this->assertTrue($actual, 'bcryptハッシュが正しい場合、passesはtrueを返す必要があります');
    }

    /**
     * HashRule::passes() メソッドの異常系（bcrypt検証が失敗する場合）をテストします。
     */
    #[Test]
    public function bcryptハッシュが正しくない場合は失敗する()
    {
        $instance = new HashRule();
        $params = $this->createParameter([]);
        $actual = $instance->passes('attribute', 'invalidhash', $params, ['bcrypt']);
        $this->assertFalse($actual, 'bcryptハッシュが正しくない場合、passesはfalseを返す必要があります');
    }

    /**
     * HashRule::passes() メソッドの異常系（未定義のハッシュアルゴリズムの場合）をテストします。
     */
    #[Test]
    public function 未定義のアルゴリズムを指定した場合は例外をスローする()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('An undefined hashing algorithm was detected.');
        $params = $this->createParameter([]);
        $instance = new HashRule();
        $instance->passes('attribute', 'somevalue', $params, ['undefined']);
    }
}
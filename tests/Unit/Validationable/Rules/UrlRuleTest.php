<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\UrlRule;

class UrlRuleTest extends TestCase
{
    #[Test]
    public function 有効なHTTPプロトコルをテストします()
    {
        // テスト対象のインスタンス
        $instance = new UrlRule();

        // テストするURL
        $value = "http://example.com";

        // 比較対象

        $params = $this->createParameter([]);
        // 実際のテスト結果
        $actual = $instance->passes("url", $value, $params);

        // アサーション (失敗メッセージを含む)
        $this->assertTrue($actual, "HTTP プロトコルのURLが有効であるべきです: $value");
    }

    #[Test]
    public function 有効なHTTPSプロトコルをテストします()
    {
        $instance = new UrlRule();
        $value = "https://example.com";
        $params = $this->createParameter([]);
        $actual = $instance->passes("url", $value, $params);
        $this->assertTrue($actual, "HTTPS プロトコルのURLが有効であるべきです: $value");
    }

    #[Test]
    public function 無効なプロトコルを持つURLをテストします()
    {
        $instance = new UrlRule();
        $value = "abcd://example.com";
        $params = $this->createParameter([]);
        $actual = $instance->passes("url", $value, $params);
        $this->assertFalse($actual, "無効なプロトコルのURLは失敗すべきです: $value");
    }

    #[Test]
    public function ドメイン無しのURLをテストします()
    {
        $instance = new UrlRule();
        $value = "http://";
        $params = $this->createParameter([]);
        $actual = $instance->passes("url", $value, $params);
        $this->assertFalse($actual, "ドメインが欠けているURLは失敗すべきです: $value");
    }

    #[Test]
    public function 有効なFTPプロトコルをテストします()
    {
        $instance = new UrlRule();
        $value = "ftp://example.com";
        $params = $this->createParameter([]);
        $actual = $instance->passes("url", $value, $params);
        $this->assertTrue($actual, "FTP プロトコルのURLが有効であるべきです: $value");
    }

    #[Test]
    public function カスタムプロトコルを含むURLをテストします()
    {
        $instance = new UrlRule();
        $value = "custom://example.com";
        $params = $this->createParameter([]);
        $actual = $instance->passes("url", $value, $params, ["custom"]);
        $this->assertTrue($actual, "カスタムプロトコルのURLが有効であるべきです: $value");
    }

    #[Test]
    public function IPアドレスを含むURLをテストします()
    {
        $instance = new UrlRule();
        $value = "http://192.168.0.1";
        $params = $this->createParameter([]);
        $actual = $instance->passes("url", $value, $params);
        $this->assertTrue($actual, "IPアドレスを使用したURLが有効であるべきです: $value");
    }

    #[Test]
    public function 無効な形式のIPアドレスをテストします()
    {
        $instance = new UrlRule();
        $value = "http://999.999.999.999";
        $params = $this->createParameter([]);
        $actual = $instance->passes("url", $value, $params);
        $this->assertFalse($actual, "無効な形式のIPアドレスを含むURLは失敗すべきです: $value");
    }

    #[Test]
    public function ポート番号付きのURLをテストします()
    {
        $instance = new UrlRule();
        $value = "http://example.com:8080";
        $params = $this->createParameter([]);
        $actual = $instance->passes("url", $value, $params);
        $this->assertTrue($actual, "ポート番号を含むURLが有効であるべきです: $value");
    }

    #[Test]
    public function クエリ文字列を含むURLをテストします()
    {
        $instance = new UrlRule();
        $value = "http://example.com?query=param";
        $params = $this->createParameter([]);
        $actual = $instance->passes("url", $value, $params);
        $this->assertTrue($actual, "クエリ文字列を含むURLが有効であるべきです: $value");
    }
}
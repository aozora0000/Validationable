<?php

namespace Tests\Unit\Validationable\Helpers;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Helpers\Proxy;

class ProxyTest extends TestCase
{
    /**
     * Proxyクラスの__callメソッドがターゲットオブジェクトのメソッドを正しく呼び出せるかテストします。
     */
    #[Test]
    public function ターゲットオブジェクトのメソッドが呼び出されること(): void
    {
        // テスト対象のクラスを定義
        $target = new class {
            public string $greeting = '';

            public function setGreeting(string $value): void
            {
                $this->greeting = $value;
            }
        };
        $instance = new Proxy($target);

        // 実行と結果の確認
        $actual = $instance->__call('setGreeting', ['こんにちは']);
        $expected = $target;

        self::assertSame($expected, $actual, 'ターゲットオブジェクトが返されること');
        self::assertSame('こんにちは', $target->greeting, 'ターゲットオブジェクトのメソッドが正しく呼び出されること');
    }

    /**
     * Proxyクラスの__callメソッドで存在しないターゲットメソッドを呼び出した場合にエラーがスローされるかテストします。
     */
    #[Test]
    public function 存在しないメソッド呼び出しでエラーがスローされること(): void
    {
        // テスト対象のクラスを定義
        $target = new class {
        };
        $instance = new Proxy($target);

        // エラーハンドリングとテスト
        $this->expectException(\Error::class);
        $this->expectExceptionMessage('Call to undefined method class@anonymous::nonExistentMethod()');

        $instance->__call('nonExistentMethod', []);
    }

    /**
     * Proxyクラスのtapメソッドがコールバックを適用し、値を返すことをテストします。
     */
    #[Test]
    public function コールバックが適用され値が返されること(): void
    {
        $target = 'こんにちは';
        // 実行と結果の確認
        $actual = Proxy::tap($target, function (&$value) {
            $value .= '、世界！';
        });
        $expected = 'こんにちは、世界！';

        self::assertSame($expected, $actual, 'tapで値が加工され正しく返されること');
    }

    /**
     * Proxyクラスのtapメソッドでコールバックなしの場合、Proxyインスタンスが返されることをテストします。
     */
    #[Test]
    public function コールバックなしでProxyインスタンスが返されること(): void
    {
        $target = 'テスト対象';

        // 実行と結果の確認
        $actual = Proxy::tap($target);
        $expected = Proxy::class;

        self::assertInstanceOf($expected, $actual, 'コールバックなしでProxyインスタンスが返されること');
    }
}
<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Parameters;
use Validationable\Rules\SingularRule;

class SingularRuleTest extends TestCase
{
    /**
     * SingularRule::passes メソッドテスト
     * 名詞が複数形として評価され、単数形に変換可能な場合に true を返すか確認
     */
    #[Test]
    public function 名詞が複数形の場合に単数形に変換可能な場合はtrueを返す()
    {
        $instance = new SingularRule();
        $attribute = 'word';
        $value = 'cars'; // 複数形として評価
        $parameters = $this->createParameter([]);
        $arguments = ['en']; // 英語の文法ルールを使用

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertTrue($actual, '複数形の名詞が正しく単数形に変換されなかった');
    }

    /**
     * SingularRule::passes メソッドテスト
     * 名詞が既に単数形の場合に false を返すか確認
     */
    #[Test]
    public function 単数形の名詞の場合はfalseを返す()
    {
        $instance = new SingularRule();
        $attribute = 'word';
        $value = 'car'; // 単数形として認識される例
        $parameters = $this->createParameter([]);
        $arguments = ['en']; // 英語の文法ルールを使用

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, '単数形の名詞が誤って変換されました');
    }

    /**
     * SingularRule::passes メソッドテスト
     * 値が文字列でない場合に false を返すか確認
     */
    #[Test]
    public function 非文字列の値の場合はfalseを返す()
    {
        $instance = new SingularRule();
        $attribute = 'word';
        $value = 123; // 数値は文字列として扱われない例
        $parameters = $this->createParameter([]);
        $arguments = ['en'];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, '非文字列の値が正しく拒否されなかった');
    }

    /**
     * SingularRule::passes メソッドテスト
     * 空の値に対して false を返すか確認
     */
    #[Test]
    public function 空の値の場合はfalseを返す()
    {
        $instance = new SingularRule();
        $attribute = 'word';
        $value = ''; // 空文字列
        $parameters = $this->createParameter([]);
        $arguments = ['en'];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, '空文字列が正しく拒否されなかった');
    }

    /**
     * SingularRule::passes メソッドテスト
     * 不明な言語コードを指定し、デフォルトの英語ルールを適用するか確認
     */
    #[Test]
    public function 不明な言語コードの場合にデフォルトでtrueを返す()
    {
        $instance = new SingularRule();
        $attribute = 'word';
        $value = 'mice'; // 英語ルールの複数形
        $parameters = $this->createParameter([]);
        $arguments = ['unknown']; // 不明な言語

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertTrue($actual, 'デフォルトの英語ルールが適用されませんでした');
    }
}
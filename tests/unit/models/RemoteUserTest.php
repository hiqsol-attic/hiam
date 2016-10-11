<?php

namespace hiam\tests\units\models;

use hiam\models\RemoteUser;

class RemoteUserTest extends \PHPUnit_Framework_TestCase
{
    use \yii\test\FixtureTrait;

    public function fixtures()
    {
        return [
            'users' => RemoteUserFixture::class,
        ];
    }

    public function testToProvider()
    {
        $this->assertSame('g', RemoteUser::toProvider('google'));
        $this->assertSame('f', RemoteUser::toProvider('facebook'));
        $this->assertSame('l', RemoteUser::toProvider('linkedin'));
        $this->assertSame('h', RemoteUser::toProvider('github'));
        $this->assertSame('v', RemoteUser::toProvider('vk'));
        $this->assertSame('y', RemoteUser::toProvider('yandex'));
        $this->assertSame('w', RemoteUser::toProvider('live'));

        $this->assertSame('g', RemoteUser::toProvider('g'));
        $this->assertSame('f', RemoteUser::toProvider('f'));
        $this->assertSame('l', RemoteUser::toProvider('l'));
        $this->assertSame('h', RemoteUser::toProvider('h'));
        $this->assertSame('v', RemoteUser::toProvider('v'));
        $this->assertSame('y', RemoteUser::toProvider('y'));
        $this->assertSame('w', RemoteUser::toProvider('w'));

        $this->assertSame(null, RemoteUser::toProvider('gogogo'));
        $this->assertSame(null, RemoteUser::toProvider('1'));
        $this->assertSame(null, RemoteUser::toProvider(''));
    }

    public function no_testIsTrustedEmail()
    {
        $model = new RemoteUser(['provider' => 'g']);
        var_dump($model);die();

        $this->assertTrue ($model->isTrustedEmail('some@gmail.com'));
        $this->assertFalse($model->isTrustedEmail('some@other.com'));

        $this->assertTrue ($model->isTrustedEmail('some@yandex.ru'));
        $this->assertFalse($model->isTrustedEmail('some@other.com'));
    }
}

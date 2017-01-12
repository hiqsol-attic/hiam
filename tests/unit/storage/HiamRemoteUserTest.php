<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiam\tests\units\storage;

use hiam\storage\HiamRemoteUser;

class HiamRemoteUserTest extends \PHPUnit_Framework_TestCase
{
    public function testToProvider()
    {
        $class = HiamRemoteUser::class;
        $this->assertSame('g', $class::toProvider('google'));
        $this->assertSame('f', $class::toProvider('facebook'));
        $this->assertSame('l', $class::toProvider('linkedin'));
        $this->assertSame('h', $class::toProvider('github'));
        $this->assertSame('v', $class::toProvider('vk'));
        $this->assertSame('y', $class::toProvider('yandex'));
        $this->assertSame('w', $class::toProvider('live'));

        $this->assertSame('g', $class::toProvider('g'));
        $this->assertSame('f', $class::toProvider('f'));
        $this->assertSame('l', $class::toProvider('l'));
        $this->assertSame('h', $class::toProvider('h'));
        $this->assertSame('v', $class::toProvider('v'));
        $this->assertSame('y', $class::toProvider('y'));
        $this->assertSame('w', $class::toProvider('w'));

        $this->assertSame(null, $class::toProvider('gogogo'));
        $this->assertSame(null, $class::toProvider('1'));
        $this->assertSame(null, $class::toProvider(''));
    }

    public function no_testIsTrustedEmail()
    {
        $model = new HiamRemoteUser(['provider' => 'g']);

        $this->assertTrue($model->isTrustedEmail('some@gmail.com'));
        $this->assertFalse($model->isTrustedEmail('some@other.net'));

        $this->assertTrue($model->isTrustedEmail('some@yandex.ru'));
        $this->assertFalse($model->isTrustedEmail('some@other.net'));
    }
}

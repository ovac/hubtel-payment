<?php

namespace OVAC/HubtelPayment\Tests\Unit;

use OVAC/HubtelPayment\HelloWorld;

class HelloWorldTest extends \PHPUnit_Framework_TestCase
{
    public function testSayHi()
    {
        $hello = new HelloWorld('hal9087');
        $this->assertEquals('Hello hal9087!', $hello->sayHi());
    }
}

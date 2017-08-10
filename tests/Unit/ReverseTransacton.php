<?php

/**
 * @package     OVAC/Hubtel-Payment
 * @version     1.0.0
 * @link        https://github.com/ovac/hubtel-payment
 *
 * @author      Ariama O. Victor (OVAC) <contact@ovac4u.com>
 * @link        http://ovac4u.com
 *
 * @license     https://github.com/ovac/hubtel-payment/blob/master/LICENSE
 * @copyright   (c) 2017, Rescope Inc
 */

namespace OVAC\HubtelPayment\Tests\Unit;

use OVAC\HubtelPayment\HelloWorld;

class ReverseTransaction extends \PHPUnit_Framework_TestCase
{
    public function testSayHi()
    {
        $hello = new HelloWorld('hal9087');
        $this->assertEquals('Hello hal9087!', $hello->sayHi());
    }
}

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

use Mockery as m;
use OVAC\HubtelPayment\Config;
use OVAC\HubtelPayment\Pay;

class PayTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The Stripe API client instance.
     *
     * @var \Cartalyst\Stripe\Stripe
     */
    protected $instance;
    /**
     * Setup resources and dependencies
     *
     * @return void
     */
    public function setUp()
    {
        $this->instance = new Pay([
            'accountNumber' => 12345,
            'clientId' => 'someClientId',
            'clientSecret' => 'someClientSecret',
        ]);
    }
    /**
     * Close mockery.
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }
    /** @test */
    public function testCreateNewInstanceUsingTheMakeMethod()
    {
        $pay = Pay::make([
            'accountNumber' => 12345,
            'clientId' => 'someClientId',
            'clientSecret' => 'someClientSecret',
        ]);

        $this->assertEquals($pay->getAccountNumber(), 12345, 'Acout Numbe should be 12345');
        $this->assertEquals($pay->getClientId(), 'someClientId', 'Client ID should be someClientId');
        $this->assertEquals($pay->getClientSecret(), 'someClientSecret', 'Client Secret should be someClientSecret');
        $this->assertEquals($pay->getPackageVersion(), Pay::VERSION, 'Package Version should be' . Pay::VERSION);
    }

    public function testGetPackageVersion()
    {
        $pay = new Pay;
        $this->assertEquals($pay->getPackageVersion(), '2.1.0');
    }

    public function testSetPackageVersion()
    {
        $pay = new Pay;
        $newVersion = '10.0.0';
        $pay->setPackageVersion($newVersion);

        $this->assertEquals($pay->getPackageVersion(), $newVersion);
    }

    public function testNewPayInstanceWithArray()
    {
        $pay = new Pay([
            'accountNumber' => 12345,
            'clientId' => 'someClientId',
            'clientSecret' => 'someClientSecret',
        ]);

        $this->assertEquals($pay->getAccountNumber(), 12345, 'Acout Numbe should be 12345');
        $this->assertEquals($pay->getClientId(), 'someClientId', 'Client ID should be someClientId');
        $this->assertEquals($pay->getClientSecret(), 'someClientSecret', 'Client Secret should be someClientSecret');
    }

    public function testNewPayInstanceWithMakeArray()
    {
        $pay = Pay::make([
            'accountNumber' => 12345,
            'clientId' => 'someClientId',
            'clientSecret' => 'someClientSecret',
        ]);

        $this->assertEquals($pay->getAccountNumber(), 12345, 'Acout Numbe should be 12345');
        $this->assertEquals($pay->getClientId(), 'someClientId', 'Client ID should be someClientId');
        $this->assertEquals($pay->getClientSecret(), 'someClientSecret', 'Client Secret should be someClientSecret');
        $this->assertEquals($pay->getPackageVersion(), Pay::VERSION, 'Package Version should be' . Pay::VERSION);
    }

    public function testNewPayInstanceWithValues()
    {
        $pay = new Pay($accountNumber = 12345, $clientId = 'someClientId', $clientSecret = 'someClientSecret');

        $this->assertEquals($pay->getAccountNumber(), 12345, 'Acout Numbe should be 12345');
        $this->assertEquals($pay->getClientId(), 'someClientId', 'Client ID should be someClientId');
        $this->assertEquals($pay->getClientSecret(), 'someClientSecret', 'Client Secret should be someClientSecret');
        $this->assertEquals($pay->getPackageVersion(), Pay::VERSION, 'Package Version should be' . Pay::VERSION);
    }

    public function testConstructAndSetConfigInline()
    {
        $pay = new Pay;
        $pay->setAccountNumber(12345)
            ->setClientId('someClientId')
            ->setClientSecret('someClientSecret');

        $this->assertEquals($pay->getAccountNumber(), 12345, 'Acout Numbe should be 12345');
        $this->assertEquals($pay->getClientId(), 'someClientId', 'Client ID should be someClientId');
        $this->assertEquals($pay->getClientSecret(), 'someClientSecret', 'Client Secret should be someClientSecret');
        $this->assertEquals($pay->getPackageVersion(), Pay::VERSION, 'Package Version should be' . Pay::VERSION);
    }

    public function testSetConfig()
    {
        $pay = new Pay;

        $config = new Config(
            Pay::VERSION,
            $accountNumber = 12345,
            $clientId = 'someClientId',
            $clientSecret = 'someClientSecret'
        );

        $pay->setConfig($config);

        $this->assertEquals($pay->getAccountNumber(), 12345, 'Acout Numbe should be 12345');
        $this->assertEquals($pay->getClientId(), 'someClientId', 'Client ID should be someClientId');
        $this->assertEquals($pay->getClientSecret(), 'someClientSecret', 'Client Secret should be someClientSecret');
        $this->assertEquals($pay->getPackageVersion(), Pay::VERSION, 'Package Version should be' . Pay::VERSION);
    }

    public function testGetConfig()
    {
        $pay = new Pay;

        $config = new Config(
            Pay::VERSION,
            $accountNumber = 12345,
            $clientId = 'someClientId',
            $clientSecret = 'someClientSecret'
        );

        $pay->setConfig($config);

        $this->assertEquals($config, $pay->getConfig(), 'The config property should be equal to the setConfig value');
    }

    public function testApiMagicMethod()
    {
        //TODO: Test for Magic Method Calls to the API Methods
    }

    public function testApiMagicStaticMethod()
    {
        //TODO: Test for Static to Instance Magic Calls to the API Methods
    }
}

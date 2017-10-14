<?php

/**
 * @package     OVAC/Hubtel-Payment
 * @link        https://github.com/ovac/hubtel-payment
 *
 * @author      Ariama O. Victor (OVAC) <contact@ovac4u.com>
 * @link        http://ovac4u.com
 *
 * @license     https://github.com/ovac/hubtel-payment/blob/master/LICENSE
 * @copyright   (c) 2017, RescopeNet, Inc
 */

namespace OVAC\HubtelPayment\Tests\Unit;

use Mockery as m;
use OVAC\HubtelPayment\Api\Transaction\ReceiveMoney;
use OVAC\HubtelPayment\Api\Transaction\SendMoney;
use OVAC\HubtelPayment\Config;
use OVAC\HubtelPayment\Pay;
use PHPUnit\Framework\TestCase;

class PayTest extends TestCase
{

    /**
     * The OVAC/Hubtel-Payment Pay config.
     *
     * @var \OVAC\Hubtel\Config
     */
    protected $config;
    /**
     * Setup resources and dependencies
     *
     * @return void
     */
    public function setUp()
    {
        $this->config = new Config(
            $accountNumber = 12345,
            $clientId = 'someClientId',
            $clientSecret = 'someClientSecret'
        );
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

    public function testCreateNewInstanceUsingTheMakeMethod()
    {
        $pay = Pay::make([
            'accountNumber' => 12345,
            'clientId' => 'someClientId',
            'clientSecret' => 'someClientSecret',
        ]);

        $this->assertEquals($pay->getAccountNumber(), 12345, 'Account Numbe should be 12345');
        $this->assertEquals($pay->getClientId(), 'someClientId', 'Client ID should be someClientId');
        $this->assertEquals($pay->getClientSecret(), 'someClientSecret', 'Client Secret should be someClientSecret');
        $this->assertEquals($pay->getPackageVersion(), Pay::VERSION, 'Package Version should be' . Pay::VERSION);
    }

    public function testGetPackageVersion()
    {
        $pay = new Pay;
        $this->assertEquals($pay->getPackageVersion(), Pay::VERSION);
    }

    public function testSetPackageVersion()
    {
        $pay = new Pay;
        $newVersion = Pay::VERSION;
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

        $pay->setConfig($this->config);

        $this->assertEquals($this->config, $pay->getConfig(), 'The config property should be equal to the setConfig value');
    }

    public function testApiStaticMagicMethod()
    {
        $sendMoney = Pay::sendMoney()->to('0553577261');
        $receiveMoney = Pay::receiveMoney()->from('0553577261');

        $this->assertInstanceOf(SendMoney::class, $sendMoney, 'The pay class should create config of SendMoney class');
        $this->assertInstanceOf(ReceiveMoney::class, $receiveMoney, 'The pay class should create config of ReceiveMoney class');
    }

    public function testApiMagicMethod()
    {
        $receiveMoney = (new Pay)->receiveMoney();

        $this->assertInstanceOf(ReceiveMoney::class, $receiveMoney);
    }

    public function testApiMagicMethodBadMethod()
    {
        $this->expectException(\BadMethodCallException::class);
        (new Pay)->some_unexisting_random_method();
    }
}

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
    public function it_can_create_a_new_instance_using_the_make_method()
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
    /** @test */
    // public function it_can_create_a_new_instance_using_enviroment_variables()
    // {
    //     $stripe = new Stripe;
    //     $this->assertEquals(getenv('STRIPE_API_KEY'), $stripe->getApiKey());
    //     $this->assertEquals(getenv('STRIPE_API_VERSION'), $stripe->getApiVersion());
    // }
    // /** @test */
    // public function it_can_get_and_set_the_api_key()
    // {
    //     $this->stripe->setApiKey('new-stripe-api-key');
    //     $this->assertEquals('new-stripe-api-key', $this->stripe->getApiKey());
    // }
    // /**
    //  * @test
    //  * @expectedException \RuntimeException
    //  */
    // public function it_throws_an_exception_when_the_api_key_is_not_set()
    // {
    //     // Unset the environment variable
    //     putenv('STRIPE_API_KEY');
    //     new Stripe;
    // }
    // /** @test */
    // public function it_can_get_and_set_the_api_version()
    // {
    //     $this->stripe->setApiVersion('2014-03-28');
    //     $this->assertEquals('2014-03-28', $this->stripe->getApiVersion());
    // }
    // /** @test */
    // public function it_can_get_the_current_package_version()
    // {
    //     $this->stripe->getVersion();
    // }
    // /** @test */
    // public function it_can_get_and_set_the_amount_converter()
    // {
    //     $this->assertEquals('\\Cartalyst\\Stripe\\AmountConverter::convert', $this->stripe->getAmountConverter());
    //     $this->stripe->setAmountConverter('\\Cartalyst\\Stripe\\AmountConverter::convert');
    //     $this->assertEquals('\\Cartalyst\\Stripe\\AmountConverter::convert', $this->stripe->getAmountConverter());
    // }
    // /** @test */
    // public function it_can_create_requests()
    // {
    //     $this->stripe->customers();
    // }
    // /**
    //  * @test
    //  * @expectedException \BadMethodCallException
    //  */
    // public function it_throws_an_exception_when_the_request_is_invalid()
    // {
    //     $this->stripe->foo();
    // }

    // public function testGetPackageVersion()
    // {
    //     $pay = new Pay;
    //     $this->assertEquals($pay->getPackageVersion(), '2.1.0');
    // }

    // public function testSetPackageVersion()
    // {
    //     $pay = new Pay;
    //     $newVersion = '10.0.0';
    //     $pay->setPackageVersion($newVersion);

    //     $this->assertEquals($pay->getPackageVersion(), $newVersion);
    // }

    // public function testNewPayInstanceWithArray()
    // {
    //     $pay = new Pay([
    //         'accountNumber' => 12345,
    //         'clientId' => 'someClientId',
    //         'clientSecret' => 'someClientSecret',
    //     ]);

    //     $this->assertEquals($pay->getAccountNumber(), 12345, 'Acout Numbe should be 12345');
    //     $this->assertEquals($pay->getClientId(), 'someClientId', 'Client ID should be someClientId');
    //     $this->assertEquals($pay->getClientSecret(), 'someClientSecret', 'Client Secret should be someClientSecret');
    // }

    // public function testNewPayInstanceWithMakeArray()
    // {
    //     $pay = Pay::make([
    //         'accountNumber' => 12345,
    //         'clientId' => 'someClientId',
    //         'clientSecret' => 'someClientSecret',
    //     ]);

    //     $this->assertEquals($pay->getAccountNumber(), 12345, 'Acout Numbe should be 12345');
    //     $this->assertEquals($pay->getClientId(), 'someClientId', 'Client ID should be someClientId');
    //     $this->assertEquals($pay->getClientSecret(), 'someClientSecret', 'Client Secret should be someClientSecret');
    //     $this->assertEquals($pay->getPackageVersion(), Pay::VERSION, 'Package Version should be' . Pay::VERSION);
    // }

    // public function testNewPayInstanceWithValues()
    // {
    //     $pay = new Pay($accountNumber = 12345, $clientId = 'someClientId', $clientSecret = 'someClientSecret');

    //     $this->assertEquals($pay->getAccountNumber(), 12345, 'Acout Numbe should be 12345');
    //     $this->assertEquals($pay->getClientId(), 'someClientId', 'Client ID should be someClientId');
    //     $this->assertEquals($pay->getClientSecret(), 'someClientSecret', 'Client Secret should be someClientSecret');
    //     $this->assertEquals($pay->getPackageVersion(), Pay::VERSION, 'Package Version should be' . Pay::VERSION);
    // }

    // public function testConstructAndSetConfigInline()
    // {
    //     $pay = new Pay;
    //     $pay->setAccountNumber(12345)
    //         ->setClientId('someClientId')
    //         ->setClientSecret('someClientSecret');

    //     $this->assertEquals($pay->getAccountNumber(), 12345, 'Acout Numbe should be 12345');
    //     $this->assertEquals($pay->getClientId(), 'someClientId', 'Client ID should be someClientId');
    //     $this->assertEquals($pay->getClientSecret(), 'someClientSecret', 'Client Secret should be someClientSecret');
    //     $this->assertEquals($pay->getPackageVersion(), Pay::VERSION, 'Package Version should be' . Pay::VERSION);
    // }

    // public function testSetConfig()
    // {
    //     $pay = new Pay;

    //     $config = new Config(
    //         Pay::VERSION,
    //         $accountNumber = 12345,
    //         $clientId = 'someClientId',
    //         $clientSecret = 'someClientSecret'
    //     );

    //     $pay->setConfig($config);

    //     $this->assertEquals($pay->getAccountNumber(), 12345, 'Acout Numbe should be 12345');
    //     $this->assertEquals($pay->getClientId(), 'someClientId', 'Client ID should be someClientId');
    //     $this->assertEquals($pay->getClientSecret(), 'someClientSecret', 'Client Secret should be someClientSecret');
    //     $this->assertEquals($pay->getPackageVersion(), Pay::VERSION, 'Package Version should be' . Pay::VERSION);
    // }

    // public function testGetConfig()
    // {
    //     $pay = new Pay;

    //     $config = new Config(
    //         Pay::VERSION,
    //         $accountNumber = 12345,
    //         $clientId = 'someClientId',
    //         $clientSecret = 'someClientSecret'
    //     );

    //     $pay->setConfig($config);

    //     $this->assertEquals($config, $pay->getConfig(), 'The config property should be equal to the setConfig value');
    // }

    // public function testApiMagicMethod()
    // {
    //     //TODO: Test for Magic Method Calls to the API Methods
    // }

    // public function testApiMagicStaticMethod()
    // {
    //     //TODO: Test for Static to Instance Magic Calls to the API Methods
    // }
}

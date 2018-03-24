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

namespace OVAC\HubtelPayment\Tests\Unit\Api\Transaction;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use OVAC\HubtelPayment\Api\Api;
use OVAC\HubtelPayment\Api\Transaction\SendMoney;
use OVAC\HubtelPayment\Config;
use OVAC\HubtelPayment\Exception\MissingParameterException;
use OVAC\HubtelPayment\Pay;
use OVAC\HubtelPayment\Utility\HubtelHandler;
use PHPUnit\Framework\TestCase;

class SendMoneyTest extends TestCase
{
    /**
     * The name of the customer.
     *
     * @var string
     */
    private $customerName;
    /**
     * The customer email address
     *
     * @var string
     */
    private $customerEmail;
    /**
     * The customer mobile money number.
     *
     * @var string
     */
    private $customerMsisdn;
    /**
     * The mobile money provider channel
     *
     * @var string
     */
    private $channel;
    /**
     * The mobile money transaction amount
     *
     * @var string
     */
    private $amount;
    /**
     * A callback URL to receive the transaction
     * status from Hubtel to your API request.
     * Receive  money requests for all mobile
     * money providers are asynchrounous hence,
     * Hubtel will send a callback on  the f
     * inal status of a pending transaction
     *
     * @var string
     */
    private $primaryCallbackURL;
    /**
     * The second URL for callback response in the
     * event of failure of  primary callback URL.
     *
     * @var string
     */
    private $secondaryCallbackURL;
    /**
     * The reference number that is provided by you
     * to reference a transaction from your end.
     *
     * @var string
     */
    private $clientReference;
    /**
     * The short description of the transaction.
     *
     * @var string
     */
    private $description;
    /**
     * The OVAC/Hubtel-Payment Pay config.
     *
     * @var \OVAC\Hubtel\Config
     */
    protected $config;

    protected function setUp()
    {

        $this->ammount = 10.89;
        $this->channel = 'mtn-gh';

        $this->description = 'Money for some trash like that oh';

        $this->customerMsisdn = '+233553577261';
        $this->customerName = 'Ariama Victor';
        $this->customerEmail = 'contact@ovac4u.com';

        $this->clientReference = array('userId' => 14028);

        $this->primaryCallbackURL = 'http://www.ovac4u.com/payment/payment-success';
        $this->secondaryCallbackURL = 'http://www.ovac4u.com/payment/payment-failed';

        $this->config = new Config(
            $accountNumber = 12345,
            $clientId = 'someClientId',
            $clientSecret = 'someClientSecret'
        );
    }

    public function checkValues($api)
    {
        $this->assertEquals($api->getAmount(), $this->amount, 'The Amount on instance should be the amount charged');
        $this->assertEquals($api->getDescription(), $this->description, 'it should be the description passed in');
        $this->assertEquals($api->getCustomerMsisdn(), $this->customerMsisdn, 'it should be the reference passed in');
        $this->assertEquals($api->getClientReference(), $this->clientReference, 'it should be the reference passed in');
        $this->assertEquals($api->getCustomerName(), $this->customerName, 'it should be the customer name passed in');
        $this->assertEquals($api->getCustomerEmail(), $this->customerEmail, 'it should be the Email passed in');
        $this->assertEquals($api->getChannel(), $this->channel, 'it should be the same channel passed in');
        $this->assertEquals($api->getSecondaryCallbackURL(), $this->secondaryCallbackURL, 'it should be the error callback URL');
        $this->assertEquals($api->getPrimaryCallbackURL(), $this->primaryCallbackURL, 'it should be the success callback URL');
    }

    public function testExpressiveSendMoney()
    {
        $api = SendMoney::amount($this->amount)
            ->to($this->customerMsisdn)
            ->description($this->description)
            ->reference($this->clientReference)
            ->customerName($this->customerName)
            ->customerEmail($this->customerEmail)
            ->channel($this->channel)
            ->callbackOnFail($this->secondaryCallbackURL)
            ->callbackOnSuccess($this->primaryCallbackURL);

        $this->checkValues($api);

        return $api;
    }

    public function testExpressiveSendMoneyV2()
    {
        $api = SendMoney::amount($this->amount)
            ->to($this->customerMsisdn)
            ->description($this->description)
            ->reference($this->clientReference)
            ->customerName($this->customerName)
            ->customerEmail($this->customerEmail)
            ->channel($this->channel)
            ->callbackOnFail($this->secondaryCallbackURL)
            ->callbackOnSuccess($this->primaryCallbackURL);

        $this->checkValues($api);

        return $api;
    }

    /**
     * @covers OVAC\HubtelPayment\Api\Transaction\MassAssignable::massAssign
     */
    public function testConstructSendMoneyMassAssignment()
    {
        $api = new SendMoney(array(
            'customer' => array(
                'name' => $this->customerName,
                'email' => $this->customerEmail,
                'phone' => $this->customerMsisdn,
            ),
            'callback' => array(
                'success' => $this->primaryCallbackURL,
                'error' => $this->secondaryCallbackURL,
            ),
            'description' => $this->description,
            'clientReference' => $this->clientReference,
            'channel' => $this->channel,
            'amount' => $this->amount,
        ));

        $this->checkValues($api);
    }

    public function testPayCanMassAssignSendMoney()
    {
        $api = Pay::sendMoney(array(
            'customer' => array(
                'name' => $this->customerName,
                'email' => $this->customerEmail,
                'phone' => $this->customerMsisdn,
            ),
            'callback' => array(
                'success' => $this->primaryCallbackURL,
                'error' => $this->secondaryCallbackURL,
            ),
            'description' => $this->description,
            'clientReference' => $this->clientReference,
            'channel' => $this->channel,
        ));

        $this->checkValues($api);
    }

    public function testMakeMassAssignmentOnSendMoney()
    {
        $api = (new SendMoney($this->config))->make(array(
            'customer' => array(
                'name' => $this->customerName,
                'email' => $this->customerEmail,
                'phone' => $this->customerMsisdn,
            ),
            'callback' => array(
                'success' => $this->primaryCallbackURL,
                'error' => $this->secondaryCallbackURL,
            ),
            'description' => $this->description,
            'clientReference' => $this->clientReference,
            'channel' => $this->channel,
        ));

        $this->checkValues($api);
    }

    public function testCallbackAsTextWithMassAssignment()
    {
        $api = (new SendMoney)->make(array(
            'callback' => $this->primaryCallbackURL,
        ));

        $this->assertEquals($api->getSecondaryCallbackURL(), $this->primaryCallbackURL, 'it should be the success callback URL');
        $this->assertEquals($api->getPrimaryCallbackURL(), $this->primaryCallbackURL, 'it should be the success callback URL');
    }

    public function testTransactableMagicMethods()
    {
        $api = SendMoney::to($this->customerMsisdn)->amount($this->amount);
        $this->assertEquals($api->getCustomerMsisdn(), $this->customerMsisdn);
        $this->assertEquals($api->getAmount(), $this->amount);

        $api = (new SendMoney)->to($this->customerMsisdn)->amount($this->amount);
        $this->assertEquals($api->getCustomerMsisdn(), $this->customerMsisdn);
        $this->assertEquals($api->getAmount(), $this->amount);

        $api = (new SendMoney)->amount($this->amount);
        $this->assertEquals($api->getAmount(), $this->amount);
    }

    public function testTransactableStaticBadMethodsException()
    {
        $this->expectException(\BadMethodCallException::class);

        SendMoney::clientReference($this->customerMsisdn);
    }

    public function testBadInstanceMethodException()
    {
        $this->expectException(\BadMethodCallException::class);

        (new SendMoney)->some_bad_method($this->customerMsisdn);
    }

    public function testSetCustomer()
    {
        $api = SendMoney::amount($this->amount)
            ->setCustomer(array(
                'name' => $this->customerName,
                'email' => $this->customerEmail,
                'phone' => $this->customerMsisdn,
            ));

        $this->assertEquals($api->getCustomerMsisdn(), $this->customerMsisdn, 'it should be the reference passed in');
        $this->assertEquals($api->getCustomerName(), $this->customerName, 'it should be the customer name passed in');
        $this->assertEquals($api->getCustomerEmail(), $this->customerEmail, 'it should be the Email passed in');
    }

    public function testMassAssignSetCustomerKeyAsMsisdn()
    {
        $api = SendMoney::amount($this->amount)
            ->setCustomer(array(
                'msisdn' => $this->customerMsisdn,
            ));

        $this->assertEquals($api->getCustomerMsisdn(), $this->customerMsisdn, 'it should be the  customer number passed in');
    }

    public function testMassAssignSetCustomerKeyAsNumber()
    {
        $api = SendMoney::amount($this->amount)
            ->setCustomer(array(
                'number' => $this->customerMsisdn,
            ));

        $this->assertEquals($api->getCustomerMsisdn(), $this->customerMsisdn, 'it should be the customer number passed in');
    }

    public function testSetCallbackAsString()
    {
        $api = (new SendMoney)->callback($this->secondaryCallbackURL);

        $this->assertEquals($api->getSecondaryCallbackURL(), $this->secondaryCallbackURL, 'it should be the error callback URL');
    }

    public function testSetCallbackSimpleKeys()
    {

        $api = SendMoney::to($this->customerMsisdn)
            ->setCallback(array(
                'success' => $this->primaryCallbackURL,
                'error' => $this->secondaryCallbackURL,
            ));
        $this->assertEquals($api->getSecondaryCallbackURL(), $this->secondaryCallbackURL, 'it should be the error callback URL');
        $this->assertEquals($api->getPrimaryCallbackURL(), $this->primaryCallbackURL, 'it should be the success callback URL');
    }

    public function testSetCalbackExpressiveKeys()
    {
        $api = SendMoney::to($this->customerMsisdn)
            ->setCallback(array(
                'callbackOnFail' => $this->secondaryCallbackURL,
                'callbackOnSuccess' => $this->primaryCallbackURL,
            ));

        $this->assertEquals(
            $api->getSecondaryCallbackURL(), $this->secondaryCallbackURL, 'it should be the error callback URL'
        );

        $this->assertEquals(
            $api->getPrimaryCallbackURL(), $this->primaryCallbackURL, 'it should be the success callback URL'
        );
    }

    public function test_run_incomplete_required_throws_error_call()
    {
        $this->expectException(MissingParameterException::class);

        (new SendMoney)->run();
    }

    /**
     * @depends testExpressiveSendMoney
     * @return
     */
    public function test_send_money_e2e($api)
    {
        // putenv("HUBTEL_ACCOUNT_NUMBER={$this->config->getAccountNumber()}");
        // putenv("HUBTEL_CLIENT_ID={$this->config->getClientId()}");
        // putenv("HUBTEL_CLIENT_SECRET={$this->config->getClientSecret()}");
        $api
            ->injectConfig($this->config)
            // ->run()
        ;
        $this->assertEquals($api->getCustomerName(), $this->customerName);
    }

    public function test_send_money_end_2_end_successful()
    {
        $container = [];
        $history = Middleware::history($container);

        $httpMock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], json_encode(['X-Foo' => 'Bar'])),
        ]);

        $handlerStack = (new HubtelHandler($this->config, HandlerStack::create($httpMock)))->createHandler();

        $handlerStack->push($history);

        $mock = $this->getMockBuilder(SendMoney::class)
            ->setMethods(['createHandler'])
            ->getMock();

        $mock->expects($this->once())->method('createHandler')->will($this->returnValue($handlerStack));

        $mock->injectConfig($this->config);

        $mock
            ->to($this->customerMsisdn)
            ->description($this->description)
            ->reference($this->clientReference)
            ->customerName($this->customerName)
            ->customerEmail($this->customerEmail)
            ->channel($this->channel)
            ->callbackOnFail($this->secondaryCallbackURL)
            ->callbackOnSuccess($this->primaryCallbackURL);

        $result = $mock->run();

        $this->assertEquals($result, json_decode(json_encode(['X-Foo' => 'Bar'])));

        $request = $container[0]['request'];

        $this->assertEquals($request->getMethod(), 'POST', 'it should be a post request.');
        $this->assertEquals($request->getUri()->getHost(), 'api.hubtel.com', 'Hostname should be api.hubtel.com');
        $this->assertEquals($request->getHeaderLine('User-Agent'), Pay::CLIENT . ' v' . Pay::VERSION);

        $this->assertEquals($request->getUri()->getScheme(), 'https', 'it should be a https scheme');

        $this->assertContains(
            "https://api.hubtel.com/v1/merchantaccount/merchants/12345/send/mobilemoney",
            $request->getUri()->__toString()
        );

    }

    public function test_end_2_end_error()
    {
        $this->expectException(MissingParameterException::class);

        $httpMock = new MockHandler([
            new Response(400, ['X-Foo' => 'Bar'], json_encode(['ResponseCode' => '4010'])),
        ]);

        $handlerStack = (new HubtelHandler($this->config, HandlerStack::create($httpMock)))->createHandler();

        $mock = $this->getMockBuilder(SendMoney::class)
            ->setMethods(['createHandler'])
            ->getMock();

        $mock->expects($this->once())->method('createHandler')->will($this->returnValue($handlerStack));

        $mock->injectConfig($this->config);

        $mock
            ->to($this->customerMsisdn)
            ->description($this->description)
            ->reference($this->clientReference)
            ->customerName($this->customerName)
            ->customerEmail($this->customerEmail)
            ->channel($this->channel)
            ->callbackOnFail($this->secondaryCallbackURL)
            ->callbackOnSuccess($this->primaryCallbackURL);

        $result = $mock->run();
    }
}

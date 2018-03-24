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
use OVAC\HubtelPayment\Api\Transaction\Refund;
use OVAC\HubtelPayment\Config;
use OVAC\HubtelPayment\Exception\MissingParameterException;
use OVAC\HubtelPayment\Pay;
use OVAC\HubtelPayment\Utility\HubtelHandler;
use PHPUnit\Framework\TestCase;

class RefundTest extends TestCase
{
    /**
     * The unique ID of the mobile money transaction
     * you want to refund
     *
     * @var string
     */
    private $transactionId;
    /**
     * A short description of your reason
     * for refunding the mobile money wallet
     *
     * @var string
     */
    private $reason;
    /**
     * The customer mobile money number.
     *
     * @var string
     */
    private $customerMsisdn;
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
     * The amount of money you're refunding.
     *
     * @var string
     */
    private $amount;
    /**
     * Specify if you want to make a full or a
     * partial refund.
     *
     * @var boolean
     */
    private $full;

    protected $config;

    protected function setUp()
    {

        $this->ammount = 10.89;
        $this->transactionId = 123456789;

        $this->reason = 'Complain';
        $this->description = 'Money for some trash like that oh';

        $this->clientReference = array('userId' => 14028);

        $this->full = true;

        $this->config = new Config(
            $accountNumber = 12345,
            $clientId = 'someClientId',
            $clientSecret = 'someClientSecret'
        );
    }

    public function checkValues($api)
    {
        $this->assertEquals($api->getAmount(), $this->amount, 'The Amount on instance should be the transaction amount');
        $this->assertEquals($api->getDescription(), $this->description, 'it should be the description passed in');
        $this->assertEquals($api->getClientReference(), $this->clientReference, 'it should be the reference passed in');
        $this->assertEquals($api->getReason(), $this->reason, 'it should be the same reason passed in');
        $this->assertEquals($api->getTransactionId(), $this->transactionId, 'it should be the transaction ID callback URL');
        $this->assertEquals($api->getFull(), $this->full, 'it should match defined choice');
    }

    public function testExpressiveRefund()
    {
        $api = Refund::transactionId($this->transactionId)
            ->amount($this->amount)
            ->description($this->description)
            ->reference($this->clientReference)
            ->reason($this->reason)
            ->full();

        $this->checkValues($api);

        $api->partial();
        $this->assertFalse($api->getFull(), 'it should switch to false');

        return $api;
    }

    public function testTransactableStaticBadMethodsException()
    {
        $this->expectException(\BadMethodCallException::class);

        Refund::clientReference($this->customerMsisdn);
    }

    public function testBadInstanceMethodException()
    {
        $this->expectException(\BadMethodCallException::class);

        (new Refund)->some_bad_method($this->customerMsisdn);
    }

    public function test_run_incomplete_required_throws_error_call()
    {
        $this->expectException(MissingParameterException::class);

        (new Refund)->run();
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

        $mock = $this->getMockBuilder(Refund::class)
            ->setMethods(['createHandler'])
            ->getMock();

        $mock->expects($this->once())->method('createHandler')->will($this->returnValue($handlerStack));

        $mock->injectConfig($this->config);

        $mock
            ->transactionId($this->transactionId)
            ->amount($this->amount)
            ->description($this->description)
            ->reference($this->clientReference)
            ->reason($this->reason)
            ->full();

        $result = $mock->run();

        $this->assertEquals($result, json_decode(json_encode(['X-Foo' => 'Bar'])));

        $request = $container[0]['request'];

        $this->assertEquals($request->getMethod(), 'POST', 'it should be a post request.');
        $this->assertEquals($request->getUri()->getHost(), 'api.hubtel.com', 'Hostname should be api.hubtel.com');
        $this->assertEquals($request->getHeaderLine('User-Agent'), Pay::CLIENT . ' v' . Pay::VERSION);

        $this->assertEquals($request->getUri()->getScheme(), 'https', 'it should be a https scheme');

        $this->assertContains(
            "https://api.hubtel.com/v1/merchantaccount/merchants/12345/transactions/refund",
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

        $mock = $this->getMockBuilder(Refund::class)
            ->setMethods(['createHandler'])
            ->getMock();

        $mock->expects($this->once())->method('createHandler')->will($this->returnValue($handlerStack));

        $mock->injectConfig($this->config);

        $mock
            ->transactionId($this->transactionId)
            ->amount($this->amount)
            ->description($this->description)
            ->reference($this->clientReference)
            ->reason($this->reason)
            ->full();

        $result = $mock->run();
    }
}

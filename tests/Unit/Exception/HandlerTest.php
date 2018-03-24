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

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Mockery as m;
use OVAC\HubtelPayment\Config;
use OVAC\HubtelPayment\Exception\BadRequestException;
use OVAC\HubtelPayment\Exception\Handler;
use OVAC\HubtelPayment\Exception\HubtelException;
use OVAC\HubtelPayment\Exception\InvalidRequestException;
use OVAC\HubtelPayment\Exception\MissingParameterException;
use OVAC\HubtelPayment\Exception\NotFoundException;
use OVAC\HubtelPayment\Exception\UnauthorizedException;
use OVAC\HubtelPayment\Pay;
use OVAC\HubtelPayment\Utility\HubtelHandler;
use PHPUnit\Framework\TestCase;

class HandlerTest extends TestCase
{

    /**
     * The OVAC/Hubtel-Payment Pay config.
     *
     * @var \OVAC\Hubtel\Config
     */
    protected $config;

    public function setup()
    {
        $this->config = new Config(
            $accountNumber = 12345,
            $clientId = 'someClientId',
            $clientSecret = 'someClientSecret'
        );
    }

    public function tearDown()
    {

    }

    public function useResponse($code = 200, $body = null)
    {
        $mock = new MockHandler([
            new Response($code, ['X-Foo' => 'Bar'], $body),
            new Response($code, ['Content-Length' => 0]),
            new RequestException("Error Communicating with Server", new Request('GET', 'test')),
        ]);

        $handler = (new HubtelHandler($this->config, HandlerStack::create($mock)))->createHandler();

        $handler->remove('hubtel-retry-request');

        $client = new Client(['handler' => $handler]);

        try {
            $client->get('http://localhost');
        } catch (ClientException $e) {
            throw new Handler($e);
        }
    }

    public function test_400_response()
    {
        $this->expectException(BadRequestException::class);
        $this->useResponse(400);
    }

    public function test_401_response()
    {
        $this->expectException(UnauthorizedException::class);
        $this->useResponse(401);
    }

    public function test_402_response()
    {
        $this->expectException(InvalidRequestException::class);
        $this->useResponse(402);
    }

    public function test_404_response()
    {
        $this->expectException(NotFoundException::class);
        $this->useResponse(404);
    }

    public function test_other_error_response()
    {
        $this->expectException(HubtelException::class);
        try {

            $this->useResponse(403);
        } catch (ClientException $e) {

            $this->assertContains('Some Field', $e->getMissingParameter());
            $this->assertContains('Other Field', $e->getMissingParameter());

            throw new Handler($e);
        }
    }

    public function test_500_response()
    {
        $this->expectException(\Exception::class);
        $this->useResponse(500);
    }

    public function test_501_response()
    {
        $this->expectException(\Exception::class);
        $this->useResponse(501);
    }

    public function test_502_response()
    {
        $this->expectException(\Exception::class);
        $this->useResponse(502);
    }

    public function test_504_response()
    {
        $this->expectException(\Exception::class);
        $this->useResponse(504);
    }

    public function test_4010_missenParameter_request_response()
    {
        $this->expectException(MissingParameterException::class);

        try {

            $this->useResponse(400, json_encode([
                'ResponseCode' => 4010,
                'Errors' => [
                    array('Field' => 'Some Field'),
                    array('Field' => 'Other Field'),
                ],
            ]));
        } catch (MissingParameterException $e) {

            $this->assertSame(4010, $e->getErrorCode());
            $this->arrayHasKey('ResponseCode', $e->getRawOutput());
            $this->assertContains('MissingParameter', $e->getErrorType());
            $this->assertContains('Some Field', $e->getMissingParameter());
            $this->assertContains('Other Field', $e->getMissingParameter());
            $this->assertContains('Other Field', $e->getMessage());
            $this->assertContains('Some Field', $e->getMessage());

            throw $e;
        }
    }

    /**
     * @depreciated
     * This has been depreciated and will be removed in v2
     * @return
     */
    public function test_4010_missenParameter_request_response_backward_compatibility()
    {
        $this->expectException(MissingParameterException::class);

        try {

            $this->useResponse(400, json_encode([
                'ResponseCode' => 4010,
                'Error' => [
                    array('Field' => 'Some Field'),
                    array('Field' => 'Other Field'),
                ],
            ]));
        } catch (MissingParameterException $e) {

            $this->assertSame(4010, $e->getErrorCode());
            $this->arrayHasKey('ResponseCode', $e->getRawOutput());
            $this->assertContains('MissingParameter', $e->getErrorType());
            $this->assertContains('Some Field', $e->getMissingParameter());
            $this->assertContains('Other Field', $e->getMissingParameter());

            throw $e;
        }
    }

}

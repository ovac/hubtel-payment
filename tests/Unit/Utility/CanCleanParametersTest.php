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

namespace OVAC\HubtelPayment\Tests\Unit\Utility;

use GuzzleHttp\Exception\TransferException;
use OVAC\HubtelPayment\Config;
use OVAC\HubtelPayment\Pay;
use OVAC\HubtelPayment\Utility\HubtelHandler;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CanCleanParametersTest extends TestCase
{

    /**
     * The OVAC/Hubtel-Payment Pay config.
     *
     * @var \OVAC\Hubtel\Config
     */
    protected $config;

    protected function setUp()
    {
        $this->config = new Config(
            $accountNumber = 12345,
            $clientId = 'someClientId',
            $clientSecret = 'someClientSecret'
        );
    }

    public function test_createHandler()
    {
        $mock = $this->getMockBuilder(HubtelHandler::class)
            ->setConstructorArgs([$this->config])
            ->setMethods(['pushHeaderMiddleware', 'pushRetryMiddleware', 'pushBasicAuthMiddleware'])
            ->getMockForAbstractClass();

        $requestMock = $this->createMock(RequestInterface::class, ['withHeader']);
        $responseMock = $this->createMock(ResponseInterface::class);
        $tfException = $this->createMock(TransferException::class);

        $requestMock->expects($this->exactly(2))->method('withHeader');

        $mock->expects($this->once())->method('pushHeaderMiddleware')->with(
            $this->callback(function (callable $callable) use ($requestMock) {
                $callable($requestMock);

                return true;
            })
        );

        $mock->expects($this->Once())->method('pushBasicAuthMiddleware')->with(
            $this->callback(function (callable $callable) use ($requestMock) {
                $callable($requestMock);

                return true;
            })
        );

        $mock->expects($this->once())->method('pushRetryMiddleware')->with(
            $this->callback(function (callable $callable) use ($requestMock, $responseMock, $tfException) {
                $callable(10, $requestMock, $responseMock, $tfException);
                return $callable;
            }),

            $this->callback(function (callable $callable) {
                $result = $callable(10);
                $this->assertTrue(is_int($result), 'Expects the decider function to return a number in mili-seconds');

                return true;
            })
        );

        $response = $mock->createHandler();
    }
}

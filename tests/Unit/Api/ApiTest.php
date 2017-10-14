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

namespace OVAC\HubtelPayment\Tests\Unit\Api;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use OVAC\HubtelPayment\Api\Api;
use OVAC\HubtelPayment\Config;
use OVAC\HubtelPayment\Exception\UnauthorizedException;
use OVAC\HubtelPayment\Pay;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
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

    public function test_api_constructor_must_receive_config_type_constructor()
    {
        $this->expectException('TypeError');

        $mock = $this->getMockBuilder(Api::class)
            ->setConstructorArgs([1])
            ->getMockForAbstractClass();
    }

    public function test_api_constructor_must_take_in_arguement()
    {
        $this->expectException('ArgumentCountError');

        $mock = $this->getMockForAbstractClass(Api::class);
    }

    public function test_api_constructor_accepts_config_in_constructor()
    {
        $mock = $this->getMockBuilder(Api::class)
            ->setConstructorArgs([$this->config])
            ->getMockForAbstractClass();

        $this->assertAttributeEquals($this->config, 'config', $mock);
        $this->assertInstanceOf(Api::class, $mock->injectConfig($this->config), 'it should return Api::class instance');
    }

    public function test_api_set_and_get_base_url()
    {
        $mock = $this->getMockBuilder(Api::class)
            ->setConstructorArgs([$this->config])
            ->getMockForAbstractClass();

        $mock->setBaseUrl('http://whateverurl.com');

        $this->assertEquals($mock->getBaseUrl(), 'http://whateverurl.com', 'it should update baseUrl');
    }

    public function test_api_http_methods()
    {
        $path = '/some_path';
        $parameters = ['hello' => 'world'];

        $mock = $this->getMockBuilder(Api::class)
            ->disableOriginalConstructor()
            ->setMethods(['execute'])
            ->getMockForAbstractClass();

        $mock->expects($this->exactly(7))
            ->method('execute')
            ->withConsecutive(
                [$this->equalTo('get'), $this->equalTo($path), $this->equalTo($parameters)],
                [$this->equalTo('post'), $this->equalTo($path), $this->equalTo($parameters)],
                [$this->equalTo('put'), $this->equalTo($path), $this->equalTo($parameters)],
                [$this->equalTo('delete'), $this->equalTo($path), $this->equalTo($parameters)],
                [$this->equalTo('patch'), $this->equalTo($path), $this->equalTo($parameters)],
                [$this->equalTo('head'), $this->equalTo($path), $this->equalTo($parameters)],
                [$this->equalTo('options'), $this->equalTo($path), $this->equalTo($parameters)]
            );

        $mock->_get($path, $parameters);
        $mock->_post($path, $parameters);
        $mock->_put($path, $parameters);
        $mock->_delete($path, $parameters);
        $mock->_patch($path, $parameters);
        $mock->_head($path, $parameters);
        $mock->_options($path, $parameters);
    }

    public function test_api_execute_methods_requires_config()
    {
        $this->expectException('RuntimeException');

        $path = '/some_path';
        $parameters = ['hello' => 'world'];

        $mock = $this->getMockBuilder(Api::class)
            ->disableOriginalConstructor()
            ->setMethods(['getClient'])
            ->getMockForAbstractClass();

        $mock->_get($path, $parameters);
    }

    public function test_api_execute_throws_ClientException_if_server_gives_error()
    {
        $this->expectException(UnauthorizedException::class);

        $httpMock = new MockHandler([
            new Response(401, ['X-Foo' => 'Bar']),
        ]);

        $handler = HandlerStack::create($httpMock);

        $path = '/some_path';
        $parameters = ['hello' => 'world'];

        $mock = $this->getMockBuilder(Api::class)
            ->setConstructorArgs([$this->config])
            ->setMethods(['createHandler'])
            ->getMockForAbstractClass();

        $mock->expects($this->once())
            ->method('createHandler')
            ->will($this->returnValue($handler));

        $mock->_get($path, $parameters);
    }

    public function test_api_execute_test_successful_call()
    {
        $path = '/some_path';
        $parameters = ['hello' => 'world'];

        $httpMock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], json_encode($parameters)),
        ]);

        $handler = HandlerStack::create($httpMock);

        $mock = $this->getMockBuilder(Api::class)
            ->setConstructorArgs([$this->config])
            ->setMethods(['createHandler'])
            ->getMockForAbstractClass();

        $mock->expects($this->once())
            ->method('createHandler')
            ->will($this->returnValue($handler));

        $response = $mock->_get($path, $parameters);

        $this->assertSame(json_encode($response), json_encode($parameters));
    }

    public static function callProtectedMethod($object, $method, array $args = array())
    {
        $class = new \ReflectionClass(get_class($object));
        $method = $class->getMethod($method);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $args);
    }

    public function test_api_createHandler_method()
    {
        $mock = $this->getMockBuilder(Api::class)
            ->setConstructorArgs([$this->config])
            ->getMockForAbstractClass();

        $handlerStack = self::callProtectedMethod($mock, 'createHandler', [$this->config]);

        self::assertInstanceOf(HandlerStack::class, $handlerStack);
    }

    public function test_inject_config()
    {
        $mock = $this->getMockBuilder(Api::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $mock->injectConfig($this->config);

        $this->assertSame($this->config, $mock->getConfig(), 'it should inject the configuration on the api');
    }
}

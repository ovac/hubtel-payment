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

namespace OVAC\HubtelPayment\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use OVAC\HubtelPayment\Config;
use OVAC\HubtelPayment\ConfigInterface;
use OVAC\HubtelPayment\Exception\Handler;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Api Class
 *
 * This class in responsible for making and executing the calls
 * to the Hubtel Server.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
abstract class Api implements ApiInterface
{
    /**
     * The Config repository instance.
     *
     * @var \OVAC\HubtelPayment\ConfigInterface
     */
    protected $config;
    /**
     * The Default Hubtel Base url for merchant payment
     *
     * @var string
     */
    protected $baseUrl = 'https://api.hubtel.com/v1/merchantaccount' . '/merchants';
    /**
     * Constructor.
     *
     * @param  \OVAC\HubtelPayment\ConfigInterface $config
     * @return void
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }
    /**
     * Injects the configuration tot he Api Instance
     *
     * @param  \OVAC\HubtelPayment\ConfigInterface $config
     * @return self
     */
    public function injectConfig(Config $config)
    {
        $this->config = $config;

        return $this;
    }
    /**
     * Change the Default baseUrl defined by hubtel
     *
     * @param string $baseUrl [description]
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }
    /**
     * Get the Hubtel payment Base Url from the Api Instance
     *
     * @return string [This is the base URL that is on the class instance]
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
    /**
     * {@inheritdoc}
     */
    public function _get($url = null, $parameters = [])
    {
        return $this->execute('get', $url, $parameters);
    }
    /**
     * {@inheritdoc}
     */
    public function _head($url = null, array $parameters = [])
    {
        return $this->execute('head', $url, $parameters);
    }
    /**
     * {@inheritdoc}
     */
    public function _delete($url = null, array $parameters = [])
    {
        return $this->execute('delete', $url, $parameters);
    }
    /**
     * {@inheritdoc}
     */
    public function _put($url = null, array $parameters = [])
    {
        return $this->execute('put', $url, $parameters);
    }
    /**
     * {@inheritdoc}
     */
    public function _patch($url = null, array $parameters = [])
    {
        return $this->execute('patch', $url, $parameters);
    }
    /**
     * {@inheritdoc}
     */
    public function _post($url = null, array $parameters = [])
    {
        return $this->execute('post', $url, $parameters);
    }
    /**
     * {@inheritdoc}
     */
    public function _options($url = null, array $parameters = [])
    {
        return $this->execute('options', $url, $parameters);
    }
    /**
     * {@inheritdoc}
     */
    public function execute($httpMethod, $url, array $parameters = [])
    {
        if (Config instanceof $this->config) {
            try {
                $response = $this->getClient()->{$httpMethod}($url, ['query' => $parameters]);

                return json_decode((string) $response->getBody(), true);
            } catch (ClientException $e) {
                new ClientException($e);
            }

            return;
        }

        throw new \RuntimeException('The API requires a configuration instance.');

    }
    /**
     * Returns an Http client instance.
     *
     * @return \GuzzleHttp\Client
     */
    protected function getClient()
    {
        $config = $this->config;

        return new Client(
            [
                'base_uri' => $this->baseUrl() . $config->getAccountNumber(), 'handler' => $this->createHandler(),
            ]
        );
    }
    /**
     * Create the client handler.
     *
     * @return                               \GuzzleHttp\HandlerStack
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    protected function createHandler()
    {
        $stack = HandlerStack::create();

        $stack->push(
            Middleware::mapRequest(
                function (RequestInterface $request) {
                    $config = $this->config;
                    $request = $request->withHeader('User-Agent', 'OVAC-Hubtel-Payment' . $config->getVersion());
                    $request = $request->withHeader('Authorization', 'Basic ' . base64_encode($config->getApiKey()));

                    return $request;
                }
            )
        );

            $stack->push(
                Middleware::retry(
                    function (
                        $retries,
                        RequestInterface $request,
                        ResponseInterface $response = null,
                        TransferException $exception = null
                    ) {
                        return $retries < 3 && ($exception instanceof ConnectException || (
                        $response && $response->getStatusCode() >= 500
                        ));
                    },
                    function ($retries) {
                        return (int) pow(2, $retries) * 1000;
                    }
                )
            );

                return $stack;
    }
}

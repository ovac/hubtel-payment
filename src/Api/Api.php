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

namespace OVAC\HubtelPayment\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use OVAC\HubtelPayment\Config;
use OVAC\HubtelPayment\ConfigInterface;
use OVAC\HubtelPayment\Exception\Handler;
use OVAC\HubtelPayment\Utility\HubtelHandler;

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
    protected $baseUrl = 'https://api.hubtel.com/v1/merchantaccount/merchants/';
    /**
     * This is the response received from the hubtel server
     * if no exception was thrown.
     *
     * @var \GuzzleHttp\Psr7\Response
     */
    protected $response;
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
        return $this->setConfig($config);
    }
    /**
     * Change the Default baseUrl defined by hubtel
     *
     * @param  string $baseUrl The hubtel Resource Base URL
     * @return self
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;

        return $this;
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
     *
     * @throws \RuntimeException
     * @throws \Handler
     */
    public function execute($httpMethod, $url, array $parameters = [])
    {
        if ($this->config instanceof Config) {
            try {
                $this->response = $this->getClient()->{$httpMethod}($this->config->getAccountNumber() . $url, [
                    'json' => $parameters,
                ]);

                return json_decode((string) $this->response->getBody());

            } catch (ClientException $e) {
                throw new Handler($e);
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
        return new Client(
            [
                'base_uri' => $this->baseUrl,
                'handler' => $this->createHandler($this->config),
            ]
        );
    }

    /**
     * Create the client handler.
     *
     * @param  \OVAC\HubtelPayment\Config $config
     * @return \GuzzleHttp\HandlerStack
     */
    protected function createHandler(Config $config)
    {
        return (new HubtelHandler($config))->createHandler();
    }

    /**
     * @return \OVAC\HubtelPayment\ConfigInterface
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param \OVAC\HubtelPayment\ConfigInterface $config
     *
     * @return self
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;

        return $this;
    }
}

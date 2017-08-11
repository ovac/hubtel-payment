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

namespace OVAC\HubtelPayment;

use OVAC\HubtelPayment\Config;

/**
 * Pay Class
 *
 * This is the main entry class for the OVAC/Hubtel-Payment Package
 * This class is responsible for creating the config instance
 */
class Pay implements ConfigInterface
{
    /**
     * The package version.
     *
     * @var string
     */
    const VERSION = '2.1.0';
    /**
     * The Config repository instance.
     *
     * @var \OVAC\HubtelPayment\ConfigInterface
     */
    protected $config;
    /**
     * Constructor.
     *
     * @param  string|array $account
     * @param  string       $clientId
     * @param  string       $clientSecret
     * @return void
     */
    public function __construct($account = null, $clientId = null, $clientSecret = null)
    {
        /**
         * Check if an array was passed and with key and values
         */
        if (is_array($account)) {
            $this->config = new Config(self::VERSION, $account['accountNumber'], $account['clientId'], $account['clientSecret']);

            return;
        }

        /**
         * If the data was not an array, then
         * we asume the the data was passed
         * in avalid order
         */
        $this->config = new Config(self::VERSION, $account, $clientId, $clientSecret);
    }
    /**
     * Create a new OVAC\HubtelPayment instance.
     *
     * @param  string|array $account
     * @param  string       $clientId
     * @param  string       $clientSecret
     * @return void
     */
    public static function make($account = null, $clientId = null, $clientSecret = null)
    {
        return new static($account, $clientId, $clientSecret);
    }
    /**
     * Returns the Config repository instance.
     *
     * @return \OVAC\HubtelPayment\ConfigInterface
     */
    public function getConfig()
    {
        return $this->config;
    }
    /**
     * Sets the Config repository instance.
     *
     * @param  \OVAC\HubtelPayment\ConfigInterface $config
     * @return $this
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;

        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function getAccountNumber()
    {
        return $this->config->getAccountNumber();
    }
    /**
     * {@inheritdoc}
     */
    public function setAccountNumber($accountNumber)
    {
        $this->config->setAccountNumber($accountNumber);

        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function getClientId()
    {
        return $this->config->getClientId();
    }
    /**
     * {@inheritdoc}
     */
    public function setClientId($clientId)
    {
        $this->config->setClientId($clientId);

        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function getClientSecret()
    {
        return $this->config->getClientSecret();
    }
    /**
     * {@inheritdoc}
     */
    public function setClientSecret($clientSecret)
    {
        $this->config->setClientSecret($clientSecret);

        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function getPackageVersion()
    {
        return $this->config->getPackageVersion();
    }
    /**
     * {@inheritdoc}
     */
    public function setPackageVersion($version)
    {
        $this->config->setPackageVersion($version);

        return $this;
    }
    /**
     * Dynamically handle missing Static Api Classes and Methods.
     *
     * @param  string $method
     * @param  array  $parameters
     * @return \OVAC\HubtelPayment\Api\ApiInterface
     */
    public static function __callStatic($method, array $parameters)
    {
        return (new self)->{$method}(...$parameters);
    }
    /**
     * Dynamically handle missing Api Classes and Methods.
     *
     * @param  string $method
     * @param  array  $parameters
     * @return \OVAC\HubtelPayment\Api\Transaction
     */
    public function __call($method, array $parameters)
    {
        if ($this->isIteratorRequest($method)) {
            $apiInstance = $this->getApiInstance(substr($method, 0, -8));

            return (new Pager($apiInstance))->fetch($parameters);
        }

        return $this->getApiInstance($method)->{$method}(...$parameters);
    }
    /**
     * Determines if the request is an iterator request.
     *
     * @return bool
     */
    protected function isIteratorRequest($method)
    {
        return substr($method, -8) === 'Iterator';
    }
    /**
     * Returns the Api class instance for the given method.
     *
     * @param  string $method
     * @return \OVAC\HubtelPayment\Api\Transaction
     * @throws \BadMethodCallException
     */
    protected function getApiInstance($method)
    {
        $class = '\\OVAC\\HubtelPayment\\Api\\Transaction\\' . ucwords($method);
        if (class_exists($class)) {
            return new $class($this->config);
        }
        throw new \BadMethodCallException('Undefined method [ ' . $method . '] called.');
    }
}

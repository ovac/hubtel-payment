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

namespace OVAC\HubtelPayment;

use OVAC\HubtelPayment\ConfigInterface;
use OVAC\HubtelPayment\Pay;

/**
 * Config Class
 *
 * This class holds the instance confuguration
 * and the methods required to update or retrieve
 * required configuration data.
 */
class Config implements ConfigInterface
{
    /**
     * This OVAC/Hubtel-Payment Package Version.
     *
     * @var string
     */
    protected $version;
    /**
     * The Hubtel Merchant Account Number to bill from.
     *
     * @var string
     */
    protected $accountNumber;
    /**
     * The Hubtel Developer Applicaton Client Id.
     *
     * @var string
     */
    protected $clientId;
    /**
     * The Hubtel Developer Applicaton Client Secret.
     *
     * @var string
     */
    protected $clientSecret;
    /**
     * Constructor
     *
     * @param  string $accoutNumber This is the Merchant Client Account Number
     * @param  string $clientId     This is the Merchant Developer Application client ID
     * @param  string $clientSecret This is the Merchant Developer Application client Secret
     * @return void
     */
    public function __construct($accoutNumber = null, $clientId = null, $clientSecret = null)
    {
        $this->setPackageVersion(Pay::VERSION);
        $this->setAccountNumber($accoutNumber ?: getenv('HUBTEL_ACCOUNT_NUMBER'));
        $this->setClientId($clientId ?: getenv('HUBTEL_CLIENT_ID'));
        $this->setClientSecret($clientSecret ?: getenv('HUBTEL_CLIENT_SECRET'));
    }
    /**
     * {@inheritdoc}
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }
    /**
     * {@inheritdoc}
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function getClientId()
    {
        return $this->clientId;
    }
    /**
     * {@inheritdoc}
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }
    /**
     * {@inheritdoc}
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;

        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function getPackageVersion()
    {
        return $this->version;
    }
    /**
     * {@inheritdoc}
     */
    public function setPackageVersion($version)
    {
        $this->version = $version;

        return $this;
    }
}

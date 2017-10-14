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

/**
 *
 */
interface ConfigInterface
{
    /**
     * Get the Merchant Client Account Number from the configuration
     *
     * @return string Merchant Client Account Number
     */
    public function getAccountNumber();
    /**
     * Sets the Hubter API Merchant Account Number.
     *
     * @param  string $accountNumber
     * @return $this
     */
    public function setAccountNumber($accountNumber);
    /**
     * Returns the Hubtel API Merchant Client ID.
     *
     * @return string
     */
    public function getClientId();
    /**
     * Sets the Hubtel API Merchant ID.
     *
     * @param  string $clientId
     * @return $this
     */
    public function setClientId($clientId);
    /**
     * Returns the Hubtel API Merchant Client Secret.
     *
     * @return string
     */
    public function getClientSecret();
    /**
     * Sets the Hubtel API Merchant Client Secret.
     *
     * @param  string $clientSecret
     * @return $this
     */
    public function setClientSecret($clientSecret);
    /**
     * Returns the current package version.
     *
     * @return string
     */
    public function getPackageVersion();
    /**
     * Set the current package version
     *
     * @param string $version The version of this package
     */
    public function setPackageVersion($version);
}

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

/**
 * Trait ReceiveMoneyAccessor
 * Accessors for the ReceiveMoney Api Properties
 * (setters and getters)
 */
trait ReceiveMoneyAccessors
{

    /**
     * @return string
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * @param string $customerName
     *
     * @return self
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * @param string $customerEmail
     *
     * @return self
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerMsisdn()
    {
        return $this->customerMsisdn;
    }

    /**
     * @param string $customerMsisdn
     *
     * @return self
     */
    public function setCustomerMsisdn($customerMsisdn)
    {
        $this->customerMsisdn = $customerMsisdn;

        return $this;
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param string $channel
     *
     * @return self
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     *
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrimaryCallbackURL()
    {
        return $this->primaryCallbackURL;
    }

    /**
     * @param string $primaryCallbackURL
     *
     * @return self
     */
    public function setPrimaryCallbackURL($primaryCallbackURL)
    {
        $this->primaryCallbackURL = $primaryCallbackURL;

        return $this;
    }

    /**
     * @return string
     */
    public function getSecondaryCallbackURL()
    {
        return $this->secondaryCallbackURL;
    }

    /**
     * @param string $secondaryCallbackURL
     *
     * @return self
     */
    public function setSecondaryCallbackURL($secondaryCallbackURL)
    {
        $this->secondaryCallbackURL = $secondaryCallbackURL;

        return $this;
    }

    /**
     * @return string
     */
    public function getClientReference()
    {
        return $this->clientReference;
    }

    /**
     * @param string $clientReference
     *
     * @return self
     */
    public function setClientReference($clientReference)
    {
        $this->clientReference = $clientReference;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return self
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isFeesOnCustomer()
    {
        return $this->feesOnCustomer;
    }

    /**
     * @param boolean $feesOnCustomer
     *
     * @return self
     */
    public function setFeesOnCustomer($feesOnCustomer)
    {
        $this->feesOnCustomer = $feesOnCustomer;

        return $this;
    }
}

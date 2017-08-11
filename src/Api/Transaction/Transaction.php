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

namespace OVAC\HubtelPayment\Api\Transaction;

use OVAC\HubtelPayment\Api\Api;
use OVAC\HubtelPayment\Api\MassAssignable;

/**
 * Transaction Class
 *
 * This class encapsulates all the Hubtel Transaction
 * properties required and optional that appears both
 * on the SendMoney and ReceiveMoney requests.
 */
class Transaction extends Api
{
    use MassAssignable;
    /**
     * The name of the customer.
     *
     * @var string
     */
    protected $customerName;
    /**
     * The customer email address
     *
     * @var string
     */
    protected $customerEmail;
    /**
     * The customer mobile money number.
     *
     * @var string
     */
    protected $customerMsisdn;
    /**
     * The mobile money provider channel
     *
     * @var string
     */
    protected $channel;
    /**
     * The mobile money transaction amount
     *
     * @var string
     */
    protected $amount;
    /**
     * A callback URL to receive the transaction
     * status from Hubtel to your API request.
     * Receive  money requests for all mobile
     * money providers are asynchrounous hence,
     * Hubtel will send a callback on  the f
     * inal status of a pending transaction
     *
     * @var string
     */
    protected $primaryCallbackURL;
    /**
     * The second URL for callback response in the
     * event of failure of  primary callback URL.
     *
     * @var string
     */
    protected $secondaryCallbackURL;
    /**
     * The reference number that is provided by you
     * to reference a transaction from your end.
     *
     * @var string
     */
    protected $clientReference;
    /**
     * The short description of the transaction.
     *
     * @var string
     */
    protected $description;

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
     * This function sets the customer data (name, email and msisdn|number|phone)
     *
     * @param array $data Customer data
     * @example $data = ['name' => 'Victor', 'email' => 'contact@ovac4u.com', 'number' => '0553577261']
     * @return self
     */
    public function setCustomer($data = [])
    {
        if (array_key_exists('name', $data)) {
            $this->setCustomerName($data['name']);
        }

        if (array_key_exists('email', $data)) {
            $this->setCustomerEmail($data['email']);
        }

        if (array_key_exists('number', $data)) {
            $this->setCustomerMsisdn($data['number']);
        }

        if (array_key_exists('phone', $data)) {
            $this->setCustomerMsisdn($data['phone']);
        }

        if (array_key_exists('msisdn', $data)) {
            $this->setCustomerMsisdn($data['msisdn']);
        }

        return $this;
    }

    /**
     * This method sets the callbacks for the Hubtel Payments
     * @param array|string $data
     * @return self
     */
    public function setCallback($data = [])
    {

        if (array_key_exists('callbackOnSuccess', $data)) {
            $this->setPrimaryCallbackURL($data['callbackOnSuccess']);
        }

        if (array_key_exists('callbackOnFail', $data)) {
            $this->setCustomerName($data['callbackOnFail']);
        }

        if (array_key_exists('callback', $data)) {
            if (is_array($data['callback']) && array_key_exists('success', $data['callback'])) {
                $this->setPrimaryCallbackURL($data['callback']['success']);
            }

            if (is_array($data['callback']) && array_key_exists('error', $data['callback'])) {
                $this->setSecondaryCallbackURL($data['callback']['error']);
            }

            if (!is_array($data['callback'])) {
                $this->setPrimaryCallbackURL($data['callback']);
            }
        }

        return $this;
    }
    /**
     * Sets the URL to call when the payment fails or is unsuccessfull
     *
     * @param  string $secondaryCallbackURL Url to call is payment is unsuccessful
     * @return self
     */
    public function callbackOnFail($secondaryCallbackURL)
    {
        return $this->setSecondaryCallbackURL($secondaryCallbackURL);
    }
    /**
     * Set the URL to call when the payment is been confirmed successful
     * (requred by the Hubtel ReceiveMoney Api)
     *
     * @param  string $primaryCallbackURL Url to callback when payment is successful
     * @return self
     */
    public function callbackOnSuccess($primaryCallbackURL)
    {
        return $this->setPrimaryCallbackURL($primaryCallbackURL);
    }
}

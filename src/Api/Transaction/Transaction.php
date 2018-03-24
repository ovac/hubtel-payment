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

namespace OVAC\HubtelPayment\Api\Transaction;

use OVAC\HubtelPayment\Api\Api;

/**
 * Transaction Class
 *
 * This class encapsulates all the Hubtel Transaction
 * properties required and optional that appears both
 * on the SendMoney and ReceiveMoney requests.
 */
class Transaction extends Api
{
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
     * Defines an array of required properties
     *
     * Names must correspond with properties/parameters on the class
     * and the properties must accessors defined on the
     * instance
     *
     * @var array
     */
    protected $parametersRequired = [];
    /**
     * Defines an array of the names of optional properties/parameters names
     *
     * Names must correspond with properties on the class
     * and the properties must accessors defined on the
     * instance
     *
     * @var array
     */
    protected $parametersOptional = [];

    /**
     * This is the name of the receiver.
     * @var string
     */
    protected $recipientName;

    /**
     * This is the number for the receiver
     * @var number
     */
    protected $recipientMsisdn;

    /**
     * returnes the name of the give customer
     *
     * @return string the customer name
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * Sets the name of the customer.
     *
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
     * get the customer's email address.
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * sets the customer's email address.
     *
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
     * gets the msisdn (Customer's phone number)
     *
     * @return string
     */
    public function getCustomerMsisdn()
    {
        return $this->customerMsisdn;
    }

    /**
     * Sets the customer's phone number to be billed or funded.
     *
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
     * returns the transaction channel (Mobile Network)
     *
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * sets the transaction channel (Mobile Network)
     *
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
     * Gets the money value for the transaction.
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * sets the money value (Amount) to be sent or received
     *
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
     * Returns the primary callback URL that has been set on the instance.
     *
     * @return string
     */
    public function getPrimaryCallbackURL()
    {
        return $this->primaryCallbackURL;
    }

    /**
     * set the callback url to callback if the transaction was successful.
     *
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
     * Returns the callback url on the transaction
     *
     * @return string
     */
    public function getSecondaryCallbackURL()
    {
        return $this->secondaryCallbackURL;
    }

    /**
     * Sets the URL to call back if he transaction is unsuccesful.
     *
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
     * get the transaction reference.
     *
     * @return string
     */
    public function getClientReference()
    {
        return $this->clientReference;
    }

    /**
     * Set's a reference on the transaction for easy identification
     * and transaction tracking.
     *
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
     * gets the description of the transaction.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * sets a description for the transaction.
     *
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
     * @param   array $data Customer data
     * @example $data = ['name' => 'Victor', 'email' => 'contact@ovac4u.com', 'number' => '0553577261']
     * @return  self
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
     * This method sests a single callback for both the success and Error
     *
     * @param  string $primaryCallbackURL A url for callbacks from the hubtel server
     * @return self
     */
    public function callback($primaryCallbackURL)
    {
        if (is_string($primaryCallbackURL)) {
            $this->setPrimaryCallbackURL($primaryCallbackURL)
                ->setSecondaryCallbackURL($primaryCallbackURL);
        }

        return $this;
    }

    /**
     * This method sets the callbacks for the Hubtel Payments
     *
     * @param  array|string $data
     * @return self
     */
    public function setCallback($data = [])
    {
        if (is_array($data)) {

            if (array_key_exists('callbackOnFail', $data)) {
                $this->setSecondaryCallbackURL($data['callbackOnFail']);
            }

            if (array_key_exists('callbackOnSuccess', $data)) {
                $this->setPrimaryCallbackURL($data['callbackOnSuccess']);
            }

            if (array_key_exists('error', $data)) {
                $this->setSecondaryCallbackURL($data['error']);
            }

            if (array_key_exists('success', $data)) {
                $this->setPrimaryCallbackURL($data['success']);
            }

            if (array_key_exists('callback', $data)) {
                $this->setCallback($data['callback']);
            }
        }

        return $this->callback($data);
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

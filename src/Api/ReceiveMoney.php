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
 * ReceiveMoney Class
 *
 * This class encapsulates all the methods required to place a
 * call to the Hubtel Server that makes a request to for payment
 * from a client
 */
class ReceiveMoney extends ReceiveMoneyAccessors
{
    /**
     * Construct for creating a new instance of the ReceiveMoney Api class
     * @param array $data An array with configurations for the receive money class
     */
    public function __construct($data = [])
    {
        $this->massAssign($data);
    }
    /**
     * This function uses the accessors to set the amount to be billed
     * to the customer
     *
     * @param  float|string $amount This is the actual amount intended to be charged.
     * (requred by the Hubtel ReceiveMoney Api)
     *
     * @return self
     */
    public static function amount($amount)
    {
        return (new self)->setAmount($amount);
    }
    /**
     * The phone number of the customer you want to bill (Send Pompt)
     * (requred by the Hubtel ReceiveMoney Api)
     *
     * @param  string $customerMsisdn This is the Customer Msisdn
     * @return self                   [description]
     */
    public function from($customerMsisdn)
    {
        return $this->setCustomerMsisdn($customerMsisdn);
    }
    /**
     * Set the description of the transaction
     * (requred by the Hubtel ReceiveMoney Api)
     *
     * @param  string $description The description of the transaction
     * @return self
     */
    public function description($description)
    {
        return $this->setDescription($description);
    }
    /**
     * Sets a reference to reference a transaction from your end.
     *
     * @param  string|number $reference the reference number
     * @return self
     */
    public function reference($reference)
    {
        return $this->setClientReference($reference);
    }
    /**
     * Sets the customer name as required by the Hubtel Receive Api
     * (requred by the Hubtel ReceiveMoney Api)
     *
     * @param  string $customerName The full name of the customer being charged
     * @return self
     */
    public function customerName($customerName)
    {
        return $this->setCustomerName($customerName);
    }
    /**
     * Sets the customer email (Optional)
     *
     * @param  string $customerEmail The email of the customer to be charged
     * @return self
     */
    public function customerEmail($customerEmail)
    {
        return $this->setCustomerEmail($customerEmail);
    }
    /**
     * Sets the channel (Mobile Network)
     * (requred by the Hubtel ReceiveMoney Api)
     *
     * @param  string $channel The mobile network channel (example: mtn-gh)
     * @return self          [description]
     */
    public function channel($channel)
    {
        return $this->setChannel($channel);
    }
    /**
     * Sets the URL to call when the payment fails or is unsuccessfull
     *
     * @param  string $secondaryCallbackURL Url to call is payment is unsuccessful
     * @return self                       [description]
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
     * @return self                     [description]
     */
    public function callbackOnSuccess($primaryCallbackURL)
    {
        return $this->setPrimaryCallbackURL($primaryCallbackURL);
    }
    /**
     * Sets the 6 digit unique token required to debit a Vodafone Cash
     *
     * @param  string $token the 6 digit unique token required to debit a Vodafone Cash
     * @return self        [description]
     */
    public function token($token)
    {
        return $this->setToken($token);
    }
    /**
     * Sets if the hubtel and mobile money fees is charged on the customer or client
     *
     * @param  boolean $feesOnCustomer If the arguement is not passed in, fees will be charged on customer
     * @return self                  [description]
     */
    public function feesOnCustomer($feesOnCustomer)
    {
        return $this->setFeesOnCustomer($feesOnCustomer);
    }
    /**
     * This method catches the receive money magic call from the PayClass.
     * It could be used to pass the full config or start the expressive api.
     *
     * @param  float|array $data [description]
     * @return self         [description]
     */
    public function receiveMoney($data = [])
    {
        if (is_array($data)) {
            return $this->massAssign($data);
        }

        return $this->setAmount($data);
    }
    /**
     * This method is used to mass assign the properties required by the Hubtel ReceiveMoney Api
     * @param  array  $data
     * @example ['amount' => 10, 'customer' => ['name' => 'victor', ...], 'clientReference' => 123, 'callbackOnSuccess' => 'url', 'amount' => 10, 'description' => 'some description']
     * @return self       [description]
     */
    private function massAssign($data = [])
    {
        if (is_array($data)) {
            if (array_key_exists('customer', $data)) {
                $this->setCustomer($data['customer']);
            }

            if (array_key_exists('token', $data)) {
                $this->setToken($data['token']);
            }

            if (array_key_exists('amount', $data)) {
                $this->setToken($data['amount']);
            }

            if (array_key_exists('description', $data)) {
                $this->setToken($data['description']);
            }

            if (array_key_exists('clientReference', $data)) {
                $this->setCustomerName($data['clientReference']);
            }

            if (array_key_exists('channel', $data)) {
                $this->setCustomerName($data['channel']);
            }

            if (preg_grep('/^callback/i', array_keys($data))) {
                $this->setCallback($data);
            }
        }

        return $this;
    }
    /**
     * This method sets the callbacks for the Hubtel Payments
     * @param array|string $data [description]
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
}

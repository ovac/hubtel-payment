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

use OVAC\HubtelPayment\Api\Transaction\ReceiveMoney;
use OVAC\HubtelPayment\Api\Transaction\SendMoney;

/**
 * Trait MassAssignable
 *
 * This trait encapsulates the method required to create mass assignment
 * on the ReceiveMoney and SendMoney Properties
 */
trait MassAssignable
{

    /**
     * This function sets the customer data (name, email and msisdn|number|phone)
     *
     * @param   array $data Customer data
     * @example $data = ['name' => 'Victor', 'email' => 'contact@ovac4u.com', 'number' => '0553577261']
     * @return  self
     */
    abstract public function setCustomer($data = []);
    /**
     * sets the money value (Amount) to be sent or received
     *
     * @param string $amount
     *
     * @return self
     */
    abstract public function setAmount($amount);
    /**
     * sets a description for the transaction.
     *
     * @param string $description
     *
     * @return self
     */
    abstract public function setDescription($description);
    /**
     * Set's a reference on the transaction for easy identification
     * and transaction tracking.
     *
     * @param string $clientReference
     *
     * @return self
     */
    abstract public function setClientReference($clientReference);
    /**
     * sets the transaction channel (Mobile Network)
     *
     * @param string $channel
     *
     * @return self
     */
    abstract public function setChannel($channel);
    /**
     * This method sets the callbacks for the Hubtel Payments
     *
     * @param  array|string $data
     * @return self
     */
    abstract public function setCallback($data = []);
    /**
     * This method exposes the mass assignment method.
     *
     * @param  array $data
     * @return self
     */
    public function make($data = [])
    {
        return $this->massAssign($data);
    }
    /**
     * This method is used to mass assign the properties required by the Hubtel ReceiveMoney and SendMoney Api
     *
     * @param   array $data
     * @example ['amount' => 10, 'customer' => ['name' => 'victor', ...], 'clientReference' => 123, 'callbackOnSuccess' => 'url', 'amount' => 10, 'description' => 'some description']
     * @return  self
     */
    protected function massAssign($data = [])
    {
        if (is_array($data)) {
            /**
             * Check if the passed in array contains a sub customer array.
             * If a matching array is found, it is passed to the set customer method.
             * ['customer' => [ 'name'  => 'Victor Ariama', 'email' => 'contact@ovac4u.com', 'number'=> '0553577261']]
             */
            if (array_key_exists('customer', $data)) {
                $this->setCustomer($data['customer']);
            }
            /**
             * Check if the array contains an amount key and value.
             * If a matching key and value is found, assign the amount that was passed in
             * to the amount on the instance.
             *
             * ['amount' => 100.90]
             */
            if (array_key_exists('amount', $data)) {
                $this->setAmount($data['amount']);
            }
            /**
             * Check if the array contains a description key and value.
             * If a matching key and value is found, assign the description that was passed in
             * to the description on the instance.
             *
             *  ['description' => 'Some imformation about the payment']
             */
            if (array_key_exists('description', $data)) {
                $this->setDescription($data['description']);
            }
            /**
             * Check if the array contains a clientReference key and value.
             * If a matching key and value is found, assign the clientReference that was passed in
             * to the clientReference on the instance.
             *
             *  ['clientReference' => 'UserID: 121212']
             */
            if (array_key_exists('clientReference', $data)) {
                $this->setClientReference($data['clientReference']);
            }
            /**
             * Check if the array contains a channel key and value.
             * If a matching key and value is found, assign the channel that was passed in
             * to the token on the instance.
             *
             * ['channel' => 'mtn-gh']
             */
            if (array_key_exists('channel', $data)) {
                $this->setChannel($data['channel']);
            }
            /**
             * Check if the looks like or contains callback* (wildcard)
             * If a matching key and value is found, it is passed to the setCallback
             * method and is processed based on whatever data is provided.
             *
             * The keys are handled dynamically.
             *
             * ['callback*' => ***]
             */
            if (preg_grep('/^callback/i', array_keys($data))) {
                $this->setCallback($data);
            }

            $this->assignOnReceiveMoneyInstance($data);
            $this->assignOnSendMoneyInstance($data);
        }

        return $this;
    }

    protected function assignOnSendMoneyInstance($data = [])
    {
        if (get_class($this) === ReceiveMoney::class) {
            return $data;
        }
    }

    protected function assignOnReceiveMoneyInstance($data = [])
    {
        if (get_class($this) === ReceiveMoney::class) {
            /**
             * Check if the array contains a channel key and value.
             * If a matching key and value is found, assign the channel that was passed in
             * to the token on the instance.
             *
             * ['channel' => 'mtn-gh']
             */
            if (array_key_exists('feesOnCustomer', $data)) {
                $this->setFeesOnCustomer($data['feesOnCustomer']);
            }

            /**
             * Check if the array contains a token key and value.
             * If a matching key and value is found, assign the token that was passed in
             * to the token on the instance.
             * ['token' => '12345']
             */
            if (array_key_exists('token', $data)) {
                $this->setToken($data['token']);
            }
        }
    }
}

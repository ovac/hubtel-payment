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

/**
 * This trait encapsulates the accessor required to
 * create a new transaction instance
 */
trait Transactable
{
    /**
     * This method serves as an entry to a transaction
     * class instane. It creates a new transaction class
     * by first starting with the required amount
     * value of the transaction to be created.
     *
     * (required by the Hubtel ReceiveMoney Api)
     *
     * @param  float|number $amount the actual money value of the transaction being created
     * @return self
     */
    protected function amount($amount)
    {
        return $this->setAmount($amount);
    }

    /**
     * Sets the channel (Mobile Network)
     * (requred by the Hubtel ReceiveMoney|SendMoney Api)
     *
     * @param  string $channel The mobile network channel (example: mtn-gh)
     * @return self
     */
    public function channel($channel)
    {
        return $this->setChannel($channel);
    }

    /**
     * Dynamically handle missing Static Api Call to Amount.
     *
     * @param  string $method
     * @param  array  $parameters
     * @return self
     * @throws \BadMethodCallException
     */
    public static function __callStatic($method, array $parameters)
    {
        return (new self)->__call($method, $parameters);
    }

    /**
     * Dynamically handle missing public method call on Amount.
     *
     * @param  string $method
     * @param  array  $parameters
     * @return self
     * @throws \BadMethodCallException
     */
    public function __call($method, array $parameters)
    {
        if (in_array($method, ['amount', 'to', 'from', 'transactionId'])) {
            return $this->{$method}(...$parameters);
        }

        throw new \BadMethodCallException('Undefined method [ ' . $method . '] called.');
    }
}

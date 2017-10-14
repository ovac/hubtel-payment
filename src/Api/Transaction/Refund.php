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

use OVAC\HubtelPayment\Api\Transaction\MassAssignable;
use OVAC\HubtelPayment\Api\Transaction\Transactable;
use OVAC\HubtelPayment\Api\Transaction\Transaction;
use OVAC\HubtelPayment\Utility\CanCleanParameters;

/**
 * Class Refund
 *
 * This class encapsulates and implements an expressive API using a
 * set of methods to implement the required properties to
 * place a call to the Hubtel Server in order to
 * refund money to a customer using it's unique transaction ID.
 */
class Refund extends Transaction
{
    use MassAssignable;
    use Transactable;
    use CanCleanParameters;

    /**
     * {@inheritdoc}
     */
    protected $parametersRequired = [
        'TransactionId',
        'Reason',
        'ClientReference',
        'Description',
        'Amount',
        'Full',
    ];

    /**
     * The unique ID of the mobile money transaction
     * you want to refund
     *
     * @var string
     */
    protected $transactionId;
    /**
     * A short description of your reason
     * for refunding the mobile money wallet
     *
     * @var string
     */
    protected $reason;
    /**
     * Specify if you want to make a full or a
     * partial refund.
     *
     * @var boolean
     */
    protected $full;
    /**
     * Construct for creating a new instance of the Refund Api class
     *
     * @param array $data An array with configurations for the refund money class
     */
    public function __construct($data = [])
    {
        $this->massAssign($data);
    }
    /**
     * Sets the transaction ID
     *
     * @param  string $transactionId the ID of the transaciton
     *                               intended to be returned
     * @return self
     */
    protected function transactionId($transactionId)
    {
        return $this->setTransactionId($transactionId);
    }
    /**
     * Sets the reason for the refund
     *
     * @param  string $reason The actual reason for the refund
     * @return self
     */
    public function reason($reason)
    {
        return $this->setReason($reason);
    }
    /**
     * Sets a reference for the transaction to be
     * processed id from your end.
     *
     * @param  string $reference the reference
     * @return self
     */
    public function reference($reference)
    {
        return $this->setClientReference($reference);
    }
    /**
     * Sets the description of the transaction to be carried out
     *
     * @param  string $description The description of the transaction
     * @return self
     */
    public function description($description)
    {
        return $this->setDescription($description);
    }
    /**
     * Specifies if the transaction is to be a full
     *  or a partial refund
     *
     * @param  boolean $full
     * @return self
     */
    public function full($full = true)
    {
        return $this->setFull($full);
    }
    /**
     * Specifies if the transaction is to be a full
     * or a partial refund
     *
     * @param  boolean $full
     * @return self
     */
    public function partial($full = false)
    {
        return $this->setFull($full);
    }
    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }
    /**
     * The method runs the transaction
     *
     * @return Object
     */
    public function run()
    {
        $this->propertiesPassRequired();

        return $this->_post('/transactions/refund', $this->propertiesToArray());
    }
    /**
     * @param string $transactionId
     *
     * @return self
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;

        return $this;
    }
    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }
    /**
     * @param string $reason
     *
     * @return self
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }
    /**
     * @return boolean
     */
    public function isFull()
    {
        return $this->full;
    }
    /**
     * @return boolean
     */
    public function getFull()
    {
        return $this->isFull();
    }
    /**
     * @param boolean $full
     *
     * @return self
     */
    public function setFull($full)
    {
        $this->full = $full;

        return $this;
    }
}

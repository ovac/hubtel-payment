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
use OVAC\HubtelPayment\Api\Transaction\Transaction;
use OVAC\HubtelPayment\Utility\CanCleanParameters;

/**
 * Class ReceiveMoney
 *
 * This class encapsulates and implements an expressive API using a
 * set of methods to implement the required properties to
 * check the status of a transaction.
 */
class CheckStatus extends Transaction
{
    use MassAssignable;
    use CanCleanParameters;

    /**
     * The invoice token recieved from hubtel
     * when the transaction was created.
     *
     * @var string
     */
    protected $invoiceToken;

    /**
     * The invoice token recieved from hubtel
     * when the transaction was created.
     *
     * @var string
     */
    protected $hubtelTransactionId;

    /**
     * The invoice token recieved from hubtel
     * when the transaction was created.
     *
     * @var string
     */
    protected $networkTransactionId;

    /**
     * {@inheritdoc}
     */
    protected $parametersRequired = [
        'HubtelTransactionId',
    ];
    /**
     * {@inheritdoc}
     */
    protected $parametersOptional = [
        'InvoiceToken',
        'NetworkTransactionId',
    ];

    /**
     * Construct for creating a new instance of the ReceiveMoney Api class
     *
     * @param array $data An array with configurations for the receive money class
     */
    public function __construct($data = [])
    {
        $this->massAssign($data);
    }
    /**
     * A helper method for setting the invoice token.
     *
     * @param  string $invoiceToken This is the invoice token.
     * @return self
     */
    public function code($invoiceToken)
    {
        return $this->invoiceToken($invoiceToken);
    }

    /**
     * A helper method for setting the invoice token.
     *
     * @param  string $invoiceToken This is the invoice token.
     * @return self
     */
    public function invoiceToken($invoiceToken)
    {
        return $this->setinvoiceToken($invoiceToken);
    }

    /**
     * @return string
     */
    public function getInvoiceToken()
    {
        return $this->invoiceToken;
    }

    /**
     * @param string $invoiceToken
     *
     * @return self
     */
    public function setInvoiceToken($invoiceToken)
    {
        $this->invoiceToken = $invoiceToken;

        return $this;
    }

    /**
     * A helper method for setting the invoice token.
     *
     * @param  string $hubtelTransactionId This is the invoice token.
     * @return self
     */
    public function transactionId($hubtelTransactionId)
    {
        return $this->hubtelTransactionId($hubtelTransactionId);
    }

    /**
     * A helper method for setting the invoice token.
     *
     * @param  string $hubtelTransactionId This is the invoice token.
     * @return self
     */
    public function hubtelTransactionId($hubtelTransactionId)
    {
        return $this->setHubtelTransactionId($hubtelTransactionId);
    }

    /**
     * @return string
     */
    public function getHubtelTransactionId()
    {
        return $this->hubtelTransactionId;
    }

    /**
     * @param string $hubtelTransactionId
     *
     * @return self
     */
    public function setHubtelTransactionId($hubtelTransactionId)
    {
        $this->hubtelTransactionId = $hubtelTransactionId;

        return $this;
    }

    /**
     * A helper method for setting the invoice token.
     *
     * @param  string $networkTransactionId This is the invoice token.
     * @return self
     */
    public function networkTransactionId($networkTransactionId)
    {
        return $this->setNetworkTransactionId($networkTransactionId);
    }

    /**
     * @return string
     */
    public function getNetworkTransactionId()
    {
        return $this->networkTransactionId;
    }

    /**
     * @param string $networkTransactionId
     *
     * @return self
     */
    public function setNetworkTransactionId($networkTransactionId)
    {
        $this->networkTransactionId = $networkTransactionId;

        return $this;
    }

    /**
     * The method runs the transaction
     *
     * @return Object
     */
    public function run()
    {
        $this->propertiesPassRequired();

        return $this->_get('/transactions/status' . '?' . http_build_query($this->propertiesToArray()));
    }
}

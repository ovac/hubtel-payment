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
 * Class SendMoney
 *
 * This class encapsulates and implements an expressive API using a
 * set of methods to implement the required properties to
 * place a call to the Hubtel Server in order to
 * send money to a customer.
 */
class SendMoney extends Transaction
{
    use MassAssignable;
    use Transactable;
    use CanCleanParameters;

    /**
     * {@inheritdoc}
     */
    protected $parametersRequired = [
        'RecipientName',
        'RecipientMsisdn',
        'CustomerEmail',
        'PrimaryCallbackURL',
        'Amount',
        'Description',
    ];

    /**
     * {@inheritdoc}
     */
    protected $parametersOptional = [
        'SecondaryCallbackURL',
        'ClientReference',
        'Channel',
    ];

    /**
     * Construct for creating a new instance of the SendMoney Api class
     *
     * @param array $data An array with configurations for the send money class
     */
    public function __construct($data = [])
    {
        $this->massAssign($data);
    }
    /**
     * This api method sets the rceiver's phone number.
     * (requred by the Hubtel SendMoney Api)
     *
     * @param                                   number $customerMsisdn this is the receiver's phone number
     * @return                                  self
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    protected function to($customerMsisdn)
    {
        return $this->setCustomerMsisdn($customerMsisdn);
    }
    /**
     * This api method sets the receiver's name
     * (requred by the Hubtel SendMoney Api)
     *
     * @param string $customerName This is the name of the receiver
     *
     * @return self
     */
    public function customerName($customerName)
    {
        return $this->recepientName($customerName);
    }
    /**
     * This api method sets the receiver's name
     * (requred by the Hubtel SendMoney Api)
     *
     * @param string $customerName This is the name of the receiver
     *
     * @return self
     */
    public function recepientName($customerName)
    {
        return $this->setCustomerName($customerName);
    }
    /**
     * This api method sets the receiver's email
     * (requred by the Hubtel SendMoney Api)
     *
     * @param  string $customerEmail This is the email of the receiver
     * @return self
     */
    public function customerEmail($customerEmail)
    {
        return $this->setCustomerEmail($customerEmail);
    }
    /**
     * This method sets the description of the transaction. Best used to describe
     * why the money is being sent for future reference and book keeping.
     * (requred by the Hubtel SendMoney Api)
     *
     * @param  string $description A description of the transaction.
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
     * The method runs the transaction
     *
     * @return Object
     */
    public function run()
    {
        $this->propertiesPassRequired();

        return $this->_post('/send/mobilemoney', $this->propertiesToArray());
    }

    /**
     * @return mixed
     */
    public function getRecipientName()
    {
        return $this->recipientName;
    }

    /**
     * @param mixed $recipientName
     *
     * @return self
     */
    public function setCustomerName($recipientName)
    {
        return $this->setRecipientName($recipientName);
    }

    /**
     * @param mixed $recipientName
     *
     * @return self
     */
    public function getCustomerName()
    {
        return $this->getRecipientName();
    }

    /**
     * @return mixed
     */
    public function getParametersRequired()
    {
        return $this->parametersRequired;
    }

    /**
     * @param mixed $parametersRequired
     *
     * @return self
     */
    public function setParametersRequired($parametersRequired)
    {
        $this->parametersRequired = $parametersRequired;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParametersOptional()
    {
        return $this->parametersOptional;
    }

    /**
     * @param mixed $parametersOptional
     *
     * @return self
     */
    public function setParametersOptional($parametersOptional)
    {
        $this->parametersOptional = $parametersOptional;

        return $this;
    }

    /**
     * @param string $recipientName
     *
     * @return self
     */
    public function setRecipientName($recipientName)
    {
        $this->recipientName = $recipientName;

        return $this;
    }

    /**
     * @return number
     */
    public function getRecipientMsisdn()
    {
        return $this->recipientMsisdn;
    }

    /**
     * @param number $recipientMsisdn
     *
     * @return self
     */
    public function setRecipientMsisdn($recipientMsisdn)
    {
        $this->recipientMsisdn = $recipientMsisdn;

        return $this;
    }

    /**
     * @return number
     */
    public function getCustomerMsisdn()
    {
        return $this->getRecipientMsisdn();
    }

    /**
     * @param number $recipientMsisdn
     *
     * @return self
     */
    public function setCustomerMsisdn($recipientMsisdn)
    {
        return $this->setRecipientMsisdn($recipientMsisdn);
    }
}

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
 * place a call to the Hubtel Server in order to
 * receive money from a customer.
 */
class ReceiveMoney extends Transaction
{
    use MassAssignable;
    use Transactable;
    use CanCleanParameters;

    /**
     * The 6 digit unique token required to debit a Vodafone
     * Cash customer.  This token has to be generated and
     * provided by the Vodafone customer. The customer
     * dials *110# and selects menu item 6 to create
     * the voucher. It  expires after 5 minutes if unused
     *
     * @var string
     */
    protected $token;
    /**
     * This allows the fees of the transaction to be charged
     * on the customer. If set to true the
     * AmountCharged = Amount + Charges.
     *
     * @var boolean
     */
    protected $feesOnCustomer;
    /**
     * {@inheritdoc}
     */
    protected $parametersRequired = [
        'CustomerName',
        'CustomerMsisdn',
        'Amount',
        'PrimaryCallbackURL',
        'Description',
        'Channel',
    ];
    /**
     * {@inheritdoc}
     */
    protected $parametersOptional = [
        'CustomerEmail',
        'SecondaryCallbackURL',
        'ClientReference',
        'FeesOnCustomer',
        'Token',
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
     * The phone number of the customer you want to bill (Send Pompt)
     * (requred by the Hubtel ReceiveMoney Api)
     *
     * @param  string $customerMsisdn This is the Customer Msisdn
     * @return self
     */
    protected function from($customerMsisdn)
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
     * Sets the 6 digit unique token required to debit a Vodafone Cash
     *
     * @param  string $token the 6 digit unique token required to debit a Vodafone Cash
     * @return self
     */
    public function token($token)
    {
        return $this->setToken($token);
    }
    /**
     * Sets if the hubtel and mobile money fees is charged on the customer or client
     *
     * @param  boolean $feesOnCustomer If the arguement is not passed in, fees will be charged on customer
     * @return self
     */
    public function feesOnCustomer($feesOnCustomer)
    {
        return $this->setFeesOnCustomer($feesOnCustomer);
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
     * @return boolean
     */
    public function getFeesOnCustomer()
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
    /**
     * The method runs the transaction
     *
     * @return Object
     */
    public function run()
    {
        $this->propertiesPassRequired();

        return $this->_post('/receive/mobilemoney', $this->propertiesToArray());
    }
}

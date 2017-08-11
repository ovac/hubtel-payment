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

use OVAC\HubtelPayment\Api\Transaction\Transaction;

/**
 * Class ReceiveMoney
 *
 * This class encapsulates and implements an expressive API set
 * of methods required to place a call to the Hubtel Server
 * that in order to receive money from a customer.
 */
class ReceiveMoney extends Transaction
{
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
     * @return self
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
     * @return self
     */
    public function channel($channel)
    {
        return $this->setChannel($channel);
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
     * This method catches the receive money magic call from the PayClass.
     * It could be used to pass the full config or start the expressive api.
     *
     * @param  float|array $data
     * @return self
     */
    public function receiveMoney($data = [])
    {
        if (is_array($data)) {
            return $this->massAssign($data);
        }

        return $this->setAmount($data);
    }

    /**
     * [run description]
     * @return [type] [description]
     */
    public function run()
    {
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

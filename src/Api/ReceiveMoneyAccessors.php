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
 * ReceiveMoneyAccor Accessors
 * Accessors for the Receive Money Api Properties
 */
class ReceiveMoneyAccessors extends Api
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

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

use OVAC\HubtelPayment\Api\Transaction\MassAssignable;
use OVAC\HubtelPayment\Api\Transaction\Transaction;

/**
 * Class SendMoney
 *
 * This class encapsulates and implements an expressive API using a
 * set of methods to implement the required properties to
 * place a call to the Hubtel Server in order to
 * receive money from a customer.
 */
class SendMoney extends Transaction
{
    use MassAssignable;
    use Transactable;

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
    public function to($customerMsisdn)
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
     * This method sets the merchant/client referecne for easy association and
     * recognition on the merchant (client). Easily used to remember the
     * associate the transaction with a specific user.
     *
     * @param  string $clientReference This is a reference to the customer on the client end
     * @return self
     */
    public function clientReference($clientReference)
    {
        return $this->setClientReference($clientReference);
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

}

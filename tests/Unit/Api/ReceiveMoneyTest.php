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

namespace Unit\Api;

use OVAC\HubtelPayment\Api\Transaction\ReceiveMoney;
use OVAC\HubtelPayment\Pay;

class ReceiveMoneyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The name of the customer.
     *
     * @var string
     */
    private $customerName;
    /**
     * The customer email address
     *
     * @var string
     */
    private $customerEmail;
    /**
     * The customer mobile money number.
     *
     * @var string
     */
    private $customerMsisdn;
    /**
     * The mobile money provider channel
     *
     * @var string
     */
    private $channel;
    /**
     * The mobile money transaction amount
     *
     * @var string
     */
    private $amount;
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
    private $primaryCallbackURL;
    /**
     * The second URL for callback response in the
     * event of failure of  primary callback URL.
     *
     * @var string
     */
    private $secondaryCallbackURL;
    /**
     * The reference number that is provided by you
     * to reference a transaction from your end.
     *
     * @var string
     */
    private $clientReference;
    /**
     * The short description of the transaction.
     *
     * @var string
     */
    private $description;
    /**
     * The 6 digit unique token required to debit a Vodafone
     * Cash customer.  This token has to be generated and
     * provided by the Vodafone customer. The customer
     * dials *110# and selects menu item 6 to create
     * the voucher. It  expires after 5 minutes if unused
     *
     * @var string
     */
    private $token;
    /**
     * This allows the fees of the transaction to be charged
     * on the customer. If set to true the
     * AmountCharged = Amount + Charges.
     *
     * @var boolean
     */
    private $feesOnCustomer;

    protected function setUp()
    {

        $this->ammount = 10.89;
        $this->channel = 'mtn-gh';

        $this->description = 'Money for some trash like that oh';

        $this->customerMsisdn = '+233553577261';
        $this->customerName = 'Ariama Victor';
        $this->customerEmail = 'contact@ovac4u.com';

        $this->clientReference = array('userId' => 14028);

        $this->primaryCallbackURL = 'http://www.ovac4u.com/payment/payment-success';
        $this->secondaryCallbackURL = 'http://www.ovac4u.com/payment/payment-failed';

        $this->feesOnCustomer = true;

        //Only neccessry for Vodafone Cash users
        $this->token = '123456';
    }

    public function testExpressiveReceiveMoney()
    {
        $api = ReceiveMoney::amount($this->amount)
            ->from($this->customerMsisdn)
            ->description($this->description)
            ->reference($this->clientReference)
            ->customerName($this->customerName)
            ->customerEmail($this->customerEmail)
            ->channel($this->channel)
            ->callbackOnFail($this->secondaryCallbackURL)
            ->callbackOnSuccess($this->primaryCallbackURL)
            ->token($this->token)
            ->feesOnCustomer($this->feesOnCustomer);

        $this->assertEquals($api->getAmount(), $this->amount, 'The Amount on instance should be the amount charged');
        $this->assertEquals($api->getDescription(), $this->description, 'it should be the description passed in');
        $this->assertEquals($api->getClientReference(), $this->clientReference, 'it should be the reference passed in');
        $this->assertEquals($api->getCustomerName(), $this->customerName, 'it should be the customer name passed in');
        $this->assertEquals($api->getCustomerEmail(), $this->customerEmail, 'it should be the Email passed in');
        $this->assertEquals($api->getChannel(), $this->channel, 'it should be the same channel passed in');
        $this->assertEquals($api->getSecondaryCallbackURL(), $this->secondaryCallbackURL, 'it should be the same URL Passed in');
        $this->assertEquals($api->getPrimaryCallbackURL(), $this->primaryCallbackURL, 'it should be the same URL Passed in');
        $this->assertEquals($api->getToken(), $this->token, 'it should be the same Token that was passed in');
        $this->assertTrue($api->isFeesOnCustomer(), 'Fees should be on the customer.');

        return $api;
    }

    public function testReceiveMoneyMassAssignment()
    {

        $api = new ReceiveMoney(array(
            'customer' => array(
                'name' => $this->customerName,
                'email' => $this->customerEmail,
                'phone' => $this->customerMsisdn,
            ),
            'callback' => array(
                'success' => $this->primaryCallbackURL,
                'error' => $this->secondaryCallbackURL,
            ),
            'description' => $this->description,
            'clientReference' => $this->clientReference,
            'channel' => $this->channel,
            'token' => $this->token,
            'feesOnCustomer' => true,
        ));

        $this->assertEquals($api->getAmount(), $this->amount, 'The Amount on instance should be the amount charged');
        $this->assertEquals($api->getDescription(), $this->description, 'it should be the description passed in');
        $this->assertEquals($api->getClientReference(), $this->clientReference, 'it should be the reference passed in');
        $this->assertEquals($api->getCustomerName(), $this->customerName, 'it should be the customer name passed in');
        $this->assertEquals($api->getCustomerEmail(), $this->customerEmail, 'it should be the Email passed in');
        $this->assertEquals($api->getChannel(), $this->channel, 'it should be the same channel passed in');
        $this->assertEquals($api->getSecondaryCallbackURL(), $this->secondaryCallbackURL, 'it should be the same URL Passed in');
        $this->assertEquals($api->getPrimaryCallbackURL(), $this->primaryCallbackURL, 'it should be the same URL Passed in');
        $this->assertEquals($api->getToken(), $this->token, 'it should be the same Token that was passed in');
        $this->assertTrue($api->isFeesOnCustomer(), 'Fees should be on the customer.');

        return $api;
    }
}

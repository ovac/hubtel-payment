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

namespace OVAC\HubtelPayment\Tests\Unit\Api\Transaction;

use OVAC\HubtelPayment\Api\Transaction\SendMoney;
use OVAC\HubtelPayment\Pay;

class SendMoneyTest extends \PHPUnit_Framework_TestCase
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
    }

    public function testSendMoneyApi()
    {
        $api = SendMoney::amount($this->amount)
            ->to($this->customerMsisdn)
            ->customerName($this->customerName)
            ->customerEmail($this->customerEmail)
            ->channel($this->channel)
            ->callbackOnSuccess($this->primaryCallbackURL)
            ->callbackOnFail($this->secondaryCallbackURL)
            ->clientReference($this->clientReference)
            ->description($this->description);

        $this->assertEquals($api->getAmount(), $this->amount, 'The Amount on instance should be the amount charged');
        $this->assertEquals($api->getDescription(), $this->description, 'it should be the description passed in');
        $this->assertEquals($api->getClientReference(), $this->clientReference, 'it should be the reference passed in');
        $this->assertEquals($api->getCustomerMsisdn(), $this->customerMsisdn, 'it should be the reference passed in');
        $this->assertEquals($api->getCustomerName(), $this->customerName, 'it should be the customer name passed in');
        $this->assertEquals($api->getCustomerEmail(), $this->customerEmail, 'it should be the Email passed in');
        $this->assertEquals($api->getChannel(), $this->channel, 'it should be the same channel passed in');
        $this->assertEquals($api->getSecondaryCallbackURL(), $this->secondaryCallbackURL, 'it should be the same URL Passed in');
        $this->assertEquals($api->getPrimaryCallbackURL(), $this->primaryCallbackURL, 'it should be the same URL Passed in');

        return $api;
    }

    public function testPayCanMassAssignTransactions()
    {
        $sendMoney = Pay::sendMoney()->amount(10);
        $receiveMoney = Pay::receiveMoney()->from('0553577261');
    }
}

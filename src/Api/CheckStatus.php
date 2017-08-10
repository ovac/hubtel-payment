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
 * CheckStatus Class
 *
 * This class is responsible for checking the
 * status on the Hubtel Api service
 */
class CheckStatus extends Api
{
    /**
     * [$data description]
     * @var [type]
     */
    public $data;
    /**
     * [checkStatus description]
     * @param  string $data
     * @return string
     */
    public function checkStatus($data)
    {
        $this->data = $data;
    }
}

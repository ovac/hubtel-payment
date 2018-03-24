<?php

/**
 * @package     OVAC/Hubtel-Payment
 * @link        https://github.com/ovac/hubtel-payment
 *
 * @author      Ariama O. Victor (OVAC) <contact@ovac4u.com>
 * @link        http://ovac4u.com
 *
 * @license     https://github.com/ovac/hubtel-payment/blob/master/LICENSE
 * @copyright   (c) 2017, Rescope Inc
 */

namespace OVAC\HubtelPayment\Exception;

/**
 * Class MissingParameterException
 * throws OVAC\HubtelPayment\Exception\MissingParameterException
 */
class MissingParameterException extends HubtelException
{
    public function setMissingParameter($missingParameters)
    {
        $this->missingParameter = $missingParameters;
        $this->message = $this->getMessage() . ' ' . $this->getMissingParameter();
    }
}

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

namespace OVAC\HubtelPayment\Utility;

use OVAC\HubtelPayment\Exception\MissingParameterException;

/**
 * Trait CanCleanParameters
 */
trait CanCleanParameters
{
    /**
     * This method checks that all properties marked as
     * required have been assigned a value.
     *
     * A protected $parametersRequired property must contain the names of
     * the required parameters on the class that will use this trait method.
     * and all parameters must each have a defined get accessor on the
     * class object instance
     *
     * @return void
     * @throws OVAC\HubtelPayment\Exception\MissingParameterException
     */
    protected function propertiesPassRequired()
    {
        foreach ($this->parametersRequired as $key) {
            if ($this->accessPropertyByKey($key)) {
                return true;
            }

            throw new MissingParameterException('The ' . $key . ' parameter is required');
        }
    }
    /**
     * This method picks up all the defined properties the
     * $parameterRequired|$parameterOptional property
     * array list from the class object and returns
     * an array containing each list item name as
     * a key and the matching property value from
     * the class
     *
     * @return array An array of parameters with values
     */
    protected function propertiesToArray()
    {
        $properties = [
            $this->parametersRequired,
            $this->parametersOptional,
        ];

        $cleanProperty = [];

        foreach ($properties as $array) {
            foreach ($array as $key) {
                if ($this->accessPropertyByKey($key)) {
                    $cleanProperty[$key] = $this->accessPropertyByKey($key);
                }
            }
        }

        return $cleanProperty;
    }
    /**
     * This method calls the accessors for keys passed in
     * and returns back the value it receives from the
     * class instance
     *
     * throws an error if a defined parameter in the
     * $parameterRequired|$parameterOptional does
     * not have a reachable get[PropertyName] accessor
     * defined on the class instance.
     *
     * @param  string $key /$parameterRequired[(*)]|$parameterOptional[(*)]/
     * @return mixed
     * @throws \BadMethodCallException
     */
    protected function accessPropertyByKey($key)
    {
        try {
            $this->{'get' . ucwords($key)}();
        } catch (BadMethodCallException $e) {
            throw new \RunitimeException('The ' . $key . ' parameter must have a defined get' . ucwords($key) . ' method.');
        }
    }
}

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

namespace OVAC\HubtelPayment\Exception;

/**
 * Class HubtelException
 * throws OVAC\HubtelPayment\Exception\HubtelException
 */
class HubtelException extends \Exception
{
    /**
     * The error code returned by Hubtel.
     *
     * @var string
     */
    protected $errorCode;
    /**
     * The error type returned by Hubtel.
     *
     * @var string
     */
    protected $errorType;
    /**
     * The missing parameter returned by Hubtel.
     *
     * @var string
     */
    protected $missingParameter;
    /**
     * The raw output returned by Hubtel in case of exception.
     *
     * @var string
     */
    protected $rawOutput;
    /**
     * Returns the error type returned by Hubtel.
     *
     * @return string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }
    /**
     * Sets the error type returned by Hubtel.
     *
     * @param  string $errorCode
     * @return self
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;

        return $this;
    }
    /**
     * Returns the error type returned by Hubtel.
     *
     * @return string
     */
    public function getErrorType()
    {
        return $this->errorType;
    }
    /**
     * Sets the error type returned by Hubtel.
     *
     * @param  string $errorType
     * @return self
     */
    public function setErrorType($errorType)
    {
        $this->errorType = $errorType;

        return $this;
    }
    /**
     * Returns missing parameter returned by Hubtel with the error.
     *
     * @return string
     */
    public function getMissingParameter()
    {
        return $this->missingParameter;
    }
    /**
     * Sets the missing parameter returned by Hubtel with the error.
     *
     * @param  string $missingParameter
     * @return self
     */
    public function setMissingParameter($missingParameter)
    {
        $this->missingParameter = $missingParameter;

        return $this;
    }
    /**
     * Returns raw output returned by Hubtel in case of exception.
     *
     * @return string
     */
    public function getRawOutput()
    {
        return $this->rawOutput;
    }
    /**
     * Sets the raw output parameter returned by Hubtel in case of exception.
     *
     * @param  string $rawOutput
     * @return self
     */
    public function setRawOutput($rawOutput)
    {
        $this->rawOutput = $rawOutput;

        return $this;
    }
}

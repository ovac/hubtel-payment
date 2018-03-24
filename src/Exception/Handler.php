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

use GuzzleHttp\Exception\ClientException;

/**
 * Class Handler
 *
 * Handles Hubtel Exceptions
 * throws \OVAC\HubtelPayment\Exception\HubtelException
 */
class Handler
{
    /**
     * List of mapped exceptions and their corresponding status codes.
     *
     * @var array
     */
    protected $excByStatusCode = [
        // Often missing a required parameter
        400 => 'BadRequest',
        // Invalid ClientID and ClientSecret provided
        401 => 'Unauthorized',
        // Parameters were valid but request failed
        402 => 'InvalidRequest',
        // The requested resource doesn't exist
        404 => 'NotFound',
        // Something went wrong on Hubtel's end
        500 => 'ServerError',
        502 => 'ServerError',
        503 => 'ServerError',
        504 => 'ServerError',
    ];
    /**
     * Constructor.
     *
     * @param  \GuzzleHttp\Exception\ClientException $exception
     * @throws \OVAC\HubtelPayment\Exception\HubtelException
     */
    public function __construct(ClientException $exception)
    {
        $response = $exception->getResponse();
        $statusCode = $response->getStatusCode();
        $rawOutput = json_decode($response->getBody(true), true);
        $error = $rawOutput ?: [];
        $errorCode = isset($error['ResponseCode']) ? $error['ResponseCode'] : null;
        $errorType = isset($error['type']) ? $error['type'] : null;
        $message = isset($error['Message']) ? $error['Message'] : null;

        /**
         * This is depreciated and will be removed in version 2.
         *
         * Hubtel changed the 'Error' key to 'Errors'
         */
        isset($error['Errors']) ? ($error['Error'] = $error['Errors']) : null;

        $missingParameter = isset($error['Error']) ? $this->getMissingParameters($error['Error']) : null;

        $exception = $this->handleException(
            $message, $statusCode, $errorType, $errorCode, $missingParameter, $rawOutput
        );

        throw $exception;
    }
    /**
     * Guesses the FQN of the exception to be thrown.
     *
     * @param  string $message
     * @param  int    $statusCode
     * @param  string $errorType
     * @param  string $errorCode
     * @param  array  $missingParameter
     * @return \OVAC\HubtelPayment\Exception\HubtelException
     */
    protected function handleException($message, $statusCode, $errorType, $errorCode, $missingParameter, $rawOutput)
    {
        if ($statusCode === 400 && $errorCode == 4010) {
            $class = 'MissingParameter';
        } elseif (array_key_exists($statusCode, $this->excByStatusCode)) {
            $class = $this->excByStatusCode[$statusCode];
        } else {
            $class = 'Hubtel';
        }

        $class = '\\OVAC\\HubtelPayment\\Exception\\' . $class . 'Exception';
        $instance = new $class($message, $statusCode);
        $instance->setErrorCode($errorCode);
        $instance->setErrorType($errorType ?: $class);
        $instance->setMissingParameter($missingParameter);
        $instance->setRawOutput($rawOutput);

        return $instance;
    }

    protected function getMissingParameters($errors = [])
    {
        $missingParameters = [];

        foreach ($errors as $err) {
            if (isset($err['Field'])) {
                $missingParameters[] = $err['Field'];
            }
        }

        return implode($missingParameters, ', ');
    }
}

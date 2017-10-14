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

namespace OVAC\HubtelPayment\Api;

/**
 * Enforce implementation rules on all classes that need to
 * implement and access the API Methods
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
interface ApiInterface
{
    /**
     * Returns the API base url.
     *
     * @return string
     */
    public function getBaseUrl();
    /**
     * Send a GET request.
     *
     * @param  string $url
     * @param  array  $parameters
     * @return array
     */
    public function _get($url = null, $parameters = []);
    /**
     * Send a HEAD request.
     *
     * @param  string $url
     * @param  array  $parameters
     * @return array
     */
    public function _head($url = null, array $parameters = []);
    /**
     * Send a DELETE request.
     *
     * @param  string $url
     * @param  array  $parameters
     * @return array
     */
    public function _delete($url = null, array $parameters = []);
    /**
     * Send a PUT request.
     *
     * @param  string $url
     * @param  array  $parameters
     * @return array
     */
    public function _put($url = null, array $parameters = []);
    /**
     * Send a PATCH request.
     *
     * @param  string $url
     * @param  array  $parameters
     * @return array
     */
    public function _patch($url = null, array $parameters = []);
    /**
     * Send a POST request.
     *
     * @param  string $url
     * @param  array  $parameters
     * @return array
     */
    public function _post($url = null, array $parameters = []);
    /**
     * Send an OPTIONS request.
     *
     * @param  string $url
     * @param  array  $parameters
     * @return array
     */
    public function _options($url = null, array $parameters = []);
    /**
     * Executes the HTTP request.
     *
     * @param  string $httpMethod
     * @param  string $url
     * @param  array  $parameters
     * @return array
     */
    public function execute($httpMethod, $url, array $parameters = []);
}

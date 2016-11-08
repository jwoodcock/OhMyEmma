<?php

/**
 * This file is part of the Kite\OhMyEmma Library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Author Jacques Woodcock
 * @jwoodcock on GitHub
 * https://github.com/jwoodcock/CurlBack
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 */

namespace Kite\OhMyEmma;

class Request
{
    /**
     * Post Object to be sent with request 
     *
     * @var string
     */
    public $postData = '';

    /**
     * Object holding request response 
     *
     * @var string
     */
    public $response = '';

    /**
     * Holder of the response code 
     *
     * @var string
     */
    public $responseCode = '';

    /**
     * Method to use for request
     *
     * @var string
     */
    public $method = 'GET';

    /**
     * Emma account id from configuration.
     *
     * @var string
     */
    private $_id = '';

    /**
     * Emma public key from configuration.
     *
     * @var string
     */
    private $_public = '';

    /**
     * Emma private key from configuration.
     *
     * @var string
     */
    private $_private = '';

    /**
     * Emma url for api. 
     *
     * @var string
     */
    public $_baseURL = 'https://api.e2ma.net/';

    /**
     *
     * Main constructor for request object
     * 
     * @param string $account_id
     * @param string $public_key
     * @param string $private_key
     */
    public function __construct($account_id, $public_key, $private_key, $newBase = '')
    {
        $this->_id = $account_id;
        $this->_public = $public_key;
        $this->_private = $private_key;

        if (isset($newBase) && $newBase != '') {
            $this->_baseURL = $newBase;
        }
    }

    /**
     *
     * Object that makes requests based on 
     * set variables of this object and 
     * save response and respone code
     * 
     * @param string $requestPath
     */
    public function makeRequest($requestPath)
    {
        $url = $this->_baseURL;
        if (isset($requestPath) && $requestPath !== '') {
            $url .= $this->_id . "/". $requestPath;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERPWD, $this->_public . ":" . $this->_private);
        curl_setopt($ch, CURLOPT_URL, $url);

        if (!empty($this->postData)) {
            curl_setopt($ch, CURLOPT_POST, count($this->postData));
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->postData));
        }

        if ($this->method !== 'GET' && $this->method !== 'POST') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method); 
        } else if ($this->method === 'GET') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method); 
            curl_setopt($ch, CURLOPT_HTTPGET, 'GET');
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $this->response = curl_exec($ch);
        $this->responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $this->postData = '';
        $this->method = 'GET';
        curl_setopt($ch, CURLOPT_HTTPGET, 'GET');

        curl_close($ch);

    }

    /**
     * Method for calling request and returning
     * responses for all member functions
     *
     * @param string $url
     */
    public function processRequest($url)
    {

        $this->makeRequest($url);

        $response = array(
            'details' => $this->response,
            'code' => $this->responseCode,
        );

        return $response;

    }
}


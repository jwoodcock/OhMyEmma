<?php

/**
 * This file is part of the Kite\OhMyEmma Library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) 2012 Ben Ramsey <http://benramsey.com> 
 * @license http://opensource.org/licenses/MIT MIT  
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
    private $method = 'GET';

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
    private $_baseURL = 'https://api.e2ma.net/';

    /**
     *
     * Main constructor for request object
     * 
     * @param string $account_id
     * @param string $public_key
     * @param string $private_key
     */
    public function _construct($account_id, $public_key, $private_key, $baseURL = '')
    {
        $this->_id = $account_id;
        $this->_public = $public_key;
        $this->_private = $private_key;

        if (isset($baseURL) && $baseURL !== '') {
            $this->_baseURL = $baseURL;
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
        $url = $this->_baseURL . $this->_id . "/". $requestPath;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERPWD, $this->_public . ":" . $this->_private);
        curl_setopt($ch, CURLOPT_URL, $url);

        if (isset($this->postData)) {
            curl_setopt($ch, CURLOPT_POST, count($this->postData));
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->postData));
        }

        if ($this->method !== 'GET' && $this->method !== 'POST') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method); 
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $this->response = curl_exec($ch);
        $this->responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

    }

}


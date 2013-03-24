<?php

/*
 * This is the test $_request object that
 * can access the mock responses and return
 * for testing. 
 */

namespace mocks;

class RequestMock
{
    /*
     * Property to set to pull
     * the right mock folder
     */
    public $baseURL = '';
    public $callURL = '';
    public $postData = array();
    public $method = 'GET';

    public function __construct()
    {
    }

    public function processRequest($url = '')
    {
        $this->baseURL = $url;
        if (count($this->postData) >  0) {
            $this->baseURL .= "?" . http_build_query($this->postData);
        }
        return $this->baseURL;
    }

}

<?php

/*
 * This is the test $_request object that
 * can access the mock responses and return
 * for testing. 
 */

namespace Test\Kite\OhMyEmma;

class RequestMock
{
    /*
     * Property to set to pull
     * the right mock folder
     */
    public $_baseURL = '';

    public function __construct()
    {
    }

    public function processRequest($url)
    {
        if (in_array($_baseURL, $folders) !== true) {
            $return = "No mock folder found.";
        } else {
            $return = require_once($this->_baseURL.$url);
        }
        return $return;
    }

}

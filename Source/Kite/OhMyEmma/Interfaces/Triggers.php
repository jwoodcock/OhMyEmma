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

namespace Kite\OhMyEmma\Interfaces;

/**
 * Class for manipulating trigger data
 * using the /triggers enpoint. For full details
 * of data formats and individual endpoints refer
 * to MyEmma.com's documentation. Last found here:
 * http://api.myemma.com/api/external/triggers.html
 */
class Triggers 
{

    /**
     * Request Object passed in via the 
     * factory controller. 
     *
     * @var object 
     */
    private $_request = '';

    /**
     * Construct the member object which 
     * requires the request object from 
     * the factory
     *
     * @param object $request
     */
    public function __construct($request)
    {
        if (is_object($request)) {
            $this->_request = $request;
        } else {
            return 'You can not use this class without a valid request object';
        }
    }

    /**
     * Method for retreaving all triggers,
     * individual triger details or mailings
     * envolving a specific trigger.
     *
     * @param string $triggerId
     * @param boolan $mailings
     */
    public function getTriggers($triggerId = '', $mailings = false)
    {
        $this->_request->method = "GET";
        $url = '/triggers';
        if ($triggerId !== '') {
            $url .= '/' . $triggerId;
            if ($mailings === true) {
                $url .= '/mailings';
            }
        }

        return $this->_request->processRequest($url);
    }

    /**
     * Method for creating or updating a trigger.
     * Refer to Emma's documentation on the structure
     * of the trigger array.
     *
     * @param array $trigger
     * @param string $triggerId
     */
    public function addUpdateTrigger($trigger, $triggerId = '')
    {
        $url = '/triggers';
        $this->_request->postData = $trigger;
        if ($triggerId !== '') {
            $this->_request->method = 'PUT';
            $url .= '/' . $triggerId; 
        } else {
            $this->_request->method = 'POST';
        }

        return $this->_request->processRequest($url);
    }

    /**
     * Method for deleting a trigger.
     *
     * @param string $triggerId
     */
    public function removeTrigger($triggerId)
    {
        $this->_request->method = 'DELETE';
        $url = '/triggers/' . $triggerId;

        return $this->_request->processRequest($url);
    }

}

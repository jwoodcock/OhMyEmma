<?php

/**
 * This file is part of the Kite\OhMyEmma Library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Author Neal Lambert
 * @crankeye on GitHub
 * https://github.com/jwoodcock/CurlBack
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 */

namespace Kite\OhMyEmma\Interfaces;

/**
 * Class for creating events using the /events endpoint.
 * For full details of data formats and individual endpoints
 * refer to MyEmma.com's documentation. Last found here:
 * http://api.myemma.com/api/external/event_api.html
 */
class Events
{

    /**
     * Request Object passed in via the 
     * factory controller. 
     *
     * @var object 
     */
    private $_request = '';

    /**
     * Emma url for events api.
     *
     * @var string
     */
    private $_baseURL = 'https://events.e2ma.net/v1/';

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
            $this->_request = clone $request;
            $this->_request->_baseURL = $this->_baseURL;
        } else {
            return 'You can not use this class without a valid request object';
        }
    }

    /**
     * Method for creating a new event
     * Must include a valid email address and the
     * member must currently have and "Active" status.
     *
     * @param string $email
     * @param array $fields
     */
    public function createEvent($email, $fields = [])
    {
        $this->_request->method = 'POST';
        $url = "events";

        $fields['email'] = $email;
        $this->_request->postData = $fields;

        return $this->_request->processRequest($url);
    }

}

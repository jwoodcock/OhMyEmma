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
 * Class for manipulating webhooks
 * using the /webhooks enpoint. For full details
 * of data formats and individual endpoints refer
 * to MyEmma.com's documentation. Last found here:
 * http://api.myemma.com/api/external/webhooks.html
 */
class Webhooks 
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
     * Method to retreave information on webhooks
     * that are available and individual specifics
     * as well events associated with a webhook by
     * changing $events to true.
     *
     * @param string $webhookId
     * @param boolean $events
     */
    public function getWebhooks($webhookId = '', $events = false)
    {
        $this->_request->method = 'GET';
        $url = '/webhooks';
        if ($webhookId != '' && $events === false) {
            $url .= '/' . $webhookId;
        } else if ($events === true) {
            $url .= '/events';
        }

        return $this->_request->processRequest($url);
    }

    /**
     * Method to create or update a webhook.
     * Refer to Emma's documentation for the proper
     * structure for $webhook array.
     *
     * @param array $webhook
     * @param string $webhookId
     */
    public function createUpdateWebhook($webhook, $webhookId = '')
    {
        $url = '/webhooks';
        $this->_request->postData = $webhook;
        if ($webhookId === '') {
            $this->_request->method = 'POST';
        } else {
            $this->_request->method = 'PUT';
            $url .= '/' . $webhookId;
        }

        return $this->_request->processRequest($url);
    }

    /**
     * Method to remove a single or all
     * webhooks.
     *
     * @param string $webhookId
     */
    public function removeWebhook($webhookId) 
    {
        $this->_request->method = 'DELETE';
        $url = '/webhooks';
        if ($webhookId !== '') {
            $url .= '/' . $webhookId;
        }

        return $this->_request->processRequest($url);
    }

}

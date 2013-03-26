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
 * Class for retreaving and manipulating response data
 * using the /response enpoint. For full details
 * of data formats and individual endpoints refer
 * to MyEmma.com's documentation. Last found here:
 * http://api.myemma.com/api/external/response.html
 */
class Responses 
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
     * Method for retreaving response summary.
     * You can filter results as specified 
     * in the Emma documentation. To do so, 
     * pass an array of filters in the $filter
     * variable. 
     *
     * @param array $filters
     */
    public function getResponses($filters = '')
    {
        $this->_request->method = 'GET';
        $url = '/response';
        if ($filters !== '') {
            $url .= '?' . http_build_query($filters);
        }

        return $this->_request->processRequest($url);
    }

    /**
     * Method for retreaving individual mailing
     * response and sub-information.
     *
     * @param string $mailingId
     * @param string $subInformation
     */
    public function getResponseDetails($mailingId, $subInformation = '')
    {
        $this->_request->method = 'GET';
        $url = '/response/' . $mailingId;
        if ($subInformation !== '') {
            switch($subInformation) {
                case 'sends':
                    $url .= '/sends';
                    break;
                case 'in_progress':
                    $url .= '/in_progress';
                    break;
                case 'deliveries':
                    $url .= '/deliveries';
                    break;
                case 'opens':
                    $url .= '/opens';
                    break;
                case 'links':
                    $url .= '/links';
                    break;
                case 'clicks':
                    $url .= '/clicks';
                    break;
                case 'forwards':
                    $url .= '/forwards';
                    break;
                case 'outputs':
                    $url .= '/outputs';
                    break;
                case 'signups':
                    $url .= '/signups';
                    break;
                case 'shares':
                    $url .= '/shares';
                    break;
                case 'customer_shares':
                    $url .= '/customer_shares';
                    break;
                case 'customer_shares_clicks':
                    $url .= '/customer_shares_clicks';
                    break;
                case 'customer_share':
                    $url .= '/customer_share';
                    break;
                case 'shares/overview':
                    $url .= '/shares/overview';
                    break;
            }
        }

        return $this->_request->processRequest($url);
    }

}

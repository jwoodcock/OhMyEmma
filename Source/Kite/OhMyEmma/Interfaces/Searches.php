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
 * Class for manipulating searches data
 * using the /searches enpoint. For full details
 * of data formats and individual endpoints refer
 * to MyEmma.com's documentation. Last found here:
 * http://api.myemma.com/api/external/searches.html
 */
class Searches 
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
     * Method for retreaving all searches,
     * individual search details, or members 
     * that match a search by providing $members
     * as true. You can also include deleted
     * searches by changing $deleted to true
     *
     * @param string $searchId
     * @param boolan $members
     */
    public function getSearches($searchId = '', $members = false, $deleted = false)
    {
        $this->_request->method = "GET";
        $url = '/searches';
        if ($searchId !== '') {
            $url .= '/' . $searchId;
            if ($members === true) {
                $url .= '/members';
            }
        }
        if ($deleted === true) {
            $url .= '?deleted=true';
        }

        return $this->_request->processRequest($url);
    }

    /**
     * Method for creating or updating a search.
     * Refer to Emma's documentation on the structure
     * of the search array.
     *
     * @param array $search
     * @param string $searchId
     */
    public function addUpdateSearch($search, $searchId = '')
    {
        $url = '/searches';
        $this->_request->postData = $search;
        if ($searchId !== '') {
            $this->_request->method = 'PUT';
            $url .= '/' . $searchId; 
        } else {
            $this->_request->method = 'POST';
        }

        return $this->_request->processRequest($url);
    }

    /**
     * Method for deleting a search.
     *
     * @param string $search$
     */
    public function removeSearch($searchId)
    {
        $this->_request->method = 'DELETE';
        $url = '/searches/' . $searchId;

        return $this->_request->processRequest($url);
    }

}

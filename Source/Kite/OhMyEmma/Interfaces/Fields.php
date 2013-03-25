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
 * Class for manipulating custom data fields  
 * using the /fields enpoint. For full details
 * of data formats and individual endpoints refer
 * to MyEmma.com's documentation. Last found here:
 * http://api.myemma.com/api/external/fields.html
 */
class Fields 
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
     * Method for retreaving data on an individual field
     * or all fields with the ability to show deleted 
     * fields which are hidden by default.
     *
     * @param string $fieldId
     * @param boolean $showDeleted
     */
    public function getField($fieldId = '', $showDeleted = false)
    {
        $this->_request->method = 'GET';
        $url = '/fields';
        if ($fieldId != '') {
            $url .= '/' . $fieldId;
        }
        if ($showDeleted === true) {
            $url .= '?deleted=true';
        }

        return $this->_request->processRequest($url);
    }

    /**
     * Method for adding or updating a new field
     * depending if the field_id has been provided. 
     * To see the structure of the field data in the 
     * the fieldData array, refer to Emma's 
     * documentation.
     *
     * @param array $fieldData
     * @param string $fieldId
     */
    public function addUpdateField($fieldData, $fieldId = '')
    {
        $this->_request->method = "POST";
        $this->_request->postData = $fieldData;
        $url = "/fields";
        if ($fieldId !== '') {
            $this->_request->method = "PUT";
            $url .= '/' . $fieldId;
        }

        return $this->_request->processRequest($url);
    }

    /**
     * Method for deleting a field.
     *
     * @param string $fieldId
     */
    public function removeField($fieldId)
    {
        $this->_request->method = "DELETE";
        $url = '/fields/'.$fieldId;

        return $this->_request->processRequest($url);
    }

    /**
     * Method for clearing all member data
     * associated with the specified field. 
     *
     * @param string $fieldId
     */
    public function clearMemberData($fieldId)
    {
        $this->_request->method = "DELETE";
        $url = '/fields/'.$fieldId;

        return $this->_request->processRequest($url);
    }

}

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
 * Class for manipulating creation, updated and deleting 
 * groups using the /groups endpoint. For full details
 * of data formats and individual endpoints refer
 * to MyEmma.com's documentation. Last found here:
 * http://api.myemma.com/api/external/groups.html
 */
class Groups 
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
     * Method for getting all groups, single group 
     * information or a groups members. Provide
     * the groupId for single group information,
     * groupId & members set to true for a groups
     * members.
     *
     * @param string $groupId
     * @param boolean $members
     */
    public function getGroups($groupId = '', $members = false)
    {
        $this->_request->method = 'GET';
        $url = "/groups";
        if ($groupId !== '') {
            $url .= "/" . $groupId;
            if ($members === true) {
                $url .= "/members";
            }
        }

        return $this->_request->processRequest($url);
    }

    /**
     * Method to create group(s) or update a group
     * by providing the groupId.
     * Refer to Emma's documentation for array
     * structure of data array.
     *
     * @param array $groups
     * @param string $groupId
     */
    public function createUpdateGroup($groups, $groupId = '')
    {
        if ($groupId != '') {
            $this->_request->method = 'PUT';
            $this->_request->postData = $groups;
            $url = '/groups/' . $groupId;
        } else {
            $this->_request->method = 'POST';
            $this->_request->postData = $groups;
            $url = '/groups';
        }

        return $this->_request->processRequest($url);
    }

    /**
     * Method to delete a single group.
     *
     * @param string $group
     */
    public function deleteGroup($groupId)
    {
        $url = '/groups/' . $groupId;
        $this->_request->method = 'DELETE';

        return $this->_request->processRequest($url);
    }

    /**
     * Method to add  remove list of members to
     * from a group. Set $remove to true to
     * remove provided list of members from group.
     *
     * @param string $groupId
     * @param array $members
     * @param boolean $remove
     */
    public function addRemoveMembers($groupId, $members, $remove = false)
    {
        $this->_request->method = "PUT";
        $this->_request->postData = $members;
        $url = "/groups/".$groupId."/members";
        if ($remove === true) {
            $url .= "/remove";
        }

        return $this->_request->processRequest($url);
    }

    /**
     * Method to remove all members from a group
     * or all members of all groups as a background
     * job by setting removeAll true. You can also filter 
     * via status. Refer to Emma's documentation for 
     * accepted status types.
     *
     * @param string $groupId
     * @param string $status
     * @param boolean $removeAll
     */
    public function removeAllMembers($groupId, $status = '', $removeAll = false)
    {
        $this->_request->method = "DELETE";
        $url = "/groups/".$groupId."/members";
        if ($removeAll === true) {
            $url .= "/remove";
        }
        if ($status !== '') {
            $url .= "?member_status_id=" . $status;
        }

        return $this->_request->processRequest($url);
    }

    /**
     * Method to copy all users from one group 
     * to another. 
     *
     * @param string $fromGroup
     * @param string $toGroup
     * @param array $status
     */
    public function copyGroupMembers($fromGroup, $toGroup, $status)
    {
        $this->_request->method = "PUT";
        $this->_request->postData = $status;
        $url = "/groups/" . $fromGroup ."/". $toGroup . "/members/copy";

        return $this->_request->processRequest($url);
    }

}

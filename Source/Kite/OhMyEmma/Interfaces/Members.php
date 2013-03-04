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

namespace Kite\OhMyEmma\Interfaces;

/**
 * Class for manipulating member records 
 * using the /members enpoint
 */
class Members
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
        if ($_request === '' && isset($request) && $request != '') {
            $this->_request = $request;
        } else {
            return 'You can not use this class without a valid request object';
        }
    }

    /**
     * Request to retreave list of members 
     * or filtered to one member via the $member
     * variable which can be a member id or email.
     *
     * @param string $member
     * @param boolean $optOut
     * @param array $filters
     */
    public function getMembers($member = '', $optOut = false, $filters = '')
    {
        $url = '/members';

        if ($member !== '' 
            && filter_var($member, FILTER_VALIDATE_EMAIL) !== false
        ) {
            $url .= "/email/".$member;
        } else if ($member !== '') {
            $url .= $member;
            if ($optOut === true) {
                $url .= '/optout';
            }
        }

        if (is_array($filters) === true) {
            $url .= http_build_query($filters);
        }

        return $this->_processRequest($url);

    }

    /**
     * Method for creating or adding a new member
     * where member can either be an array of multiple
     * members or single member. If optout is true the
     * user is opted out of mailing services
     *
     * @param array $member
     * @param boolean $output
     */
    public function updateAddMember($member, $optout = false)
    {
        if (is_array($member) === true) {

            $this->_request->postData = $member;
            $this->_request->method = 'POST';

            if (array_key_exists('members', $member) === true) {
                $url = '/members';
            } else {
                $url = '/members/add';
            }

        }

        if ($optout === true) {
            $this->_request->method = 'PUT';
            $url = '/members/email/optout/' . $member['email'];
        }

        return $this->_processRequest($url);

    }

    /**
     * Method to delete a group of member via an array
     * of member ids or a single member id.
     *
     * @param string|array $member
     */
    public function removeMember($member)
    {

        if (is_array($member) === true) {
            $this->_request->postData = $member;
            $this->_request->method = 'PUT';
            $url = '/members/delete';
        } else {
            $this->_request->method = 'DELETE';
            $url = '/members/'.$member;
        }

        return $this->_processRequest($url);

    }

    /**
     * Change a member's status
     * for status codes, see Emma documentation
     *
     * @param array $member
     */
    public function changeStatus($member)
    {
        if (is_array($member)) {
            $this->_request->method = 'PUT';
            $this->_request->postData = $member;
            $url = "/members/status";
        }

        return $this->_processRequest($url);

    }

    /**
     * Return a list of groups that a single
     * member is associated with
     *
     * @param string $member
     */
    public function getGroups($member)
    {
        $this->_request->method = "GET";
        $url = '/members/'.$member.'/groups';

        return $this->_processRequest($url);
    }

    /**
     * Method allows the addition or removal of bulk
     * groups to/from a member, reverse that, start over. 
     * Review Emma documentation for format of $groups array.
     * $remove specifics if you are removing or adding.
     *
     * @param string $member
     * @param array $groups
     * @param boolean $remove
     */
    public function addRemoveGroupMembers($member, $groups, $remove = false)
    {
        $this->_request->method = "PUT";
        $this->_request->postData = $groups;
        if ($remove === false) {
            $url = '/members/'.$member.'/groups';
        } else {
            $url = '/members/'.$member.'/groups/remove';
        }

        return $this->_processRequest($url);

    }

    /**
     * This method DELETES all members. Why would you use
     * this? You can filter via member status. Refer to 
     * Emma's documentation for accepted status codes.
     *
     * @param string $member
     */
    public function removeAllMembers($status)
    {
        $this->_request->method = "DELETE";
        $url = '/members?member_status_id='.$status;

        return $this->_processRequest($url);

    }

    /**
     * Either removes a specified member from all
     * groups if $member is a string or removes a 
     * member from specified list of groups if $member
     * is an array. See Emma documenation for format
     * of the array.
     *
     * @param string|array $member
     */
    public function removeFromGroup($member)
    {
        if (is_array($member) === false) {
            $this->_request->method = "Delete";
            $url = '/members/'.$member.'/groups';
        } else {
            $this->_request->method = "PUT";
            $this->_request->postData = $member;
            $url = '/members/groups/remove';
        }

        return $this->_processRequest($url);

    }

    /**
     * Method for retreaving a members full
     * mailing history.
     *
     * @param string $member
     */
    public function getMemberMailingHistory($member)
    {
        $this->_requests->method = 'GET';
        $url = '/members/'.$member.'/mailings';

        return $this->_processRequest($url);
    }

    /**
     * Method for selecting import information
     * either via import_id or all imports.
     *
     * @param string $importId
     * @param boolean $showMemebersOnly
     */
    public function getImportInformation(
        $importId = '',
        $showMemebersOnly = false
    )
    {
        $this->_request->method = "GET";
        if ($importId !== '') {
            $url = '/members/imports/'.$importId;
            if ($showMembersOnly === true) {
                $url .= '/members';
            }
        } else {
            $url = '/members/imports';
        }

        return $this->_processRequest($url);
    }

    /**
     * Method to mark an import as deleted
     *
     * @param string $importId
     */
    public function deleteImport($importId)
    {
        $this->_request->method = "DELETE";
        $url = '/members/imports/'.$importId.'/delete';

        return $this->_processRequest($url);
    }

    /**
     * Copy members with a certain status to a
     * group. Review the Emma documentation
     * for how this array should be structured.
     *
     * @param string $statuses
     */
    public function groupStatuses($statuses)
    {
        $this->_request->method = "PUT";
        $url = '/members/imports/'.$importId.'/delete';

        return $this->_processRequest($url);
    }

    /**
     * Method for converting one group of members
     * from one status to another. See Emma documentation
     * for approved statuses. 
     *
     * @param string $fromStatus
     * @param string $toStatus
     * @param array $limitToGroup
     */
    public function convertStatus($fromStatus, $toStatus, $limitGroup = '')
    {
        
        $this->_request->method = "PUT";
        if ($limitGroup != '') {
            $this->_request->postData = $limitGroup;
        }
        $url = '/members/status/'.$fromStatus.'/to/'.$toStatus;

        return $this->_processRequest($url);

    }

    /**
     * Method for calling request and returning
     * responses for all member functions
     *
     * @param string $url
     */
    private function _processRequest($url)
    {

        $this->_request->makeRequest($url);

        $response = array(
            'details' => $this->_request->response,
            'code' => $this->_request->responseCode,
        );

        return $response;

    }

}

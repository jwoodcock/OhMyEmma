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

    public function __construct($request)
    {
        $this->_request = $request;
    }

    /**
     * Request to retreave list of members 
     * or filtered to one member via the $member
     * variable which can be a member id or email.
     *
     * @param string $member
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

        $this->_request->makeRequest($url);

        $response = array(
            'details' => $this->_request->response,
            'code' => $this->_request->responseCode,
        );

        return $response;
    }

    /**
     * Method for creating or adding a new
     * member
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
 
        $this->_request->makeRequest($url);

        $response = array(
            'details' => $this->_request->response,
            'code' => $this->_request->responseCode,
        );

        return $response;
    }

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

        $this->_request->makeRequest($url);

        $response = array(
            'details' => $this->_request->response,
            'code' => $this->_request->responseCode,
        );

        return $response;

    }

    public function changeStatus($member)
    {
        if (is_array($member)) {
            $this->_request->method = 'PUT';
            $this->_request->postData = $member;
            $url = "/members/status";
        }

        $this->_request->makeRequest($url);

        $response = array(
            'details' => $this->_request->response,
            'code' => $this->_request->responseCode,
        );

        return $response;
    }

    public function getGroups($member)
    {
        $this->_request->method = "GET";
        $url = '/members/'.$member.'/groups';
 
        $this->_request->makeRequest($url);

        $response = array(
            'details' => $this->_request->response,
            'code' => $this->_request->responseCode,
        );

        return $response;
    }

    public function addRemoveGroupMembers($member, $groups, $remove = false)
    {
        $this->_request->method = "PUT";
        $this->_request->postData = $groups;
        if ($remove === false) {
            $url = '/members/'.$member.'/groups';
        } else {
            $url = '/members/'.$member.'/groups/remove';
        }
 
        $this->_request->makeRequest($url);

        $response = array(
            'details' => $this->_request->response,
            'code' => $this->_request->responseCode,
        );

        return $response;
    }

    public function removeAllMembers($status)
    {
        $this->_request->method = "DELETE";
        $url = '/members?member_status_id='.$status;

        $this->_request->makeRequest($url);

        $response = array(
            'details' => $this->_request->response,
            'code' => $this->_request->responseCode,
        );

        return $response;
    }

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

        $this->_request->makeRequest($url);

        $response = array(
            'details' => $this->_request->response,
            'code' => $this->_request->responseCode,
        );

        return $response;
    }
}

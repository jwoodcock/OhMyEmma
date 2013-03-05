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
 * Class for manipulating mailings and their specifics
 * using the /mailings enpoint. For full details
 * of data formats and individual endpoints refer
 * to MyEmma.com's documentation. Last found here:
 * http://api.myemma.com/api/external/mailings.html
 */
class Mailings 
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
     * Method for retreaving all mailings,
     * individual mailing details, or members of 
     * mailings.
     *
     * @param string $mailingId
     * @param boolean $member
     */
    public function getMailings($mailingId = '', $member = false)
    {
        $this->_request->method = "GET";
        $url = '/mailings';
        if ($mailingId !== '') {
            $url .= '/' . $mailingId;
            if ($member === true) {
                $url .= '/members';
            }
        }

        return $this->_request->processRequest($url);
    }

    /**
     * Method for retreaving a members personalized
     * content from a mailing. 
     *
     * @param string $mailingId
     * @param string $memberid
     */
    public function getMemberContent($mailingId, $memberId)
    {
        $this->_request->method = 'GET';
        $url = '/mailings/'.$mailingId.'/messages/'.$memberId;

        return $this->_request->processRequest($url);
    }

    /**
     * Method for retreaving the specific sub-aspects
     * of a mailing. 
     *
     * @param string $mailingId
     * @param string $retreave
     */
    public function getMailingSubsection($mailingId, $retreave)
    {
        $this->_request->method = 'GET';
        $url = '/mailings/' . $mailingId;
        switch ($retreave) {
            case 'groups':
                $url .= '/groups';
                break;
            case 'searches':
                $url .= '/searches';
                break;
            case 'headsup':
                $url .= '/headsup';
                break;
            case 'members':
                $url .= '/members';
                break;
        }

        return $this->_request->processRequest($url);
    }

    /**
     * Method for updating status of a current
     * mailing. Status at this time can be 
     * canceled, paused, or ready. 
     * See Emma's documentation for more information.
     *
     * @param string $mailingId
     * @param array $status
     */
    public function changeStatus($mailingId, $status)
    {
        $this->_request->method = "PUT";
        $this->_request->postData = $status;
        $url = '/mailings/'.$mailingId;

        return $this->_request->processRequest($url);
    }

    /**
     * Method for removing a mailing from the 
     * mailing list.
     *
     * @param string $mailingId
     */
    public function removeMailing($mailingId)
    {
        $this->_request->method = "DELETE";
        $url = '/mailings/'.$mailingId;

        return $this->_request->processRequest($url);
    }

    /**
     * Method for canceling a mailing from the 
     * mailing list. If mailing is not pending
     * a 404 will be returned and no change will
     * take affect.
     *
     * @param string $mailingId
     */
    public function cancelMailing($mailingId)
    {
        $this->_request->method = "DELETE";
        $url = '/mailings/cancel/'.$mailingId;

        return $this->_request->processRequest($url);
    }

    /**
     * Method for forwarding a previous message from
     * a member to nother recipients or create a new
     * mailing and forward to new recipients. Refer
     * to Emma's documentation for details on 
     * $recipients array.
     *
     * @param string $mailingId
     * @param array $recipients
     * @param string $memberId
     */
    public function forwardToRecipients($mailingId, $recipients, $memberId = '')
    {
        $this->_request->method = "POST";
        $this->_request->postData = $recipients;
        if ($memberId === '') {
            $url = '/mailings/' . $mailingId;
        } else {
            $url = '/forwards/' . $mailingId . '/' . $memberId;
        }

        return $this->_request->processRequest($url);
    }

    /**
     * Method for validating the elements of mailing. 
     * See Emma's documentation for the structure of the 
     * $contents array.
     *
     * @param array $contents
     */
    public function validateMailingContents($contents)
    {
        $this->_request->method = "POST";
        $this->_request->postData = $contents;
        $url = '/mailings/validate';

        return $this->_request->processRequest($url);
    }

    /**
     * Method for declaring a winner of a split test
     * mannually. 
     *
     * @param string $mailingId
     * @param string $winnerId
     */
    public function declareSplitTestWinner($mailingId, $winnerId)
    {
        $this->_request->method = "POST";
        $url = '/mailings/' . $mailingId . '/winner/' . $winnerId;

        return $this->_request->processRequest($url);
    }

}

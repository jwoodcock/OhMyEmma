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

namespace Kite\OhMyEmma;

use Kite\OhMyEmma\Interfaces\Events;
use Kite\OhMyEmma\Interfaces\Fields;
use Kite\OhMyEmma\Interfaces\Groups;
use Kite\OhMyEmma\Interfaces\Mailings;
use Kite\OhMyEmma\Interfaces\Members;
use Kite\OhMyEmma\Interfaces\Responses;
use Kite\OhMyEmma\Interfaces\Searches;
use Kite\OhMyEmma\Interfaces\Triggers;
use Kite\OhMyEmma\Interfaces\Webhooks;
use Kite\OhMyEmma\Request;

class Emma
{


    /**
     * cURL request object
     *
     * @var object 
     */
    private $_request = '';

    /**
     *
     * Main constructor for this factory class
     * which builds an object with the correct
     * methods based on interaction goal with 
     * the Emma API
     * 
     * @param string $account_id
     * @param string $public_key
     * @param string $private_key
     * @param string $interface
     */

    public function __construct(
        $account_id, 
        $public_key, 
        $private_key)
    {

        $this->_request = new Request(
            $account_id, 
            $public_key, 
            $private_key
        );
    }

    /**
     *
     * Magic method called when reading inaccessible properties
     * This method will instantiate interfaces if they have not
     * yet been instantiated.
     * 
     * @param string $property
     */
    public function __get($interface){
        

        //check if the passed property matches our interfaces
        if(in_array($interface, array(
            'Events',
            'Fields',
            'Groups',
            'Mailings',
            'Members',
            'Responses',
            'Searches',
            'Triggers',
            'Webhooks')))
        {
            //if this interface has not been instantiated, create a new instance
            if(!isset($this->$interface)){
                $reflectedInterface = new \ReflectionClass('\\Kite\\OhMyEmma\\Interfaces\\' . $interface);
                $this->$interface = $reflectedInterface->newInstanceArgs(array('_request' => $this->_request));
                return $this->$interface;
            }

            //otherwise, return the existing instance
            return $this->$interface;
        }
        return;
    }
}

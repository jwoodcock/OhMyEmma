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

namespace Kite\OhMyEmma;

use Kite\OhMyEmma\Fields;
use Kite\OhMyEmma\Groups;
use Kite\OhMyEmma\Mailings;
use Kite\OhMyEmma\Members;
use Kite\OhMyEmma\Response;
use Kite\OhMyEmma\Searches;
use Kite\OhMyEmma\Triggers;
use Kite\OhMyEmma\Webhooks;
use Kite\OhMyEmma\Request;

class Emma
{

    /**
     * Object built from interface request 
     *
     * @var object 
     */
    public $control = '';

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
        $private_key, 
        $interface = '')
    {

        $this->_request = new Request(
            $account_id, 
            $public_key, 
            $private_key
        );

        if (isset($interface) && $interface != '') {
            $this->build($interface, $this->_request);
        }

    }

    /**
     *
     * Factory method for building control object.
     * 
     * @param string $interface
     */

    public function build($interface, $_request)
    {
        switch ($interface) {
            case 'fields':
                $this->control = new Fields($_request);
                break;

            case 'groups':
                $this->control = new Groups($_request);
                break;

            case 'mailings';
                $this->control = new Mailings($_request);
                break;

            case 'members':
                $this->control = new Members($_request);
                break;

            case 'response';
                $this->control = new Response($_request);
                break;

            case 'searches';
                $this->control = new Searches($_request);
                break;

            case 'triggers';
                $this->control = new Triggers($_request);
                break;

            case 'webhooks';
                $this->control = new Webhooks($_request);
                break;
        }
    }

}

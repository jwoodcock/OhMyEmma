<?php

namespace Kite\OhMyEmma\Interfaces;

use mocks\RequestMock as RequestMock;

class EventsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Members
     */
    protected $members;
    protected $request;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->request = new RequestMock();
        $this->assertEquals('', $this->request->baseURL);
 
        $this->members = new Members($this->request);
        $this->assertObjectHasAttribute('_request', $this->members);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Kite\OhMyEmma\Interfaces\Events::createEvent
     */
    public function testCreateEvent()
    {
        $this->request = new RequestMock();
        $this->events = new Events($this->request);

        // Test creating a new event
        $this->assertEquals('events?email=foo%40baz.com', $this->events->createEvent('foo@baz.com'), ['event_name' => 'foo_event']);
    }
}

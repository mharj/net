<?php

use mharj\net\Socket;
use mharj\net\InetAddress;
use mharj\net\InetSocketAddress;

class SocketTest extends PHPUnit_Framework_TestCase {
	public function testSocketCons() {
		new Socket();
	}
	
	/**
     * @depends testSocketCons
     */	
    public function testZeroSocket() {
        $socket = new Socket();
		$socket->bind();
		$this->assertEquals($socket->getLocalAddress(),"0.0.0.0");
        $this->assertEquals(is_int($socket->getLocalPort()),true);
        $socket->close();
    }
	
	/**
     * @depends testSocketCons
     */
    public function testSocketPort() {
        $socket = new Socket(InetAddress::getByName("0.0.0.0"),17593);
        $this->assertEquals($socket->getLocalAddress(),"0.0.0.0");
        $this->assertEquals(is_int($socket->getLocalPort()),true);
        $socket->close();
    }
	
    /**
     * Can't bind two same ports
     * @expectedException Exception
	 * @depends testSocketCons
	 */    
    public function testDublicateSocketPort() {
        $socket1 = new Socket(InetAddress::getByName("0.0.0.0"),17593);
        $socket2 = new Socket(InetAddress::getByName("0.0.0.0"),17593);
        $socket1->close();
        $socket2->close();
    }
}
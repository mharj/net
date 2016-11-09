<?php

use mharj\net\Socket;
use mharj\net\InetAddress;

class SocketTest extends PHPUnit_Framework_TestCase {
    public function testZeroSocket() {
        $socket = new Socket();
        $this->assertEquals($socket->getLocalAddress(),"0.0.0.0");
        $this->assertEquals(is_int($socket->getLocalPort()),true);
        $socket->close();
    }
    public function testSocketPort() {
        $socket = new Socket(InetAddress::getByName("0.0.0.0"),17593);
        $this->assertEquals($socket->getLocalAddress(),"0.0.0.0");
        $this->assertEquals(is_int($socket->getLocalPort()),true);
        $socket->close();
    }
    
    /**
     * Can't bind two same ports
     * @expectedException Exception
     */    
    public function testDublicateSocketPort() {
        $socket1 = new Socket(InetAddress::getByName("0.0.0.0"),17593);
        $socket2 = new Socket(InetAddress::getByName("0.0.0.0"),17593);
        $socket1->close();
        $socket2->close();
    }
}


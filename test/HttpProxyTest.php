<?php

use mharj\net\HttpProxy;
use mharj\net\InetAddress;
use mharj\net\URL;
class HttpProxyTest extends PHPUnit_Framework_TestCase {
	
	public function testCons() {
		new HttpProxy("localhost");
		new HttpProxy(null);
                new HttpProxy(InetAddress::getByName("localhost"));
	}
	
	public function testConsExcep() {
		$proxy = new HttpProxy("localhost",8080,array("localhost"));
		$this->assertEquals($proxy->isUsingProxy(URL::create("http://localhost/asd")),false);
		$this->assertEquals($proxy->isUsingProxy(URL::create("http://www.google.com/")),true);
                $this->assertEquals(is_string($proxy->getHostname()),true);
                $this->assertEquals($proxy->getPort(),8080);
	}
	
}

<?php

use mharj\net\HttpProxy;
use mharj\net\InetAddress;
use mharj\net\URL;
class HttpProxyTest extends PHPUnit_Framework_TestCase {
	
	public function testCons() {
		new HttpProxy("localhost");
		new HttpProxy(null);
	}
	
	public function testConsExcep() {
		$proxy = new HttpProxy("localhost",8080,array("localhost"));
		$this->assertEquals($proxy->isUsingProxy(URL::create("http://localhost/asd")),false);
		$this->assertEquals($proxy->isUsingProxy(URL::create("http://www.google.com/")),true);
	}
	
}

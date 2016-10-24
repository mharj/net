<?php
use mharj\net\InetSocketAddress;
use mharj\net\InetAddress;

class InetSocketAddressTest extends PHPUnit_Framework_TestCase {
	public function testCons() {
		$test = new InetSocketAddress(null,123);
		$this->assertEquals($test->getPort(),123);
		$this->assertEquals($test->getHost(),null);
		
		$test = new InetSocketAddress("localhost",123);
		$this->assertEquals($test->getPort(),123);
		$this->assertEquals($test->getHost()->toString(),"127.0.0.1");
		
		$test = new InetSocketAddress(InetAddress::getByName("127.0.0.1"),123);
		$this->assertEquals($test->getPort(),123);
		$this->assertEquals($test->getHost()->toString(),"127.0.0.1");
	}
	
	/**
	 * @expectedException TypeError
	 */
	public function testBrokenConst() {
		new InetSocketAddress(new stdClass());
	}
}

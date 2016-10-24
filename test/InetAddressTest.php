<?php
use mharj\net\InetAddress;

class InetAddressTest extends PHPUnit_Framework_TestCase {
	/**
	 * Cons is private
	 * @expectedException Error
	 */
	public function testCons() {
		new InetAddress();
	}
	
	public function testLocalhost() {
		$local = InetAddress::getByName("localhost");
		$this->assertEquals($local,"127.0.0.1");
		$local = InetAddress::getByName("192.168.1.2");
		$this->assertEquals($local,"192.168.1.2");
		$local = InetAddress::getByAddress(ip2long("127.0.0.1"));
		$this->assertEquals($local,"127.0.0.1");
		$local = InetAddress::getByName("www.google.com");
		$this->assertInstanceOf(InetAddress::class,$local);
		$data = InetAddress::getAllByName("www.google.com");
		$this->assertEquals(empty($data),false);
	}
	
	/**
	 * @expectedException TypeError
	 */
	public function testFooBar() {
		InetAddress::getByName("hello.foo.bar");
	}
	
	/**
	 * @expectedException TypeError
	 */	
	public function testFooBarArray() {
		InetAddress::getAllByName("hello.foo.bar");
	}
}

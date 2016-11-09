<?php
use mharj\net\InetAddress;
use mharj\net\Inet4Address;
use mharj\net\Inet6Address;

class InetAddressTest extends PHPUnit_Framework_TestCase {
	/**
	 * Cons is private
	 * @expectedException Error
	 */
	public function testCons() {
		new InetAddress();
	}
	
	public function testLocalHostSolve() {
	    $local = InetAddress::getByName("localhost");
	    $this->assertEquals($local,"127.0.0.1");
	}
	
	public function testPrivNetworkIp() {
	    $local = InetAddress::getByName("192.168.1.2");
	    $this->assertEquals($local,"192.168.1.2");
	}
	
	public function testIpv4Ip() {
	    $local = InetAddress::getByAddress("127.0.0.1");
	    $this->assertEquals($local,"127.0.0.1");
		$this->assertEquals($local->isLoopbackAddress(),true);
	    $this->assertInstanceOf(Inet4Address::class,$local);
	}

	public function testIpv6Ip() {
	    $local = InetAddress::getByAddress("::1");
		$this->assertEquals($local->isLoopbackAddress(),true);
	    $this->assertEquals($local,"::1");
	    $this->assertInstanceOf(Inet6Address::class,$local);
	}

	public function testAnyAddress() {
	    $local = InetAddress::getByName("0.0.0.0");
		$this->assertEquals($local->isAnyLocalAddress(),true);
	    $this->assertEquals($local,"0.0.0.0");
	}
	
	public function testDnsSolving() {
	    $local = InetAddress::getByName("www.google.com");
	    $this->assertInstanceOf(InetAddress::class,$local);
	}

	public function testDnsArraySolving() {
	    $data = InetAddress::getAllByName("www.google.com");
	    $this->assertEquals(empty($data),false);
	}
	
	public function testLocalHost() {
		$local = InetAddress::getLocalHost();
		$this->assertInstanceOf(InetAddress::class,$local);
	}
	
	public function testLoopbackAddress() {
		$local = InetAddress::getLoopbackAddress();
		$this->assertEquals($local,"127.0.0.1");
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
	
	/**
	 * Should give error on inet_pton
	 * @expectedException TypeError
	 */
	public function testBrokenIp() {
		InetAddress::getByAddress("");
	}
}

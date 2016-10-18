<?php
use mharj\net\URL;

class URLTest extends PHPUnit_Framework_TestCase {
	public function testPlainConst() {
		$uri = new URL();
	}
	
	public function testParse() {
		$uri = URL::create("https://github.com/mharj/openid/tree/master/src?asd=param#fragments");
		$this->assertEquals($uri->getScheme(),"https");
		$this->assertEquals($uri->getAuthority(),"github.com");
		$this->assertEquals($uri->getPath(),"/mharj/openid/tree/master/src");
		$this->assertEquals($uri->getQuery(),"asd=param");
		$this->assertEquals($uri->getFragment(),"fragments");
		$this->assertEquals($uri->toString(),"https://github.com/mharj/openid/tree/master/src?asd=param#fragments");
	}	

	public function testParseWithAccount() {
		$uri = URL::create("https://qwe:asd@github.com/mharj/openid/tree/master/src?asd=param#fragments");
		$this->assertEquals($uri->getScheme(),"https");
		$this->assertEquals($uri->getAuthority(),"github.com");
		$this->assertEquals($uri->getUserInfo(),"qwe:asd");
		$this->assertEquals($uri->getPath(),"/mharj/openid/tree/master/src");
		$this->assertEquals($uri->getQuery(),"asd=param");
		$this->assertEquals($uri->getFragment(),"fragments");	
		$this->assertEquals($uri->toString(),"https://qwe:asd@github.com/mharj/openid/tree/master/src?asd=param#fragments");
	}
	
	public function testParseLocalhostWithPort() { 
		$uri = URL::create("http://localhost:8000"); 
		$this->assertEquals($uri->getScheme(),"http");
		$this->assertEquals($uri->getAuthority(),"localhost");
		$this->assertEquals($uri->getPort(),8000);
	}
}

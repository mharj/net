<?php
use mharj\net\CurlHttpClient;
use mharj\net\HttpRequest;
use mharj\net\HttpResponse;
use mharj\net\HttpProxy;
use mharj\net\URL;

class CurlHttpClientTest extends PHPUnit_Framework_TestCase {
	private $curl;
	
	public function __construct() {
		$this->curl = new CurlHttpClient();
		$this->curl->setProxySocket(new HttpProxy(null));
	}
	
	public function testLocalhostWorking() {
		$req = new HttpRequest(URL::create("http://localhost:8000/"));
		$this->curl->sendRequest($req);
	}

	/**
	 * @depends testLocalhostWorking
	 */
	public function testGet() {
		$req = new HttpRequest(URL::create("http://localhost:8000/"));
		
		$resp = $this->curl->sendRequest($req);
		$this->assertEquals($resp->getUploadSize(),0);
		$this->assertEquals($resp->getMethod(),"GET");
		$this->assertEquals($resp->getStatusCode(), HttpResponse::HTTP_OK);
		$obj = json_decode($resp->getData(),false);
		$this->assertNotNull($obj);
	}
	
	/**
	 * @depends testLocalhostWorking
	 */	
	public function testPost() {
		$data = json_encode(array('title'=>'foo','body'=>'bar','userId'=>1));
		$req = new HttpRequest(URL::create("http://localhost:8000/"),"POST",$data);
		
		$resp = $this->curl->sendRequest($req);
		$this->assertEquals($resp->getUploadSize(),strlen($data));
		$this->assertEquals($resp->getMethod(),"POST");
		$this->assertEquals($resp->getStatusCode(), HttpResponse::HTTP_CREATED);
		$obj = json_decode($resp->getData(),false);
		$this->assertNotNull($obj);
	}
	
	/**
	 * @depends testLocalhostWorking
	 */	
	public function testPut() {
		$data = json_encode(array('id'=>1,'title'=>'foo','body'=>'bar','userId'=>1));
		$req = new HttpRequest(URL::create("http://localhost:8000/"),"PUT",$data);
		
		$resp = $this->curl->sendRequest($req);
		$this->assertEquals($resp->getUploadSize(),strlen($data));
		$this->assertEquals($resp->getMethod(),"PUT");
		$this->assertEquals($resp->getStatusCode(), HttpResponse::HTTP_ACCEPTED);
		$obj = json_decode($resp->getData(),false);
		$this->assertNotNull($obj);
	}	

	/**
	 * @depends testLocalhostWorking
	 */
	public function testPatch() {
		$data = json_encode(array('title'=>'foo'));
		$req = new HttpRequest(URL::create("http://localhost:8000/"),"PATCH",$data);
		
		$resp = $this->curl->sendRequest($req);
		$this->assertEquals($resp->getUploadSize(),strlen($data));
		$this->assertEquals($resp->getMethod(),"PATCH");
		$this->assertEquals($resp->getStatusCode(), HttpResponse::HTTP_OK);
		$obj = json_decode($resp->getData(),false);
		$this->assertNotNull($obj);
	}
	
	/**
	 * @depends testLocalhostWorking
	 */
	public function testDelete() {
		$req = new HttpRequest(URL::create("http://localhost:8000/"),"DELETE");
		
		$resp = $this->curl->sendRequest($req);
		$this->assertEquals($resp->getUploadSize(),0);
		$this->assertEquals($resp->getMethod(),"DELETE");
		$this->assertEquals($resp->getStatusCode(), HttpResponse::HTTP_OK);
		$obj = json_decode($resp->getData(),false);
		$this->assertNotNull($obj);
	}	

	
	/**
     * @depends testLocalhostWorking
     */
	public function testLocalServerResponseCodes() {
		$responses = array(
			HttpResponse::HTTP_OK,
			HttpResponse::HTTP_CREATED,
			HttpResponse::HTTP_BAD_REQUEST,
			HttpResponse::HTTP_UNAUTHORIZED,
			HttpResponse::HTTP_NOT_FOUND,
		);
		foreach ( $responses AS $response ) {
			$req = new HttpRequest(URL::create("http://localhost:8000/?response=".$response));
			$resp = $this->curl->sendRequest($req);
			$this->assertEquals($resp->getStatusCode(),$response);
		}
	}
}

<?php
namespace mharj\net;

class InetSocketAddress {
	private $port;
	private $host;
	

	public function __construct($host = null,int $port) {
		if ( ! is_null($host) && ! is_string($host) && !$host instanceof InetAddress ) {
			throw new \TypeError("not instance of string or InetAddress");
		}
		if ( is_string($host) ) {
			$host = InetAddress::getByName($host);
		}
 		$this->host = $host;
		$this->port = $port;
	}
	
	public function getHost() {
		return $this->host;
	}
	
	public function getPort(): int {
		return $this->port;
	}
	
	public function toString() {
		return $this->host->toString().":".$this->port;
	}
}

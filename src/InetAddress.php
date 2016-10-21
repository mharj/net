<?php
namespace mharj\net;

class InetAddress {
	private $addr;
	
	public function __construct(string $addr = null) {
		$this->addr = $addr;
	}
	
	public function toString() {
		return $this->addr;
	}
}

<?php
namespace mharj\net;

class Inet4Address extends InetAddress {
    const INADDRSZ = 4;
	
	public function __construct(string $hostName=null,$addr=null) {
		parent::__construct();
		$this->hostName = $hostName;
		if ( is_string($addr) && strlen($addr) ==  Inet4Address::INADDRSZ ) {
			$this->addr = $addr;
		}
		if ( is_int($addr) ) {
			$this->addr = inet_pton(long2ip($addr));
		}
	}
	
	public function isAnyLocalAddress(): bool {
        return (bin2hex($this->addr)=="00000000");
    }
	
	public function isLoopbackAddress(): bool {
		$byteAddr = unpack('C*', $this->addr[0]);
        return $byteAddr[1] == 127;
    } 	
}

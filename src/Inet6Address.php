<?php
namespace mharj\net;

class Inet6Address extends InetAddress {
	const INADDRSZ = 16;
	
	public function __construct(string $hostName=null,string $addr=null) {
		parent::__construct();
		$this->hostName = $hostName;
		if ( is_string($addr) && strlen($addr) ==  Inet6Address::INADDRSZ ) {
			$this->addr = $addr;
		}
	}	
	
	public function isAnyLocalAddress(): bool {
		return (bin2hex($this->addr)=="00000000000000000000000000000000");
	}
	
	public function isLoopbackAddress(): bool {
        return (bin2hex($this->addr)=="00000000000000000000000000000001");
    }
	
	public function isLinkLocalAddress(): bool {
		$byteAddr = unpack('C*', $this->addr);
        return ($byteAddr[1] == 0xfe && $byteAddr[2] == 0x80); // "fe80"
	}
	
	public function isSiteLocalAddress(): bool {
		$byteAddr = unpack('C*', $this->addr);
        return ($byteAddr[1] == 0xfe && $byteAddr[2] == 0xc0); // "fec0"
	}
	
	protected static function getAnyLocalAddress(): Inet6Address {
		return new Inet6Address("::",hex2bin("00000000000000000000000000000000"));
	}
	
}

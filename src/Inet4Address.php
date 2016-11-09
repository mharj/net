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
			$this->addr = InetAddress::getIpToBytes(long2ip($addr));
		}
	}
	
	public function isAnyLocalAddress(): bool {
        return (bin2hex($this->addr)=="00000000");
    }
	
	public function isLoopbackAddress(): bool {
		$byteAddr = unpack('C*', $this->addr[0]);
        return $byteAddr[1] == 127;
    }
	
	public function isLinkLocalAddress(): bool {
		$byteAddr = unpack('C*', $this->addr);
        return ($byteAddr[1] == 169 && $byteAddr[2] == 254);
	}
	
	public function isSiteLocalAddress(): bool {
        // refer to RFC 1918
        // 10/8 prefix
        // 172.16/12 prefix
        // 192.168/16 prefix
		$byteAddr = unpack('C*', $this->addr);
        return ( $byteAddr[1] == 10 ||
				($byteAddr[1] == 172 && $byteAddr[2] == 16) ||
				($byteAddr[1] == 192 && $byteAddr[2] == 168) );
    }	
	protected static function getAnyLocalAddress(): Inet4Address {
		return new Inet4Address("0.0.0.0",hex2bin("00000000"));
	}
}

<?php
namespace mharj\net;

class InetAddress {
	protected $addr;
	
	protected function __construct(string $addr = null) {
/*		
		if ( $addr != null ) {
			try {
				$host = inet_pton($addr);
				$this->addr = $host;
			} catch( \Exception $ex) {
				throw new \TypeError($ex->getMessage());
			} 
		}*/
	}
	
	public function equals($addr) {
		return $this->addr == $addr;
	}
	
	public function getHostName():string {
		return gethostbyaddr($this->getHostAddress()); 
	}
	
	public function getHostAddress():string {
		return inet_ntop($this->addr);
	}
	
	public static function getByAddress(string $host=null,$addr = null): InetAddress {
		if ($addr != null) {
			if (strlen($addr) == Inet4Address::INADDRSZ) {
				return new Inet4Address($host, $addr);
			} else if (strlen($addr) == Inet6Address::INADDRSZ ) {
				return new Inet6Address($host, $addr);
			}
		}
		throw new \TypeError("addr is of illegal length");
	}
	
	
	public function __toString() {
		return $this->getHostAddress();
	}
	
	public static function getLocalHost() {
		return InetAddress::getByName(gethostname());
	}
	
	public static function getLoopbackAddress() {
		return new InetAddress("127.0.0.1");
	}
	
	public static function getAllByName(string $hostname) {
		$data = array();
		if ( function_exists("dns_get_record") && $hostname != "localhost" ) {
			foreach ( dns_get_record($hostname,DNS_ALL) AS $e) {
				if ( isset($e['ip'])  ) {
					$data[]=new InetAddress($e['ip']);
				}
				if ( isset($e['ipv6'])  ) {
					$data[]=new InetAddress($e['ipv6']);
				}
			}
		} else {
			$dns = gethostbynamel($hostname);
			if ( $dns !== false ) {
				foreach ( gethostbynamel($hostname) AS $ip ) {
					$data[]=new InetAddress($ip);
				}
			}
		}
		if ( empty($data) ) {
			throw new \TypeError("Can't solve address");
		}
		return $data;
	}
	
	public static function getByName(string $hostname) {
		$data = null;
		if ( function_exists("dns_get_record") && $hostname != "localhost" ) {
			$data = self::lookUpFromDNS($hostname);
		}
		if ( $data == null ) {
			$data = new Inet4Address( gethostbyname($hostname) );
		}
		if ( $data == null || $data === false ) {
			throw new \TypeError("Can't solve address");
		}
		return $data;
	}
	
	public function isLoopbackAddress(): bool {
        return false;
    }
	
	public function isAnyLocalAddress(): bool {
		return false;
	}
/*	
	public static function getByAddress(string $ip): InetAddress {
		$addr = "";
		try {
			$addr = inet_pton($ip);
		} catch( \Exception $ex) {
			throw new \TypeError($ex->getMessage());
		}
	    if ( strlen($addr) == Inet4Address::INADDRSZ ) {
			return new Inet4Address($ip);
	    }
		if ( strlen($addr) == Inet6Address::INADDRSZ ) {
			return new Inet6Address($ip);
		}
	}
*/	
	private static function lookUpFromDNS($addr) {
		$data = dns_get_record($addr,DNS_ALL);
		if ( $data === false ) {
			throw new \TypeError("Can't solve address");
		}
		if ( empty($data) ) {
			return null;
		}
		foreach ( $data AS $e ) {
			if ( isset($e['ip']) ) {
				return new Inet4Address($e['ip']);
			}
			if ( isset($e['ipv6']) ) {
				return new Inet6Address($e['ipv6']);
			}
		}
		return null;
	}
}

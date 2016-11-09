<?php
namespace mharj\net;

class InetAddress {
	protected $addr;
	protected $hostName;
	
	protected function __construct() {
	}
	
	public function equals($addr) {
		return $this->addr == $addr;
	}
	
	public function getHostName():string {
		return $this->hostName;
	}
	
	public function getAddress(): string {
		return $this->addr;
	}
	
	public function getHostAddress():string {
		return InetAddress::getBytesToIp($this->addr);
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
	
	public static function getLocalHost():InetAddress {
		return InetAddress::getByName(gethostname());
	}
	
	public static function getLoopbackAddress():InetAddress {
		return self::getByAddress("localhost",InetAddress::getIpToBytes("127.0.0.1"));
	}
	
	public static function getAllByName(string $hostname) {
		$data = array();
		if ( function_exists("dns_get_record") && $hostname != "localhost" ) {
			foreach ( dns_get_record($hostname,DNS_ALL) AS $e) {
				if ( isset($e['ip'])  ) {
					$data[] = new Inet4Address($hostname,InetAddress::getIpToBytes($e['ip']));
				}
				if ( isset($e['ipv6'])  ) {
					$data[] = new Inet6Address($hostname,InetAddress::getIpToBytes($e['ipv6']));
				}
			}
		} else {
			$dns = gethostbynamel($hostname); // gets ipv4 only
			if ( $dns !== false ) {
				foreach ( $dns AS $ip ) {
					$data[]=new Inet4Address($hostname,InetAddress::getIpToBytes($ip));
				}
			}
		}
		if ( empty($data) ) {
			throw new \TypeError("Can't solve address");
		}
		return $data;
	}
	
	public static function getByName(string $hostname) {
		// give ANY address without dns lookup
		if ( $hostname == "0.0.0.0" ) {
			return Inet4Address::getAnyLocalAddress();
		}
		if ( $hostname == "::" ) {
			return Inet6Address::getAnyLocalAddress();
		}
		// dns lookup
		$data = null;
		if ( function_exists("dns_get_record") && $hostname != "localhost" ) {
			$data = self::lookUpFromDNS($hostname);
		}
		if ( $data == null ) {
			try {
				$data = new Inet4Address($hostname, InetAddress::getIpToBytes(gethostbyname($hostname)) );
			} catch( \Exception $ex) {
				throw new \TypeError("Can't solve address");
			}
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

	public function isSiteLocalAddress(): bool {
		return false;
	}
	private static function lookUpFromDNS($addr) {
		try {
			$data = dns_get_record($addr,DNS_ALL);
			if ( $data === false ) {
					throw new \TypeError("Can't solve address");
			}
		} catch( \Exception $ex) {
			throw new \TypeError("Can't solve address");
		}
		if ( empty($data) ) {
			return null;
		}
		foreach ( $data AS $e ) {
			if ( isset($e['ip']) ) {
				return new Inet4Address($addr,InetAddress::getIpToBytes($e['ip']));
			}
			if ( isset($e['ipv6']) ) {
				return new Inet6Address($addr,InetAddress::getIpToBytes($e['ipv6']));
			}
		}
		return null;
	}
	
	protected static function getIpToBytes($ip): string {
		return inet_pton($ip);
	}
	protected static function getBytesToIp($in_addr): string {
		return inet_ntop($in_addr);
	}
}

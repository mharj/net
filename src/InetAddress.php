<?php
namespace mharj\net;

class InetAddress {
	private $addr;
	
	private function __construct(string $addr = null) {
		if ( $addr != null ) {
			try {
				$host = inet_pton($addr);
				$this->addr = $host;
			} catch( \Exception $ex) {
				throw new \TypeError($ex->getMessage());
			} 
		}
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
			$data = gethostbyname($hostname);
		}
		if ( $data == null || $data === false ) {
			throw new \TypeError("Can't solve address");
		}
		return new InetAddress($data); 
	}
	
	public static function getByAddress(int $ip) {
		return new InetAddress( long2ip($ip) );
	}
	
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
				return $e['ip'];
			}
			if ( isset($e['ipv6']) ) {
				return $e['ipv6'];
			}
		}
		return null;
	}
}

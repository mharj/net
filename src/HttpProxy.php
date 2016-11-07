<?php
namespace mharj\net;

class HttpProxy {
	private $host = null;
	private $port;
	private $username = null;
	private $password = null;
	private $exceptions = array();
	
	public function __construct($host = null,int $port=8080,array $exceptions=array()) {
            if ( ! is_null($host) ) {
                if ( is_string($host) ) {
                    $this->host = InetAddress::getByName($host);
                }
                if ( $host instanceof InetAddress ) {
                    $this->host = $host;
                }
                if ( is_null($this->host) ) {
                    throw new \TypeError("not instance of string or InetAddress");
                }
            } 
            $this->port = $port;
            $this->setExceptions($exceptions);
	}
	
        public function isNull(): bool {
            return is_null($this->host);
        }
        
	public function getHostname(): string {
		return $this->host->getHostName();
	}
	
	public function getPort(): int {
		return $this->port;
	}
	
	public function setUsername($username) {
		$this->username = $username;
	}
	
	public function getUsername(): string {
		return $this->username;
	}
	
	public function setPassword($password) {
		$this->password = $password;
	} 
	
	public function getPassword(): string {
		return $this->password;
	}
	
	public function setExceptions(array $exceptions) {
		foreach ( $exceptions AS $exception) {
			if ( is_string($exception) ) {
				$this->exceptions[] = $exception;
			}
		}
	}
	
	public function isUsingProxy(URL $url): bool {
		foreach ($this->exceptions as $exception) {
			if ( $exception == $url->getAuthority() ) {
				return false;	
			}
		}
		return true;
	} 
}

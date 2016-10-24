<?php
namespace mharj\net;

class HttpProxy {
	private $host;
	private $port;
	private $username;
	private $password;
	private $exceptions = array();
	
	public function __construct(string $host = null,int $port=8080,array $exceptions=array()) {
		$this->host = $host;
		$this->port = $port;
		$this->setExceptions($exceptions);
	}
	
	public function getHostname() {
		return $this->host;
	}
	
	public function getPort() {
		return $this->port;
	}
	
	public function setUsername($username) {
		$this->username = $username;
	}
	
	public function getUsername() {
		return $this->username;
	}
	
	public function setPassword($password) {
		$this->password = $password;
	} 
	
	public function getPassword() {
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

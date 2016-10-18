<?php
namespace mharj\net;

class URL {
	private $scheme;
	private $authority;
	private $path;
	private $query;
	private $fragment;
	private $userInfo;
	private $port=null;
	
	function __construct($scheme = null,$authority = null,$path = null,$query = null,$fragment = null) {
		$this->scheme = $scheme;
		$this->authority = $authority;
		$this->path = $path;
		$this->query = $query;
		$this->fragment = $fragment;
	}
	
	function getScheme() {
		return $this->scheme;
	}
	
	function getAuthority() {
		return $this->authority;
	}
	
	function getPath() {
		return $this->path;
	}
	
	function getQuery() {
		return $this->query;
	}
	
	function getFragment() {
		return $this->fragment;
	}
	
	function getUserInfo() {
		return $this->userInfo;
	}
	
	function getPort() {
		return $this->port;
	}
	
	function toString() {
		return ($this->scheme!=null?$this->scheme.'://':'').($this->userInfo!=null?$this->userInfo.'@':'').($this->authority!=null?$this->authority:'').($this->port!=null?":".$this->port:"").($this->path!=null?$this->path:'').($this->query!=null?'?'.$this->query:'').($this->fragment!=null?'#'.$this->fragment:'');
	}
	
	public static function create(string $uri) {
		$ins = new URL();
		$ins->parse($uri);
		return $ins;
	}
	
	private function parse(string $url) {
		$data = parse_url($url);
		if ( isset($data['scheme']) ) {
			$this->scheme = $data['scheme'];
		}
		if ( isset($data['host']) ) {
			$this->authority = $data['host'];
		}
		if ( isset($data['port']) ) {
			$this->port = $data['port'];
		}		
		if ( isset($data['user']) ) {
			$this->userInfo = $data['user'].':'.$data['pass'];
		}
		if ( isset($data['path']) ) {
			$this->path = $data['path'];
		}
		if ( isset($data['query']) ) {
			$this->query = $data['query'];
		}
		if ( isset($data['fragment']) ) {
			$this->fragment = $data['fragment'];
		}
	}
}

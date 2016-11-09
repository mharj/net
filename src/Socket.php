<?php
namespace mharj\net;

use mharj\net\InetAddress;

class Socket {
    private $socket = null;
    
    public function __construct(InetAddress $addr = null,int $port = 0) {
        if ( ! function_exists("socket_create") ) {
            throw new \Exception("socket support not enabled");
        }
        $this->socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
		if ( $addr != null ) {
			$this->bind(new InetSocketAddress($addr,$port));
		}
    }
    
	public function bind(InetSocketAddress $bindpoint = null) {
		set_error_handler (function() { // get socket bind errors as Exception
			throw new \Exception( socket_strerror( socket_last_error($this->socket) ) );
		});
		if ( $bindpoint == null ) {
			socket_bind($this->socket,"0.0.0.0");
		} else {
			socket_bind($this->socket,$bindpoint->getHost()->getHostAddress(),$bindpoint->getPort());
		}
		restore_error_handler();	
	}
	
	public function connect(InetSocketAddress $target) {
		echo "host: ".$target->getHost()->getHostAddress()."\n";
		if ( socket_connect($this->socket,$target->getHost()->getHostAddress(),$target->getPort())) {
			
		} else {
			
		}
	}
	
    public function getLocalPort():int  {
        $name = "";
        $port = 0;
        if ( socket_getsockname($this->socket,$name,$port) ) {
            return $port;
        }
        throw new \Exception( socket_strerror( socket_last_error($this->socket) ) );
    }
    
    public function getLocalAddress():InetAddress {
        $name = "";
        if ( socket_getsockname($this->socket,$name) ) {
            return InetAddress::getByName($name);
        } 
        throw new \Exception( socket_strerror( socket_last_error($this->socket) ) );
    }
	
	public function getLocalSocketAddress():InetSocketAddress {
		return new InetSocketAddress($this->getLocalAddress(),$this->getLocalPort());
	}
    
    public function close() {
        if ( ! is_null($this->socket) ) {
            socket_close($this->socket);
        }
    }
}

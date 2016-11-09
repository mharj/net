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
	set_error_handler (function() { // get socket bind errors as Exception
	    throw new \Exception( socket_strerror( socket_last_error($this->socket) ) );
	});
	socket_bind($this->socket,(is_null($addr)?"0.0.0.0":$addr->getHostAddress()),$port);
	restore_error_handler();
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
    
    public function close() {
        if ( ! is_null($this->socket) ) {
            socket_close($this->socket);
        }
    }
}

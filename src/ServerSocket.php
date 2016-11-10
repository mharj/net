<?php
namespace mharj\net;

class ServerSocket {
	private $closed = false;
	private $bound = false;
	private $socket;
	public function __construct(int $port,InetAddress $bindAddr=null) {
		$this->socket = new Socket();
		if ($port < 0 || $port > 0xFFFF) {
            throw new \InvalidArgumentException("Port value out of range: ".$port);
		}
		try {
			$this->bind(new InetSocketAddress($bindAddr,$port));
		} catch (Exception $ex) {

		}
	}
	
	public function bind(InetSocketAddress $endpoint=null, int $backlog=0) {
		if ($this->isClosed()){
            throw new SocketException("Socket is closed");
		}
		if ($this->isBound()) {
			throw new SocketException("Already bound");
		}
		if ($endpoint == null) {
            $endpoint = new InetSocketAddress(0);
		}
		if ($endpoint.isUnresolved()) {
            throw new SocketException("Unresolved address");
		}
		try {
			$this->socket->bind($endpoint);
			// FIX: create socket listen 
			$bound = true;
		} catch (Exception $ex) {
			$bound = false;
			throw $ex;
		}
	}
	
	public function isClosed(): bool {
		return $this->closed;
    }
	
	public function isBound(): bool {
		return $this->bound;
	}
}

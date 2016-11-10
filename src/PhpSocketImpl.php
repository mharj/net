<?php
namespace mharj\net;

class PhpSocketImpl extends SocketImpl {
	protected function __construct() {
		$this->fd = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
	}
	protected function accept(SocketImpl $s) {
		
	}

	protected function available(): int {
		
	}

	protected function bind(InetAddress $host, int $port) {
		
	}

	protected function close() {
		
	}

	protected function connect($host, $port) {
		
	}

	protected function create(bool $stream) {
		
	}

	protected function getInputStream(): InputStream {
		
	}

	protected function getOutputStream(): OutputStream {
		
	}

	protected function listen(int $backlog) {
		
	}

	protected function sendUrgentData(int $data) {
		
	}

}

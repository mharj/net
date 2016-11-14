<?php
namespace mharj\net;

class SocketInputStream extends InputStream {

	public function close() {
		// ignore
	}
	
	public function read(&$b,int $off=null,int $len=null):int  {
		$data = socket_read($this->fd,($off+$len));
		if ( $data === false) {
			throw new IOException("Unable to read from socket");
		}
		$b .= $data;
		return strlen($data);
	}
	
	public function readByte(): string {
		return socket_read($this->fd,1);
	}

}

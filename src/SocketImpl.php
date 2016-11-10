<?php
namespace mharj\net;

abstract class SocketImpl {
    private $socket = null;
	private $serverSocket = null;
    protected $fd;
    protected $address;
    protected $port;
    protected $localport;
	
	protected abstract function create(bool $stream);
	protected abstract function connect($host,$port);
	protected abstract function bind(InetAddress $host, int $port);
	protected abstract function listen(int $backlog);
	protected abstract function accept(SocketImpl $s);
	protected abstract function getInputStream():InputStream;
	protected abstract function getOutputStream():OutputStream;
	protected abstract function available(): int;
	protected abstract function close();
	
	protected function getFileDescriptor():FileDescriptor {
        return $this->fd;
    }
	
	protected function getInetAddress():InetAddress {
        return $this->address;
    }
	
	protected function getPort():int {
        return $this->port;
    }
	
	protected function supportsUrgentData(): bool {
        return false; // must be overridden in sub-class
    }
	
	protected abstract function sendUrgentData(int $data);
	
	
	protected function getLocalPort():int {
        return $this->localport;
    }

    function setSocket(Socket $soc) {
        $this->socket = soc;
    }

    function getSocket():Socket {
        return $this->socket;
    }

    function setServerSocket(ServerSocket $soc) {
        $this->serverSocket = soc;
    }

    function getServerSocket():ServerSocket {
        return $this->serverSocket;
    }

    public function __toString() {
        return "Socket[addr=" + $this->getInetAddress() +",port=" + $this->getPort() + ",localport=" + $this->getLocalPort()  + "]";
    }

    function reset() {
        $this->address = null;
        $this->port = 0;
        $this->localport = 0;
    }
	
	protected function setPerformancePreferences(int $connectionTime,int $latency,int $bandwidth) {}	
	
}

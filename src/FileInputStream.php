<?php
namespace mharj\net;

class FileInputStream extends InputStream {
	private $fd = null;
	private $filename = null;
	private $filesize = null;
	
	public function __construct($name) {
		try {
			$this->fd = fopen($name,"r"); 
			$this->filename = $name;
			$this->filesize = filesize($name);
		} catch(\Exception $ex) {
			throw new IOException($ex->getMessage());
		}
	}
	
	public function read(&$b,int $off=null,int $len=null):int  {
		$this->isOpen();
		if ( $off != null ) {
			fseek($this->fd,$off,SEEK_CUR);
		}
		$data = fread($this->fd ,$len);
		if ( $data === false ) {
			throw new IOException("Unable to read file");
		}
		$b .= $data;
		return strlen($data);
	}

	public function available():int {
		$this->isOpen();
        return ($this->filesize-ftell($this->fd));
    }
	
	public function readByte(): string {
		$this->isOpen();
		return fgetc($this->fd);
	}

	public function close() {
		if ( $this->fd != null ) {
			fclose($this->fd);
			$this->fd = null;
		}
	}
	
	private function isOpen() {
		if ( $this->fd == null ) {
			throw new IOException("Files is not open");
		}
	}
}

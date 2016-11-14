<?php
namespace mharj\net;

abstract class InputStream {
	public abstract function readByte():string;
	
	public function read(&$b,int $off=null,int $len=null):int {
		
	}
	
	public function skip(int $n):int {
		
	}
	
	public function available():int {
        return 0;
    }
	
	public abstract function close();
}

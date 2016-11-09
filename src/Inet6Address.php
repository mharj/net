<?php
namespace mharj\net;

class Inet6Address extends InetAddress {
	const INADDRSZ = 16;
	public function isAnyLocalAddress(): bool {
		return (bin2hex($this->addr)=="00000000000000000000000000000000");
	}
	public function isLoopbackAddress(): bool {
        return (bin2hex($this->addr)=="00000000000000000000000000000001");
    } 
}

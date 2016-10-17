<?php
namespace mharj\net;

class HttpClientFactory {
	private static $instance = null;
	public static function getDefaultInstance() {
		if ( self::$instance == null  ) {
			self::$instance = new CurlHttpClient(); // atm only one
		}
		return self::$instance; 
	}
}

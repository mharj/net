<?php
namespace mharj\net;

class HttpClientFactory {
	public static function getDefaultInstance() {
		return new CurlHttpClient(); // atm only one
	}
}

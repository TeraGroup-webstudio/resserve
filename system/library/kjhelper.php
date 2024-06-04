<?php

class kjhelper {
	public static $key_prefix;
	public static $user_token;
	public static $marketplace_link;

	public function __construct() 
	{
		self::$key_prefix = (floatval(VERSION) < 3) ? "" : "module_";
        self::$user_token = (floatval(VERSION) < 3) ? "token" : "user_token";
        self::$marketplace_link = (floatval(VERSION) < 3) ? 'extension/extension' : 'marketplace/extension';
	}
}
new kjhelper();
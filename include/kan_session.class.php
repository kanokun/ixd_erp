<?php

class kan_session
{	
	public $session_id = null;
	
	// 생성자
	public function __construct( $time, $session_id)
	{
		$this->session_id = $session_id;
		
		// 세션 유지시간 설정.
		session_cache_limiter("nocache, must-revalidate");
		ini_set("session.cookie_lifetime", 0);
		ini_set("session.cache_expire", $time);
		ini_set("session.gc_maxlifetime", $time*60);
		
		session_start();
	}
	
	public function __destruct()
	{
	}
	
	public function add($_name, $_val)
	{
	    $_SESSION[$_name] = $_val;
	}
	
	public function addId($_id)
	{
		$_SESSION[$this->session_id] = $_id;
	}
	
	public function delete($_name)
	{
	    unset($_SESSION[$_name]);
	}
	
	public function deleteId()
	{
	    unset($_SESSION[$this->session_id]);
	}
	
	public function check($_name)
	{	    
	    if(isset($_SESSION[$_name])){
	        return true;
	    }
	    
	    return false;
	}
	
	public function checkId()
	{
		if(isset($_SESSION[$this->session_id])){
			return true;
		}
		
		return false;
	}
	
}


// 60 = 1시간
$kan_session = new kan_session(60, "account_id");

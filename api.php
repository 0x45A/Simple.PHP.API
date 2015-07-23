<?php
	set_time_limit(5);
	ini_set("display_errors", "on");
	error_reporting(E_ALL);
	date_default_timezone_set(@date_default_timezone_get());
	
	new API();
	
	class API 
	{
		public $key 	= null;
		public $json 	= null;
		
		public function __construct()
		{
			$this->json = new stdClass();
			$this->json->status = null;
			$this->json->data = null;
			
			if(!isset($_GET["key"]))
			{
				$this->APIError("No API key provided.");
			}
			
			if(!$this->ValidateKey($_GET["key"]))
			{
				$this->APIError("The API key you provided could not be validated.");
			}
			
			if(!isset($_GET["request"]))
			{
				$this->APIError("No request was sent in the GET parameters.");
			}
			
			if(!$this->HandleRequest($_GET["request"]))
			{
				$this->APIError("Unable to handle your request. Maybe your request is invalid?");
			}
		}
		
		private function ValidateKey($key)
		{
			/* Add some sort of check here later. */
			return true;
		}
		
		public function HandleRequest($request)
		{
			switch(strtolower($request))
			{
				case "ip":
					$this->APISuccess(isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER["REMOTE_ADDR"]);
				break;
				
				default: return false;
			}
		}
		
		public function APISuccess($data, $status = "success")
		{
			$this->json->status = $status;
			$this->json->data = $data;
			exit(json_encode($this->json));
		}
		
		public function APIError($error, $status = "error")
		{
			$this->json->status = $status;
			$this->json->data = $error;
			exit(json_encode($this->json));
		}
	}
?>

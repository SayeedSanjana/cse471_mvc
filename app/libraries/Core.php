<?php 
	
	/*
	 *	App Core Class
	 *	creates URL and Loads core Controller
	 *	URL FORMAT - /Controller/method/params
	*/
	
	
	class Core{
		
		protected $currentController = 'Pages'; 
		/*When no other pages is requested pages Controller will load Pages as a
			default page*/
		protected $currentMethod ='index';
		protected $params = [];
		
		public function __construct()
		{	//echo "<pre>";
			//print_r($this->getURL());
			$url = $this->getURL();
			// look in Controller for first Value
			// ucwords(str) capitalizes the first letter
			if (file_exists('../app/controllers/'.ucwords($url[0]).'.php')) {
				//if exists then set it as current controller

				$this->currentController= ucwords($url[0]);
				unset($url[0]);
			}
			
			//require the controller 
			require_once '../app/controllers/'.$this->currentController.'.php';

			//instantiate it
			$this->currentController = new $this->currentController();

			//check second part of the url
			if (isset($url[1])) {
				//check to see if method exists in controller
				if(method_exists($this->currentController, $url[1])){
					$this->currentMethod=$url[1];
					unset($url[1]);
				}
			}
			// Get Params

			$this->params = $url ? array_values($url):[];

			// call a callback with array params
			call_user_func_array([$this->currentController,$this->currentMethod],$this->params);

		}

		public function getURL()
		{
			if (isset($_GET['url'])) {
			 	$url =rtrim($_GET['url'],'/');
			 	$url = filter_var($url, FILTER_SANITIZE_URL);
			 	$url = explode('/', $url);
			 	return $url;
			 } 
		}
	}
?>
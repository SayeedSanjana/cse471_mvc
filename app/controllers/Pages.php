<?php  

class Pages extends Controller{
	
	public function __construct()
	{
		//echo "Pages Loaded";
	}

	public function index()
	{

		// if (isset($_SESSION['user_id'])) {
		// 	header('Location: '.URLROOT.'/HomePage');
		// 	exit();
		// }
		$data = [
			'title'=>'Welcome',
			'description'=>'Easy Way To Connect With Peers and Faculty'	
		];
		$this->view("index",$data);
	}

	public function about()
	{
		$data = [
			'title' =>'About Us',
			'description'=>'U-HUB Built on PHP MVC_Structure',
			'members'=>[
				'Iktisad Rashid',
				'Sanjana Sayeed',
				'Madiha Athar Khan',
				'Mahir Tazwar',
				'Sabbir Kabbo'
			]
		];
		//echo "{$data['title']}";
		$this->view("about",$data);
	}
}

 ?>
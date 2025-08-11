<?
class Chats extends Controller{

	private $chatModel;

	function __construct()
	{
		$this->chatModel = $this->model('Chat');
	}

	public function index()
	{



		if(isset($_POST['submit'])){
			$message=$_POST['message'];
			$message1=$this->chatModel->insert($message);

		}
		$this->view('users/chat',$data);
 		 	}
		

}
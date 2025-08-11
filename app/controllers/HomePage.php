<?php 

/**
 * 
 */
class HomePage extends Controller
{
	private $homeModel;	
	
	function __construct()
	{
		$this->homeModel = $this->model('Home');
	}

	public function index()
	{
		$routine= $this->homeModel->routine();
		$timeSlot = $this->homeModel->timeSlots();
		
		$this->data=array(
			'routine' =>[],
			'timeSlots'=>[],
			'days'=>[],
			'academicNotice'=>[],
			'universityEvents'=>''
			//'days'=>[]
		);

		

		foreach ($routine as $value) {
			
			$datas=array(
				
				'cid'	=>	$value->Course_Code,
				'sec'	=>	$value->Section,
				'day'	=>	$value->Day,
				'slot'	=>	$value->slot,
				'stime'	=>	$value->Start_Time,
				'etime'	=>	$value->End_Time
				
			);
			array_push($this->data['routine'], $datas);			
		}

		foreach ($timeSlot as $val) {
			$datas= array(

				'slot'	=>	$val->Time_ID,
				'stime'	=>	$val->Start_Time,
				'etime'	=>	$val->End_Time
			);
			array_push($this->data['timeSlots'], $datas);
		}
		// foreach ($data as $key => $value) {
		// 	echo $value['cid'];
		// 	echo "<br>";
		// }
		
		// $data=[
		// 	'uid' => $_SESSION['user_id'],
		// 	'uemail'=>$_SESSION['user_email'],
		// 	'udept' =>$_SESSION['user_dept']
		// ];
		//setting up academic notice
		$this->academicNotice();
		$this->view('users/home',$this->data);
	}

	private function academicNotice()
	{
		$notice=$this->homeModel->academicNotice();
		
		foreach ($notice as $key => $value) {
			$datas=[
				'cid'=>$value->Course_Code,
				'sec'=>$value->Section,
				'post'=>$value->Post
			];
			array_push($this->data['academicNotice'], $datas);
		}
	}
	private function universityEvents()
	{
		# code...
	}


}
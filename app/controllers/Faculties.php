<?php 
/**
 * 
 */
class Faculties extends Controller
{
	private $facModel;
	function __construct()
	{
		$this->facModel = $this->model('Faculty');
	}

	public function index()
	{
		$data = array(

			'allFaculty'=>[]
		);

		$faculty = $this->facModel->getAllFaculty();

		foreach ($faculty as $value) {
			$datas=[
				'name'=>$value->Name,
				'desig'=>$value->Designation,
				'phone'=>$value->Phone_No,
				'email'=>$value->Email_Id,
				'gender'=>$value->Gender,
				'room'=>$value->Room_No


			];

			array_push($data['allFaculty'], $datas);
		}
		$this->view('users/faculties',$data);
	}
}

 ?>
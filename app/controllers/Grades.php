<?php 

/**
 * 
 */
class Grades extends Controller
{
	private $gradeModel;
	function __construct()
	{
		$this->gradeModel = $this->model('Grade');
	}

	public function index()
	{

		/* [Semester] => Summer [Year] => 2017 [Course_Description] => Programming Language-II [Course_Code] => CSE111 [Credit] => 3 [GPA] => 3.0 )*/
		$this->data =array(
		 	'gradeSheet'=>[],
		 	'cgpa'=>'',
		 	'totalCredits'=>'',
		 	'creditsCompleted'=>'',
		 	'data_err'=>'',
		 	'year_err'=>''
		 );
		$checkArray= array();
		$minYear;
		$maxYear;
		$result=$this->gradeModel->getGrades();
		$yearRange =$this->gradeModel->getYearRange();
		$cgpa = $this->gradeModel->getCGPA();
		$totalCredits = $this->gradeModel->getTotalCredits();
		$creditsCompleted = $this->gradeModel->getCreditsCompleted();

		if ($result) {
			foreach ($result as $value) {
				$datas =[
					'sem'		=>	$value->Semester,
					'year'		=>	$value->Year,
					'c_desc'	=>	$value->Course_Description,
					'cid' 		=> 	$value->Course_Code,
					'credits'	=>	$value->Credit,
					'gpa' 		=> 	$value->GPA
				];
				array_push($checkArray, $datas);
			}
			if($yearRange){
				
					$minYear =$yearRange->minYear;// year of enrollment
					$maxYear =$yearRange->maxYear;// year last active
					
			}else{
				$data['year_err']='No Year Found';
			}
			$this->sortGradeSheet($checkArray,[$minYear,$maxYear]);
			$this->data['cgpa']=$cgpa->CGPA;
			$this->data['totalCredits']= $totalCredits->Total_Credits;
			$this->data['creditsCompleted']=$creditsCompleted->Credits_Completed;
		}else{
			$data['data_err']='No data Found';
		}

		//print_r($this->data);
		$this->view('users/grades',$this->data);


	}



private function sortGradeSheet($checkArray=[],$year=[])
{
	$semesterSession = array('Spring','Summer','Fall');
	$min=$year[0]; //year of enrollment
	$max=$year[1]; //year last active

	$semesterSession = array('Spring','Summer','Fall');
	
	for($minYear =$min ; $minYear <= $max ; $minYear++){
			
			for($sem=0;$sem<count($semesterSession); $sem++){	
				$rows =	$this->checkSemester($semesterSession[$sem],$minYear,$checkArray);
				if($rows){
					//print_r($rows);
					//echo "<br>";
					array_push($this->data['gradeSheet'], $rows);
				}
			}
		}


}

	private function checkSemester($semester,$year,$checkArray=[])
	{
		$rows = array();
		foreach ($checkArray as $key => $value) {
			if($value['sem']==$semester &&$value['year']== $year){
				array_push($rows, $value);
				unset($checkArray[$key]);
			}	
		}
		//print_r($rows);
		if(count($rows)>0){
			return $rows;
		}
		else{
			return false;
		}
	}
}
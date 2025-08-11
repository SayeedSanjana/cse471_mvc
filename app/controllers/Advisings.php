<?php 

/**
 * 
 */
class Advisings extends Controller
{

	private $advisingModel;
	function __construct()
	{
		$this->advisingModel = $this->model('Advising');
	}

	public function index()
	{
		$this->data = array(
			'showAll'=> [],
			'courseTaken' =>[],
			'recommendations'=>[],
			'course_err'=>''
		);

		$getAllCourses = $this->advisingModel->getAllCourses();
		//print_r($getAllCourses);

		/*
		[Course_Code] => CSE250 [Section] => 1 [Faculty_Initials] => [Total_Seats] => 40 [Seats_Booked] => 40 [Seats_Remaining] => 0 [Day] => WEDNESDAY [Start_Time] => 09:30:00 [End_Time] => 10:50:00 
		*/
		foreach ($getAllCourses as  $value) {
			$datas = [
				'cid'=> $value->Course_Code,
				'sec'=>	$value->Section,
				'f_ini'=>$value->Faculty_Initials,
				'total_Seats'=>$value->Total_Seats,
				'seats_booked'=>$value->Seats_Booked,
				'seats_remaining'=>$value->Seats_Remaining,
				'day'=>$value->Day,
				'stime'=>$value->Start_Time,
				'etime'=>$value->End_Time,
				'semester'=>$value->Semester,
				'year'=>$value->Year
			];
			array_push($this->data['showAll'], $datas);
		}
		$this->view('users/advising',$this->data);
	}

	public function addCourse($course,$section,$semester,$year){	
		

		$seatsCheck=$this->advisingModel->seatsCheck($course,$section);
		echo "<pre>";
	//	print_r($seatsCheck);
		$courseCompleted=$this->advisingModel->courseCompletion($course);
	//	print_r($courseCompleted);
		$gpa=$this->advisingModel->checkGPAOfCourseCompleted($course);

		//print_r($gpa->GPA);
		$creditLimit=$this->advisingModel->creditLimit();
	//	print_r($creditLimit);
		$CGPA=$this->advisingModel->checkCGPA();
	//	print_r($CGPA);
		$checkPrerequisite=$this->advisingModel->checkPrerequisite($course);

		print_r($checkPrerequisite);

		 $dayTime=$this->advisingModel->dayTime($course,$section); // day time
	//	print_r($dayTime);
		$dtCheck=array(); //day time check array
		$exists=$this->advisingModel->ifExists($course);
		
		foreach ($dayTime as $val) {
			$datas=[
				'dt' 	=>	$val->days ,
				'slt'	=>	$val->slot
			];
			array_push($dtCheck, $datas);
		}


		$time=$this->advisingModel->timeCheck();
	

	//	print_r($time);
	

		$credit_limitation=0;
		$bool=0;

 		if($CGPA->CGPA>=2 && $CGPA->CGPA<3.5){
            $credit_limitation=12;
 	    }

 	    if ($CGPA->CGPA>=3.5 && $CGPA->CGPA<=4.0) {
 			$credit_limitation=15;
 	    }
 	    //echo "<br>{$credit_limitation}";
 	//	echo "<br>";
 	//	print_r($seatsCheck);


		if ($seatsCheck) {
				echo"seats";
				//echo"<br>";
				//print_r($seatsCheck);	
				if($courseCompleted){
					//	echo "<br>";
					//	print_r($courseCompleted);
					//	print_r($gpa);
					if($gpa->GPA < 3.0){
				  //		echo "<br>hellllllllllooooo";
				  //		print_r($gpa);
						if($creditLimit->sumCredit<$credit_limitation){
							if(!$exists){
								echo "<br>hey";
							//check clash time here
							
								if (!$this->advisingModel->time($dtCheck)) { 
									//time check to see if there is no clash
									$this->advisingModel->insertCourse($course,$section,$semester,$year);
									
									// $row = $this->advisingModel->showAdvisedCourses();
									// print_r($row);
									// foreach ($row as $value) {
									// 	$datas =[
									// 		'cid'=>$value->Course_Code,
									// 		'sec'=>$value->Section
									// 	];
									// 	array_push($this->data['courseTaken'], $datas);
									// }
									// $this->view('users/advising',$this->data);
									// exit();
								}
								else{
									
									$data['course_err'] ='Cant Take Course!!';
									$this->view('users/advising',$data);
									exit();
								}
							}

					    }
	         		}
			   	}
			   	elseif(!$checkPrerequisite){

		       	   if($seatsCheck){
		       	    //    if($gpa->GPA<3.0){
					        if($creditLimit->sumCredit<$credit_limitation){
						        if(!$exists){
						//check clash time here
						
							         if (!$this->advisingModel->time($dtCheck)) { 
								//time check to see if there is no clash
								          $this->advisingModel->insertCourse($course,$section,$semester,$year);
								
								    //       $row = $this->advisingModel->showAdvisedCourses();
								    //       foreach ($row as $value) {
									   //         $datas =[
										  //     'cid'=>$value->Course_Code,
										  //      'sec'=>$value->Section
									   //         ];
									   //         array_push($this->data['courseTaken'], $datas);
								    //         }
								    // $this->view('users/advising',$this->data);
								    // exit();
							       }
					               else{
								
							          $data['course_err'] ='Cant Take Course!!';
							          $this->view('users/advising',$data);
							           exit();
							        }
						        }

				            }
	                 //   }
	                }
	          	}
	          	else{

				 	echo "hello";
				 	print_r($checkPrerequisite);
					if($checkPrerequisite){
						echo "string";
							//$bool=0;
				     		foreach ($checkPrerequisite as $value){

				     			print_r($value->Prerequisite);
								if($this->advisingModel->courseCompletion($value->Prerequisite)){
									
									$bool++;
									echo"{";
									echo "<br>".$bool;
									echo "}";
								    
					            }
				        	}
				    }
				}
        }
		print_r($checkPrerequisite);

        if ($bool>0) {
 			

        

	        if(count($checkPrerequisite)==$bool){
	        	echo "<br> Bello";
	        	print_r($seatsCheck);
		        if($seatsCheck){
		        	echo "<br>string";

		        	//print_r($gpa);
			        // 	if($gpa->GPA<3.0){
						if($creditLimit->sumCredit<$credit_limitation){
							if(!$exists){
							//check clash time here
							
								if (!$this->advisingModel->time($dtCheck)) { 
									//time check to see if there is no clash
									$this->advisingModel->insertCourse($course,$section,$semester,$year);
									
									// $row = $this->advisingModel->showAdvisedCourses();
									// foreach ($row as $value) {
									// 	$datas =[
									// 		'cid'=>$value->Course_Code,
									// 		'sec'=>$value->Section
									// 	];
									// 	array_push($this->data['courseTaken'], $datas);
									// }
									// $this->view('users/advising',$this->data);
									// exit();
								}
								else{
									
									$data['course_err'] ='Cant Take Course!!';
									$this->view('users/advising',$data);
									exit();
								}
							}

					    }
		        //	}
		   		}
	       	}
       }
   	}




	   

	 // public function drop($course){
		// $this->advisingModel->Drop($course);
	 // }


	 // public function advising(){
	 // 	$advising=$this->advisingModel->showAdvisedCourses();
	 // 	$show=array();
	 // 	foreach ($advising as $value){
	 	
  //             $datas =[
		// 		'cid'=>$value->Course_Code,
		// 		'sec'=>$value->Section
		// 		];
	 // 	}

	 // 	$this->view('users/advising',$data);
		
  //   }
}
//}
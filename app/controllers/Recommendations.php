<?php 
/**
 * 
 */
class Recommendations extends  Controller
{
	private $recomModel;
	function __construct()
	{
		$this->recomModel =$this->model('Recommendation');
	}

	public function index()
	{
		$data = array(
			'cse'=>[],
			'cod'=>[],
			'mns'=>[],
			'elective'=>[],
		);
		
		//array_push($data['cse'], var)
		$courseLeft=array();
		$recom= $this->recomModel->coursesLeft();
		foreach ($recom as  $value) {
			array_push($courseLeft, $value->Course_Code);
		}
		//print_r($datas);
		//$data['cse'];
		//$this->view('users/recommendation',$courseLeft);

		 $registeredCourses=array();
		 $regi=$this->recomModel->courseRegistered();
		 foreach ($regi as $value){
		 	array_push($registeredCourses,$value->Course_Code);
		 }
		 
		$prerequisiteOfCoursesDone=array();
		$precom=$this->recomModel->courseComPre();
		foreach ($precom as $value) {
		 	array_push($prerequisiteOfCoursesDone, $value->Course_Code);
		 }


		 $courseCom=array();
		 $ccom=$this->recomModel->courseCompleted();
		 foreach ($ccom as  $value) {
		 	array_push($courseCom, $value->Course_Code);
		 }
 

         $cseMajor=array();
         $cseMaj=$this->recomModel->cseMajor();
          foreach ($cseMaj as  $value) {
          	array_push($cseMajor,$value->Course_Code);
          }
      

           $csMajor=array();
           $csMaj=$this->recomModel->csMajor();
           foreach ($csMaj as  $value) {
           	array_push($csMajor,$value->Course_Code);
           }
           

           $courseNoPrereq=array();
           $noPrereq=$this->recomModel->courseWithoutPrereq();
           foreach ($noPrereq as  $value) {
           	array_push($courseNoPrereq,$value->Course_Code);
           }
           

           $credit=array();
           $cre=$this->recomModel->credits();
           foreach ($cre as  $value) {
           	array_push($credit,$value->credits);
           }
           

           $mnsMandatory=array();
           $mnsman=$this->recomModel->mnsMandatory();
           foreach ($mnsman as  $value) {
           	array_push($mnsMandatory,$value->Course_code);
           }
         
           $cseElective=array();
           $cseElec=$this->recomModel->cseElective();
           foreach ($cseElec as  $value) {
           	array_push($cseElective,$value->Course_Code);
           }
           

            $mnsPreq=array();
            $mnsPrerequisite=$this->recomModel->mnsPrerequisite();
            foreach ($mnsPrerequisite as $value) {
           	array_push($mnsPreq, $value->Course_code);
            }


            $cseEPreq=array();
            $cse111=$this->recomModel->cseNoPreq1();
            foreach ($cse111 as $value) {
           	array_push($cseEPreq, $value->Course_Code);
            }



            $mnsDone=array();
            $mnsD=$this->recomModel->mnsDone();
           foreach ($mnsD as $value) {
            	array_push($mnsDone, $value->Course_code);
            }


            $cseDone=array();
            $cseD=$this->recomModel->cseDone();
            foreach($cseD as $value){
            	array_push($cseDone, $value->Course_Code);
            }


           $combinedCourses=array();

           $cse=array();
           $mns=array();
           $COD=array();
           $cseelective=array();
           $combinedCourses1=array();
           $COD1=array('ECO101','BUS101','HUM101','SOC101','MGT211','ACT201');
		

  
$combinedCourses1=array_diff($courseLeft, $registeredCourses);                                                   //removing the same value from the course registration and course completed

$combinedCourses=array_diff($courseLeft, $registeredCourses); 
 //removing the same value from the course registration and course completed

$combinedCourses=array_diff($prerequisiteOfCoursesDone, $courseCom);                 
//removing the course which has been already done from prereq

$combinedCourses=array_diff($combinedCourses, $registeredCourses);   
          //removing the courses that is already being registered

$combinedCourses=array_merge($combinedCourses,$courseNoPrereq);                                                 //including the courses that has no prerequisite

$combinedCourses=array_diff($combinedCourses, $courseCom);                                                       //after removing everything if there still remain same course in course completed remove it

echo"<pre>";
echo('<br>');
echo("RECOMMENDED CSE COURSES: ");
echo "<br>";
sort($combinedCourses);                                        
 //sorting the array on ascending order

for ($i=0;$i<count($combinedCourses);$i++){          

 ///checking all the cse courses that is matching with the cse major courses

	for($j=0;$j<count($cseMajor);$j++){
		if($combinedCourses[$i]==$cseMajor[$j]){
			array_push($cse, $combinedCourses[$i]);
		}
		}
		}

		 if( !$mnsDone){                
		 	//IF NO MNS COURSE IS DONE
 			array_push($mns, $mnsPreq);
 		}
 		else{
 			//IF MNS COURSE IS DONE BUT OYHER MNS WITH NO PREQ IS NOT DONE THEN WILL RECOMMEND THOSE COURSE
 				$mns=array_diff($mnsPreq,$mnsDone);

 			}
 		

for ($i=0;$i<count($combinedCourses);$i++){                    ///checking all the mns courses that is matching with the mandatory mns courses
 	for($j=0;$j<count($mnsMandatory);$j++){
 		if($combinedCourses[$i]==$mnsMandatory[$j]){
 			array_push($mns, $combinedCourses[$i]);
 		}
 		}
 		}

		$cr=array_pop($credit);                       
		 //keeping the value of the credit in the cr variable

		if($cr<'90'){
			$cse=\array_diff($cse, ["CSE400"]);  
       //checking the credits if less than 90 the it will remove the thesis course from the array cse
			 
			$cse=array_values($cse);  
		 //reindexing array
		}

$ccc=count($cse);
$combinedCourses=array_diff($combinedCourses, $cseMajor);   
//REMOVING THE SAME COURSES FROM COMBINED WHICH MATCHES WITH THE CSEMAJOR


if($ccc>=5){
for($i=0;$i<=4;$i++){                                  
  //ONLY PRINTING THE FIRST FIVE COURSES

	print_r($cse[$i]);                         //print cse
	echo("<br>");
}
}
else{
	for ($j=0; $j <count($cse) ; $j++) {
	print_r($cse[$j]);                        //print cse
	echo"<br>";
}
}

sort($mns);                                             
echo ("<br>");                                                          
echo"RECOMMENDED MANDATORY MNS COURSES: "; 
echo"<br>";                           
   //FINDING OUT THE MANDATORY MNS COURSES    

for($i=0;$i<count($mns);$i++){
 	print_r($mns[$i]);                         //print mns
 	echo "<br>";
 }

echo "<br>";
echo"RECOMMENDED COD COURSES: ";
echo"<br>";
$COD=array_diff($combinedCourses,$cseElective);      
 //combined courses contain everything so removing the elective one so that got cod

$COD=array_diff($COD,$mns); 
//$COD=array_merge($COD,$COD1) ;                                                                                //after removing the elective mns is also removed

sort($COD);                                         

 $ccod=count($COD);
 //After finding out everything there remains only cod so counting the elements as cod

 if ($ccod>=2) {                                       
 //only two cod courses will be shown

for($i=0;$i<=1;$i++){
print_r($COD[$i]);                                   //print cod
echo "<br>";
}
}
else{
	for ($i=0; $i <count($COD) ; $i++) { 
		
	print_r($COD[$i]);                                 //print cod
	echo "<br>";
}
}

if(!$COD){
	//if no cod course is done before

	$COD=array_merge($COD,$COD1);
	print_r($COD);                                     //print cod
}

echo"<br>";
echo"ELECTIVE COURSES YOU CAN DO: ";
echo"<br>";
 for ($i=0; $i <count($cseElective) ; $i++) { 
	print_r($cseElective[$i]);                          //print elective
	echo "<br>";
 }
 echo "<br>";

}
}


 
	


 ?>
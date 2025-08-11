<?php 

/**
 * 
 */
class Advising
{
	private $db;
	function __construct()
	{
		$this->db = new Database;
	}

	public function getAllCourses()
	{
		$this->db->query('
				SELECT 
					`course_offered`.Course_Code, `course_offered`.Section,
					`course_faculty`.Faculty_Initials,`course_offered`.Total_Seats,
					`course_offered`.Seats_Booked, `course_offered`.Seats_Remaining,
					`days`.Day,`time_slots`.Start_Time,`time_slots`.End_Time,
					`course_offered`.Semester,`course_offered`.Year
	    
				FROM course_offered 
				INNER JOIN course_schedule
				ON `course_offered`.CCS = `course_schedule`.CCS
				INNER JOIN course_faculty ON `course_offered`.CCS = `course_faculty`.CCS
				INNER JOIN days ON `days`.Day_ID = `course_schedule`.days
				INNER JOIN time_slots ON `course_schedule`.slot = `time_slots`.Time_ID  
				ORDER BY `course_offered`.CCS ASC
			');
		return $this->db->resultSet();
		
	}

 	public function insertCourse($course,$section,$semester,$year)
	   {
   		$this->db->query('
 				INSERT INTO course_registraion
 				
 				VALUES(:sem,:yr,:id,:course,:sec) 
			');
  		$this->db->bind(':sem',		$semester);
 		$this->db->bind(':yr',		$year);
 		$this->db->bind(':id',		$_SESSION['user_id']);
  		$this->db->bind(':course',	$course);
  		$this->db->bind(':sec',		$section);
       	$row= $this->db->execute();

       
 		
  		
  		$this->updateSeatBooked($course,$section);
  			
 	}

	public function checkCGPA(){
 	$this->db->query('
				
 				SELECT 
 					(SUM(Credit*`course_completed`.GPA)/ SUM(Credit)) AS CGPA 
 				FROM (list_of_courses 
 				INNER JOIN course_completed 
 				ON `list_of_courses`.Course_Code=`course_completed`.Course_Code ) 
 				WHERE Student_ID =:id'
 			);
	
	$this->db->bind(':id',$_SESSION['user_id']);
	
return $this->db->single();
// 	echo"3";
// 	echo"<br>";
// 	print_r($this->db->single());

	
// 	// $this->dbconn->query($my_sql4);
// 	// $this->Update_Seat_Remaining($course1,$section);
// 	// $this->Update_Seat_Booked($course1,$section);

 }

 public function checkPrerequisite($course){

 	$this->db->query('SELECT `prerequisites`.Prerequisite FROM (prerequisites INNER JOIN list_of_courses ON `prerequisites`.Course_Code=`list_of_courses`.Course_Code)WHERE `list_of_courses`.Course_Code =:cc' );
 	$this->db->bind(':cc',$course);
 	$row=$this->db->resultSet();
// 	//$prerequisite=trim(str_replace("", "", $pre));
	if ($this->db->rowCount()>0) {
 		return $row;

// 		echo"4";
// 		echo"<br>";
// 		print_r($this->db->resultSet());
// 		echo"<br>";
 	}
 	else{
           return false;
 //		echo"false";
 	}

 }


 public function checkGPAOfCourseCompleted($course){
 	$this->db->query('SELECT GPA FROM course_completed WHERE Course_Code =:cc AND Student_ID=:id');
 	$this->db->bind(':id',$_SESSION['user_id']);
 	$this->db->bind(':cc',$course);
// 	//$courseGrade=trim(str_replace("", "", $Course22));
     return $this->db->single();
// 	echo"5";
// 	echo"<br>";
// 	print_r($this->db->single());
// 	echo"<br>";
 

 }


 public function courseCompletion($course){
     $this->db->query('SELECT * FROM course_completed where Course_Code = :cc AND Student_ID=:id');
     $this->db->bind(':id',$_SESSION['user_id']);
     $this->db->bind(':cc',$course);
// //$courseCompleted=trim(str_replace("", "", $check));
   $row=$this->db->resultSet();
   print_r($row);
   if($this->db->rowCount()>0){
   	return true;
   }
   else{
   	return false;
   }
// echo"6";
// echo"<br>";

// print_r($this->db->resultSet());
// echo"<br>";

 }


 	public function seatsCheck($course,$section){

		
 		$this->db->query('
 				SELECT 
 				Seats_Remaining,Seats_Booked 
 				FROM course_offered 
 				WHERE Course_Code = :cc AND Section = :sec'
 			);
 			$this->db->bind(':cc',$course);
 			$this->db->bind(':sec',$section);
 			$row = $this->db->single();

// 			echo"7";
// 			echo"<br>";		
 			print_r($row);
// 			print_r($row->Seats_Booked);
// 			echo"<br>";
 			if ($row->Seats_Remaining>=0 && $row->Seats_Remaining<=40) {
 				return true;
 				# code...
 			}
 			else{
 				return false;
 			}
		

 	}


 public function creditLimit(){
 	$this->db->query('SELECT SUM(Credit) AS sumCredit FROM (list_of_courses INNER JOIN course_registraion ON `course_registraion`.Course_Code=`list_of_courses`.Course_Code)WHERE `course_registraion`.Student_ID =:id' );
 	$this->db->bind(':id',$_SESSION['user_id']);
// 	echo"7";
// 	echo"<br>";
// 	print_r($this->db->single());
     return $this->db->single();

  }

 public function Drop($course){
   $this->db->query('DELETE FROM `course_registraion` WHERE `course_registraion`.`Student_ID` =:id AND `course_registraion`.`Course_Code` = :cc');
 	$this->db->bind('cc:',$course);
 	$this->bd->bind(':id',$_SESSION['user_id']);
     // echo"8";
     // echo"<br>";
     // print_r($row);
     // echo"<br>";	
 	$this->db->query('UPDATE course_offered SET Seats_Booked=Seats_Booked-1 WHERE Course_Code=:cc AND Section=:sec');
 	$this->db->bind(':cc',$course);
 	$this->db->bind(':sec',$section);
 	// echo"81";
 	// echo"<br>";
 	// print_r($row1);
 	// echo"<br>";		
 }

 public function showAdvisedCourses(){
 	$this->db->query('SELECT * FROM `course_registraion` WHERE Student_ID :id');
 	$this->db->bind(':id',$_SESSION['user_id']);
    $row= $this->db->resultSet();

     print_r($row);
     return $row;

// 	echo"9";
// 	echo"<br>";
// 	print_r($this->db->resultSet());

 }

  public function timeCheck(){
	$this->db->query('SELECT `course_schedule`.days,`course_schedule`.slot,`course_offered`.Course_Code FROM ((course_schedule INNER JOIN course_offered ON `course_schedule`.CCS=`course_offered`.CCS)INNER JOIN course_registraion ON `course_offered`.Course_Code=`course_registraion`.Course_Code AND `course_offered`.Section=`course_registraion`.Section)WHERE `course_registraion`.Student_ID=:id');

      	$this->db->bind('id',$_SESSION['user_id']);
      	return $this->db->resultSet();


 }
public function dayTime($course,$section){
	$this->db->query('SELECT `course_schedule`.days,`course_schedule`.slot from course_schedule INNER join course_offered on `course_schedule`.CCS=`course_offered`.CCS WHERE `course_offered`.Course_Code=:cc AND `course_offered`.Section=:sec ');
	$this->db->bind('cc',$course);
	$this->db->bind('sec',$section);
	///$this-time($);

	
	return $this->db->resultSet();
}


public function time($dayTime=[]){

	foreach ($dayTime as $value) {
		$this->db->query('

			SELECT Course,Section ,Day,Slot FROM (SELECT 
					`course_registraion`.Course_Code AS Course,
					`course_registraion`.Section AS Section,`course_schedule`.days AS Day,`course_schedule`.slot AS Slot,
					`time_slots`.Start_Time,`time_slots`.End_Time
				FROM
				(
					course_registraion INNER JOIN 
					course_offered 
					ON `course_registraion`.Course_Code = `course_offered`.Course_Code
					AND `course_registraion`.Section = `course_offered`.Section


					INNER JOIN course_schedule
					ON `course_schedule`.CCS= `course_offered`.CCS

					INNER JOIN days
					ON `days`.Day_ID=`course_schedule`.days

					INNER JOIN time_slots
					ON `course_schedule`.slot=`time_slots`.Time_ID
	                 
				)
				WHERE `course_registraion`.Student_ID= :id
			) AS table1 WHERE Day = :day AND Slot =:slot 
		');
		$this->db->bind(':id',$_SESSION['user_id']);
		$this->db->bind(':day',$value['dt']);
		$this->db->bind(':slot',$value['slt']);
		$row = $this->db->resultSet();
		print_r($row);
		if($this->db->rowCount()>0){
			return true;
		}

	}
	return false;
	

}
 // public function updateSeatRemaining($course,$section){
 // 	$this->db->query('UPDATE course_offered SET Seats_Remaining=Seats_Remaining-1 WHERE Course_Code=:cc AND Section=:sec');
 // 	$this->db->bind(':cc',$course);
 // 	$this->db->bind(':sec',$section);
 // 	return $this->db->single();
 // 	// echo"9";
 // 	// echo"<br>";
 // 	// print_r($this->db->single());
 // 	// echo"<br>";
	
 // }
 public function updateSeatBooked($course,$section){
 	$this->db->query('UPDATE course_offered SET Seats_Booked = Seats_Booked+1 WHERE Course_Code=:cc AND Section=:sec');

 	$this->db->bind(':cc',$course);
 	$this->db->bind(':sec',$section);
 	$row=$this->db->execute();
 	print_r($row);
 	//return $row;

 	// echo"10";
 	// echo"<br>";
 	// print_r($this->db->single());
	
 }

 public function ifExists($course)
	{
		$this->db->query('SELECT * FROM course_registraion WHERE Course_Code=:cc
		AND Student_ID =:id');
		$this->db->bind(':cc',$course);
		$this->db->bind(':id',$_SESSION['user_id']);
		

		$row =$this->db->single();
		print_r($row);
		if($this->db->rowCount()>0){
			return true;
		}else{

			return false;
		}



		
 }
}
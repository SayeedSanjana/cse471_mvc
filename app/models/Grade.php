<?php

/**
 * 
 */
class Grade
{
	private $db;
	function __construct()
	{
		$this->db= new Database();
	}

	//this method loads all the grades
	public function getGrades()
	{
		$this->db->query('
				SELECT
				`course_completed`.`Semester`,`course_completed`.`Year`,
				`list_of_courses`.`Course_Description`,
				`course_completed`.`Course_Code`,`list_of_courses`.`Credit`,
				`course_completed`.`GPA` 
				FROM
				`course_completed` 
		
				INNER JOIN `list_of_courses`
		
				ON(`course_completed`.`Course_Code` = `list_of_courses`.`Course_Code`) 
				WHERE Student_ID = :id 
				ORDER BY  FIELD (`course_completed`.`Semester`,"Summer","Fall","Spring"),
				`course_completed`.`Year` ASC
			');
		$this->db->bind(':id',$_SESSION['user_id']);
		$row=$this->db->resultSet();
		if($this->db->rowCount()>0){
			return $row;
		}

		return false; 
	}
	// Total credits completed by the student user

	public function getCreditsCompleted()
	{
		$this->db->query('
				SELECT SUM(`Credit`) AS Credits_Completed FROM
				(
					SELECT
					`list_of_courses`.`Credit`
					FROM
					`course_completed` 
					INNER JOIN `list_of_courses`
	
					ON(`course_completed`.`Course_Code` = `list_of_courses`.`Course_Code`) 
					WHERE Student_ID = :id 
 
				) AS credits
			');

		$this->db->bind(':id',$_SESSION['user_id']);

		return $this->db->single();
	}
	// Total credits of the programme enrolled in
	public function getTotalCredits()
	{
		$this->db->query('
				SELECT `programmes`.Total_Credits 
				FROM login 
				INNER JOIN department 
				ON `login`.`Department` = `department`.`D_ID`
				INNER JOIN `programmes` 
				ON `department`.D_ID = `programmes`.P_ID
				WHERE `login`.`ID`=:id
			');
		
		$this->db->bind(':id',$_SESSION['user_id']);

		return $this->db->single();
	}
	//cgpa of the student user
	public function getCGPA()
	{
		$this->db->query('
				SELECT 
				ROUND(CreditPoint/Credit,2) AS CGPA 
				FROM
				(
					SELECT SUM(GPA*Credit) AS CreditPoint, SUM(Credit)AS Credit
					FROM
					(
						SELECT
							`list_of_courses`.`Credit`,
							`course_completed`.`GPA` 
						FROM
						`course_completed` 
	
						INNER JOIN `list_of_courses`
	
						ON(`course_completed`.`Course_Code` = `list_of_courses`.`Course_Code`) 
						WHERE Student_ID = :id 
	
      				) AS gpa
				) AS cgpa_table
			');

		$this->db->bind(':id', $_SESSION['user_id']);
		return $this->db->single();
	}
	/*
		Query to Get 
			maximum year --> current semester year
			Minimum year --> year of enrollment
	*/
	public function getYearRange()
	{
		$this->db->query('
				SELECT MAX(`Year`) AS maxYear, MIN(`Year`) AS minYear 
				FROM course_completed WHERE Student_ID =:id
			');
		$this->db->bind(':id',$_SESSION['user_id']);

		return $this->db->single();
	}
}
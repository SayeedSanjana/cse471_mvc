<?php 

/**
 * 
 */
class Home
{
	private $db;
	
	function __construct()
	{
		$this->db = new Database();
	}

	public function routine()
	{
		$this->db->query('
			SELECT 
				`course_registraion`.Course_Code ,
				`course_registraion`.Section,`days`.Day,`course_schedule`.slot,
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
			WHERE `course_registraion`.Student_ID= :id');

		$this->db->bind(':id',$_SESSION['user_id']);
		return $this->db->resultSet();
	}

	public function days()
	{
		$this->db->query('SELECT * FROM `days`');
		return $this->db->resultSet();
	}

	public function timeSlots()
	{
		$this->db->query('SELECT * FROM `time_slots` ORDER BY `Start_Time` ASC');
		return $this->db->resultSet();
	}

	public function academicNotice()
	{
		$this->db->query('
				SELECT 
					`course_registraion`.Course_Code ,
					`course_registraion`.Section, `academic_posts`.Post
				FROM
				(
					course_registraion INNER JOIN 
					course_offered 
					ON `course_registraion`.Course_Code = `course_offered`.Course_Code
					AND `course_registraion`.Section = `course_offered`.Section
		            INNER JOIN course_faculty ON `course_faculty`.CCS = `course_offered`.CCS
		            INNER JOIN academic_posts ON `academic_posts`.CCS=`course_faculty`.CCS
				)
				WHERE `course_registraion`.Student_ID=:id
			');
		$this->db->bind(':id',$_SESSION['user_id']);
		return $this->db->resultSet();
	}
}

?>
<?php 
/**
 * 
 */
class Recommendation
{
	private $db;
	
	function __construct()
	{
		$this->db=new Database();
	}

	public function coursesLeft()
	{
		$this->db->query(
       ' SELECT 
					`cse_major`.Course_Code 
				FROM cse_major 
				WHERE NOT EXISTS
				(
					SELECT 
						`course_completed`.Course_Code
					FROM 
					(
						(course_completed 
						CROSS JOIN course_registraion)
						INNER JOIN student ON 
						`course_registraion`.Student_ID=`student`.ID
					) 
					WHERE `course_completed`.Course_Code=`cse_major`.Course_Code 
					AND `course_registraion`.Course_Code!=`course_completed`.Course_Code 
					AND `student`.ID=:id
				)
			');
				
		$this->db->bind(':id', $_SESSION['user_id']);
		return $this->db->resultSet();

	}

	public function courseRegistered(){
		$this->db->query(
			'SELECT `course_registraion`.Course_Code from `course_registraion` WHERE `course_registraion`.Student_ID=:id');
		$this->db->bind(':id',$_SESSION['user_id'])	;
		return $this->db->resultSet();
		echo"<br>";
	}

	public function courseComPre(){
		$this->db->query(
        
		'SELECT `prerequisites`.Course_Code FROM ((prerequisites CROSS JOIN course_registraion)INNER JOIN student ON `course_registraion`.Student_ID=`student`.ID)WHERE `course_registraion`.Course_Code=`prerequisites`.Prerequisite AND `student`.ID=:id UNION SELECT `prerequisites`.Course_Code FROM( (prerequisites CROSS JOIN course_completed )INNER JOIN student ON `course_completed`.Student_ID=`student`.ID)WHERE `course_completed`.Course_Code=`prerequisites`.Prerequisite AND `student`.ID=:id ORDER BY Course_Code ASC ');
		$this->db->bind(':id',$_SESSION['user_id']);
		return $this->db->resultSet();
		
	}

	public function courseCompleted(){
		$this->db->query(
       'SELECT `course_completed`.Course_Code from course_completed WHERE `course_completed`.Student_ID=:id'
		);
		$this->db->bind(':id',$_SESSION['user_id']);
		return $this->db->resultSet();
	}


	public function cseMajor(){
		$this->db->query(
        'SELECT Course_Code FROM cse_major'
		);
		return $this->db->resultSet();

	}

	public function csMajor(){
		$this->db->query(
        'SELECT Course_Code FROM cs_major');
		return  $this->db->resultSet();
	}


	public function courseWithoutPrereq(){
		$this->db->query(
       'SELECT Course_Code FROM Prerequisites WHERE Prerequisites.Prerequisite="001" ' );
		return $this->db->resultSet();
	}

	public function credits(){
		$this->db->query('SELECT SUM(`list_of_courses`.Credit) as credits from(list_of_courses inner join course_completed on `list_of_courses`.Course_Code=`course_completed`.Course_Code) WHERE `course_completed`.Student_ID=:id ');
		  $this->db->bind(':id',$_SESSION['user_id']);
		return $this->db->resultSet();
	}

	public function mnsMandatory(){
		$this->db->query('SELECT `mandatory_mns_courses`.Course_code from mandatory_mns_courses');
		return $this->db->resultSet();
	}

    public function cseElective(){
    	$this->db->query('SELECT cse_electives.Course_Code FROM cse_electives');
    	return $this->db->resultSet();
    	


    }

    public function departmentChoosing(){
    	$this->db->query('SELECT `login`.Department FROM login WHERE `login`.ID=:id ');
    	$this->db->bind(':id',$_SESSION['user_id']);
    	return $this->db->resultSet();
    }


    public function mnsPrerequisite(){
    	$this->db->query(
         'SELECT `mandatory_mns_courses`.Course_code FROM `mandatory_mns_courses` WHERE `mandatory_mns_courses`.Prerequisites=0 '
    	);

    	return $this->db->resultSet();
    }

     public function mnsDone(){
     	$this->db->query(
         'SELECT `course_completed`.Course_code from (mandatory_mns_courses INNER join course_completed on `mandatory_mns_courses`.Course_code=`course_completed`.Course_Code) WHERE `course_completed`.Student_ID=:id'
    	);
    	$this->db->bind(':id',$_SESSION['user_id']);
    	
     	return $this->db->resultSet();
     }


     public function cseDone(){
     	$this->db->query(
        'SELECT `course_completed`.Course_Code FROM course_completed INNER JOIN cse_major ON `course_completed`.Course_Code=`cse_major`.Course_Code WHERE `course_completed`.Student_ID=:id '
     	);
     	$this->db->bind(':id',$_SESSION['user_id']);
     	 return $this->db->resultSet();
     }

     public function cseNoPreq1()
     {

     	$this->db->query('SELECT `cse_major`.Course_Code from cse_major WHERE `cse_major`.Prerequisites=0 ');
     	 return $this->db->resultSet();
     }

     // public function n
     // SELECT course_completed.Course_Code FROM course_completed WHERE EXISTS (SELECT mandatory_mns_courses.Course_code FROM mandatory_mns_courses WHERE course_completed.Course_Code=mandatory_mns_courses.Course_code AND course_completed.Student_ID='17301189')

 
}
		

	





 ?>


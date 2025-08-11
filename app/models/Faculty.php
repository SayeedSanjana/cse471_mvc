<?php /**
 * 
 */
class Faculty
{
	private $db;
	
	function __construct()
	{
		$this->db= new Database();
	}

	public function getAllFaculty()
	{
		$this->db->query('SELECT * from cse_faculty_information');

		return $this->db->resultSet();
	}

} 
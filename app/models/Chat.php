<?php 

/**
 * 
 */
class Chat
{
	private $db;
	function __construct()
	{
		$this->db = new Database;
	}
	public function insert($message){
		$this->db->query('INSERT INTO `message` (`ID`, `Email_Address`, `message`) VALUES (:id, :name, :message)');
		$this->db->bind(':id',$_SESSION['userid']);
		$this->db->bind(':name',$_SESSION['username']);
		$this->db->bind(':message',$message);
	}
}

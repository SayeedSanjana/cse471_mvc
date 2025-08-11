<?php
/**
  * 
  */
 class User
 {
 	private $db;
 	
 	public function __construct()
 	{
 		$this->db = new Database();
 	}
 	public function validateUser($username)
 	{
 		
 		$this->db->query('SELECT * FROM `login` WHERE  `Email_Address` = :username;');
 		//$email = $username;	
 		$this->db->bind(':username',$username);
 		
 		//echo "<pre>";
 		$this->db->single();
 		
 		//print_r($this->db->rowCount());
 		if($this->db->rowCount() > 0){
 			return true;
 		}
 		else{
 			return false;
 		}

 	}

 	//password verify
 	public function login($username,$password)
 	{
 		$this->db->query('SELECT * FROM `login` WHERE Email_Address =:email');
 		
 		$this->db->bind(':email',$username);
 		
 		$row = $this->db->single();

 		if($this->validateUser($username) && password_verify($password, $row->Password)){
 			return $row;
 		}else{
 			return false;
 		}
 	}

 	//Sign Up is incomplete needs critical Attention later
 	public function signUp($data)
 	{
 		$this->db->query("INSERT INTO `student`()");
 	}
 	
 } 
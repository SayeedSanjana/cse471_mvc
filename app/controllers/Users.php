<?php
	/**
	  * 
	  */
	 class Users extends Controller{
	 	private $userModel;
	 	
	 	function __construct()
	 	{
	 		$this->userModel = $this->model('User');
	 	}

	 	
		//*************************************************************************************//

	 	public function signUp()
	 	{
	 		/*
	 		 	Depending on GET or POST request it will handle
	 		 	Either loading of Sign Up Page or it will submit Data of
	 		 	Sign Up credentials filled by user 
	 		*/ 
 		 	// Check For POST
 		 	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 		 		# Process Form
 		 		//init data

 		 		$_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
 		 		$data=[
 		 			'name'=>trim($_POST['name']),
 		 			'id'=>trim($_POST['id']),
 		 			'email'=>trim($_POST['email']),
 		 			'password'=>trim($_POST['password']),
 		 			'confirm_password'=>trim($_POST['confirm_password']),
 		 			'name_err'=>'',
 		 			'id_err'=>'',
 		 			'email_err'=>'',
 		 			'password_err'=>'',
 		 			'confirm_password_err'=>'',
 		 		];
 		 		

 		 		//validate name
 		 		if (empty($data['name'])) {
 		 			$data['name_err']= 'Please Enter Name';
 		 		}
 		 		

 		 		//validate ID
 		 		if (empty($data['id'])) {
 		 			$data['id_err']= 'Please Enter ID';
 		 		}
 		 		

 		 		//validate Email
 		 		if (empty($data['email'])) {
 		 			$data['email_err']= 'Please Enter Email';
 		 		}else{

 		 			if ($this->userModel->validateUser($data['email'])) {
 		 				$data['email_err']='Email Already Taken! Try Another Email.';
 		 			}
 		 		}
 		 		

 		 		//validate password
 		 		if (empty($data['password'])) {
 		 			$data['password_err'] = 'Please Enter Password';
 		 		}elseif (strlen($data['password'])<6) {
 		 			$data['password_err'] = 'Password must be atleast 6 character.';
 		 		}
 		 		

 		 		//validate confirm password
 		 		if (empty($data['confirm_password'])) {
 		 			$data['confirm_password_err'] = 'Please Enter Confirm Password.';
 		 		}else{
 		 			if ($data['confirm_password']!=$data['password']) {
 		 				$data['confirm_password_err'] = 'Passwords do not match.';
 		 			}
 		 		}
 		 		

 		 		//Make sure errors are empty()
 		 		if (empty($data['name_err']) && empty($data['id_err']) 
 		 			&& empty($data['email_err'])&& empty($data['password_err']) 
 		 			&& empty($data['confirm_password_err'])) {
 		 			// validated
 		 			
 		 			// hash password
 		 			$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
 		 			
 		 			// sign up user
 		 			if($this->userModel->signUp($data)){
 		 				flash('signup_success','You can now login');

 		 			}else{
 		 				die('Something Went Wrong');
 		 			}

 		 			//die('Success');
 		 		}else{
 		 			$this->view('users/signUp', $data);
 		 		}

 		 	}else{
 		 		//load form
 		 		//init data
 		 		$data=[
 		 			'name'=>'',
 		 			'id'=>'',
 		 			'email'=>'',
 		 			'password'=>'',
 		 			'confirm_password'=>'',
 		 			'name_err'=>'',
 		 			'id_err'=>'',
 		 			'email_err'=>'',
 		 			'password_err'=>'',
 		 			'confirm_password_err'=>'',
 		 		];

 		 		$this->view('users/signUp',$data);
 		 	}
 		}
	 	


		//************************************************************************************//

	 	public function login()
	 	{
	 		// Check For POST
 		 	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 		 		# Process Form

 		 		$_POST=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

 		 		$data=[
 		 			
 		 			'username'=>trim($_POST['username']),
 		 			'password'=>trim($_POST['password']),
 		 			'username_err'=>'',
 		 			'password_err'=>''
 		 		];
 		 		
 		 		//validate username
 		 		if (empty($data['username'])){
 		 			$data['username_err'] ='Please enter Username';
 		 		}else{
 		 			 if(!$this->userModel->validateUser($data['username'])){
 		 			 	$data['username_err']='User not found!';
 		 			 }
 		 		}
 		 		
 		 		//validate password
	 			if (empty($data['password'])) {
	 				$data['password_err']='Please enter password to continue';
	 			}elseif (!$this->userModel->login($data['username'],$data['password'])) {
	 				$data['password_err'] = 'Incorrect password';
	 			}
	 			//make sure error fields are empty
	 			if(empty($data['username_err']) && empty($data['password_err'])){
	 				if ($this->userModel->login($data['username'],$data['password'])) {
	 					//verify password
	 					$loggedInUser =$this->userModel->login($data['username'],$data['password']);
	 					$this->createUserSession($loggedInUser);
	 				}
	 				
	 			}else{
	 				$this->view('users/login',$data);
	 			}

 		 	}else{
 		 		//load form
 		 		//init data
 		 		$data=[
 		 			'username'=>'',
 		 			'password'=>'',
 		 			'username_err'=>'',
 		 			'password_err'=>''
 		 		];
 		 		$this->view('users/login',$data);
 		 	}
 		}

 		//************************************************************************************//
 		
 		public function logout()
 		{
 			//logout and unset sessions
 			unset($_SESSION['user_id']);
 			unset($_SESSION['user_email']);
 			unset($_SESSION['user_dept']);
 			session_destroy();
 			redirect('users/login');
 		}

 		//************************************************************************************//
 		
 		public function createUserSession($user)
 		{
 			$_SESSION['user_id']=$user->ID;
 			$_SESSION['user_email']=$user->Email_Address;
 			$_SESSION['user_dept']=$user->Department;
 			redirect('HomePage');
 		}

	 }
 ?>

 
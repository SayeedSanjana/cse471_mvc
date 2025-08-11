<?php 
/**
 * base Controller
 * loads Models And Views
 */
class Controller
{
	
	function __construct()
	{
		
	}
	//load model
	public function model($model)
	{
		//require model file
		//ucwords($model);
		require_once '../app/models/'.$model.'.php';

		//instantiatate	model
		return new $model();
	}

	//load view

	public function view($view, $data =[])
	{
		//check for the file
		if (file_exists('../app/views/'.$view.'.php')) {
			
			require_once '../app/views/'.$view.'.php';
		}
		//else view does not exist
		else
		{
			die("View Does not Exist!!");
		}
	}
}
?>
<?php 
	/* 
	* PDO Database Class
	* Connect to Database
	* Create Prepare Statements
	* Bind Values
	* Return Rows And Results
	*/
	
	class Database
	{
		private $host = DB_HOST;
		private $user = DB_USER;
		private $pass = DB_PASS;
		private $dbname = DB_NAME;
		
		private $dbh ;// Database Handler, when ever prepared statements are called, dbh will 
					//  be used
		private $stmt;
		private $error;

		function __construct()
		{
			# Set DSN
			$dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname;
			$options =array(
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			); 
			// Create PDO instance 
			try {
				$this->dbh = new PDO($dsn,$this->user,$this->pass,$options);
			} catch (PDOException $e) {
				$this->error = $e->getMessage();
				echo $this->error;
			}
		}
		// Prepare Statements with query
		public function query($sql){
			$this->stmt = $this->dbh->prepare($sql);
		}

		// Bind Values
		public function bind($param,$value,$type = null)
		{
			if (is_null($type)) {
				switch (true) {
					
					case is_int($value):
						$type = PDO::PARAM_INT;
						//echo "{$type} INT";
						break;
					case is_float($value):
						$type = PDO::PARAM_FLOAT;
						//echo "{$type} float";
						break;
					case is_bool($value):
						$type = PDO::PARAM_BOOL;
						//echo "{$type} BOOL";
						break;
					case is_null($value):
						$type = PDO::PARAM_NULL;
						//echo "{$type} NULL";
						break;
					default:
						$type = PDO::PARAM_STR;
						//echo "{$type} str";
						break;
				}
			}
			$this->stmt->bindValue($param,$value,$type);

		}

		//Execute The Prepared Statement
		public function execute()
		{
			return $this->stmt->execute();
		}

		// Get Result set as array of objects 
		public function resultSet()
		{
			$this->execute();
			return $this->stmt->fetchAll(PDO::FETCH_OBJ);
		}

		// Get Single Record as Object
		public function single()
		{
			$this->execute();
			return $this->stmt->fetch(PDO::FETCH_OBJ);	
		}

		// Get Row Count
		public function rowCount()
		{
			return $this->stmt->rowCount();
		}
		public function close()
		{
			$this->dbh->close();
		}
	}
?>
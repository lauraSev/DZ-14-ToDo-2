<?php
	session_start();
	class Login {
		private $dbh = false;
		public function __construct(){
			include ('connect.php');
			$this->dbh = $dbh;
			$dbh->query ("CREATE TABLE IF NOT EXISTS `users`(
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `login` text NOT NULL,
			  `pas` text NOT NULL,
			  `name` text NOT NULL,
			  `s_name` text NOT NULL,
			  `email` text NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
			print_r($dbh->errorInfo());
		}
		
		
		
		public function registratsiya ($login, $pas, $name, $s_name, $email ){
			$query = "INSERT INTO users SET 
				login = '$login',
				pas = '$pas',
				name = '$name',
				s_name = '$s_name',
				email = '$email'
			";	
			$this->dbh->query ($query);
			$error = $this->dbh->errorInfo();
			print_r ($error);
			if ($error[0] == '00000')
			return true;
			else return false;
			
		}
		

		public function avtorizatsiya ($login, $pas){
			$query ="SELECT login, name, s_name,id FROM users WHERE login = '$login' AND pas = '$pas'";
			$res = $this->dbh->query ($query);
			$error = $this->dbh->errorInfo();
			print_r ($error);
			print_r ($res);
			foreach ($res as $row){
				$_SESSION['user']=$row;
				return true;
			}
			return false;
		}
		
		public function user_exit (){
			unset($_SESSION['user']);
				return true;
			}
			
		
		function getUserId() {
			return $_SESSION['user'] ['id'];
		}
		
		function getAllUsers() {
			$query ="SELECT * FROM users";
			return $this->dbh->query ($query);		
		}
		function getUserName() {
			return $_SESSION['user']['name'];
		}
	}
	
?>

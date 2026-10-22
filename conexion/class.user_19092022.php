<?php
class USER
{
	private $db;
	
	function __construct($DB_con)
	{
		$this->db = $DB_con;
	}
	
	/*public function register($fname,$lname,$uname,$umail,$upass)
	{
		try
		{
			$new_password = MD5($upass);
			
			$stmt = $this->db->prepare("INSERT INTO users(user_name,user_email,user_pass) 
		                                               VALUES(:uname, :umail, :upass)");
												  
			$stmt->bindparam(":uname", $uname);
			$stmt->bindparam(":umail", $umail);
			$stmt->bindparam(":upass", $new_password);										  
				
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}*/


	
	public function login($uname,$upass)
	{
		return true;

		session_start();
		
		$username = mysqli_real_escape_string($db,htmlentities(strtolower($uname),ENT_QUOTES,'UTF -8'));
		$password = mysqli_real_escape_string($db,htmlentities(md5(strtolower($upass)),ENT_QUOTES,'UTF -8'));

		$result = mysqli_query($db,"SELECT ID_USUARIO,NOMBRE,USUARIO FROM usuario WHERE USUARIO='$username' and PASS='$password'");
		$count = mysqli_num_rows($result);

		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

		if($count == 1) {
			$_SESSION['login_user'] = $row['ID_USUARIO'];
			$_SESSION['nombre_user'] = $row['NOMBRE'];
			$_SESSION['user'] = $row['USUARIO'];
			//echo $row['ID_USUARIO'];
			//header("Location: ../cotizar/index.php");
			return true;
		}
		else{
			return false;
		}

		/*try
		{*/
		
 
				/*$user= mysqli_real_escape_string($db,htmlentities(strtolower($uname),ENT_QUOTES,'UTF -8'));
				$pass= mysqli_real_escape_string($db,htmlentities(md5(strtolower($upass)),ENT_QUOTES,'UTF -8'));

			     $query = "SELECT * FROM usuario WHERE USUARIO='$user'"; 

			     $result = $db->query($query);

			     $row  = mysqli_fetch_array($result );


			     $row_cnt = mysqli_num_rows($result);

			     if ($row_cnt > 0) {
			       
			        if($row['PASS'] == ($pass)){


			           $_SESSION['usuario']=$row['user'];
			           $_SESSION['iduser']=$row['id'];

			           return true;

			        }else{

			           return false;

			          }


			     }

			/*$stmt = $this->db->prepare("SELECT * FROM USUARIO WHERE USUARIO=:uname  LIMIT 1");
			$stmt->execute(array(':uname'=>$uname));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() > 0)
			{
				if($userRow['PASS']==MD5($upass))
				{
					$_SESSION['user_session'] = $userRow['ID_USUARIO'];
					return true;
				}
				else
				{
					return false;
				}
			}*/
		
		/*}
		
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}*/
	}
	
	/*public function is_loggedin()
	{
		if(isset($_SESSION['user_session']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function logout()
	{
		session_destroy();
		unset($_SESSION['user_session']);
		return true;
	}*/
}
?>
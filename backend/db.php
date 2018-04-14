<?php

class DB extends PDO
{	
	var $m_DB;
	var $m_Debug;
	
	function __construct(array $p_DriverOptions=array(), $p_Host=DB_HOST, $p_Name=DB_NAME, $p_User=DB_USER, $p_Password=DB_PASSWORD)
	{
		try{
			//var_dump('mysql:host=' . db_host . ';dbname=' . db_name);
			parent::__construct('mysql:host=' . $p_Host . ';dbname=' . $p_Name, $p_User, $p_Password, $p_DriverOptions);
		} catch(PDOExection $e){
			//Log::advLog(array('PDOMysql error: ' . $e->getMessage()));
			echo 'Error: ' . $e->getMessage() . '<br/>';
			die();
		}
		//$this->m_DB=mysql_connect(db_host, db_user, db_password);
	}
	
	function __destruct(){
		$this->m_DB=null;
	}
	
	function __get($p_Key)
	{
		if($p_Key==='db')
		{
			return $this->m_DB;
		}
	}
}

?>
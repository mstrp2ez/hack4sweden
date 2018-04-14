<?php

include_once('db.php');
include_once('config.php');
include_once('common.php');

class PDOMysqlQuery
{
	static private $m_DB=null;
	static private $m_Query='';
	static private $m_Statement=false;
	static private function Query(){
		if(self::$m_DB===null){
			self::$m_DB=new DB(array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::MYSQL_ATTR_LOCAL_INFILE => true));
		}
		return self::$m_DB;
	}
	static function GetMysqlError(){
		return self::$m_DB->errorInfo();
	}
	static function GetQuery(){
		return self::$m_Statement->queryString;
	}
	static public function Prepared($p_Query, array $p_Params){
		$db=self::Query();
		self::$m_Statement=$db->prepare($p_Query);
		return self::$m_Statement->execute($p_Params);
	}
	static public function PreparedQueryParams(QueryParameters $p_Query){
		return self::Prepared($p_Query->Query(),$p_Query->Vars());
	}
	static public function FetchAll($p_FetchStyle=PDO::FETCH_ASSOC, $p_FetchFunc=null){
		if(self::$m_Statement===false){
			return false;
		}
		$out=null;
		if($p_FetchFunc==null){
			$out=self::$m_Statement->fetchAll($p_FetchStyle);
		}else{
			$out=self::$m_Statement->fetchAll($p_FetchStyle, $p_FetchFunc);
		}
		return (count($out)>0)?$out:false;
	}
	static public function LastInsertID(){
		return self::$m_DB->lastInsertID();
	}
}

class QueryParameters{
	private $m_Query;
	private $m_Vars;
	public function __construct($p_Query,$p_Vars){
		$this->m_Query=$p_Query;
		$this->m_Vars=$p_Vars;
	}
	public function Query(){
		return $this->m_Query;
	}
	public function Vars(){
		return $this->m_Vars;
	}
}

?>
<?php


define('PROJECT_NAME','');

define('PROJECT_ROOT','http://' . $_SERVER['SERVER_NAME'] . '/' . PROJECT_NAME );


define('IMAGE_DIR', PROJECT_ROOT . 'assets' . '/');
define('IMAGE_DIR_THUMBS', PROJECT_ROOT . '/upload/thumbnail');

define('JS_DIR', PROJECT_ROOT . 'js' . '/');
define('PAGE_DIR', PROJECT_ROOT . 'pages' . '/');
define('CSS_DIR', PROJECT_ROOT . 'css' . '/');

function base_redirect(){
	if(strpos($_SERVER['PHP_SELF'], 'index.php')===false){	
		header('Location: ' . 'http://' . $_SERVER['SERVER_ADDR'] . '/' . PROJECT_NAME);
	}
}

function silent_file_get_contents($p_Url, $p_Context)
{
	$headers=get_headers($p_Url);
	$code=substr($headers[0], 9, 3);
	
	if($code!='404')
	{
		return file_get_contents($p_Url, false, $p_Context);
	}
	return false;
}

function nextPowerOf2($p_N)
{
	$n=$p_N;

	$n--;
	$n |= $n >> 1;   
	$n |= $n >> 2;   
	$n |= $n >> 4;
	$n |= $n >> 8;
	$n |= $n >> 16;
	$n++;       

	return $n;    
}

function json_encodeUU($data)
{
	return preg_replace_callback('/\\\u(\w\w\w\w)/', 
    function($matches)
    {
        return '&#'.hexdec($matches[1]).';';
    }
    , json_encode($data));
}
function array2CVSAttachment($p_Labels,$p_Data,$p_Filename){
	header('Content-type: text/cvs');
	header('Content-Disposition: attachment;filename='.$p_Filename);
	
	$fp=fopen('php://output','w');
	
	fputcsv($fp,$p_Labels);
	foreach($p_Data as $item){
		fputcsv($fp,$item);
	}
	
	fclose($fp);
}
function array2CVS($p_Labels,$p_Data,$p_Filename){
	$filePath='tmp/'.$p_Filename;
	$fp=fopen($filePath,'w');
	
	if($fp===false){throw new Exception('Could not open file: tmp/'.$p_Filename);}
	fputcsv($fp,$p_Labels);
	foreach($p_Data as $item){
		fputcsv($fp,$item);
	}
	fclose($fp);
	return $filePath;
}
function errorRedirect($p_Loc)
{
	header('Location: ' . $p_Loc);
}
function buildJsonError($p_Reason){
	return array('result'=>0,'reason'=>$p_Reason);
}
function getClassName($p_Obj){
	$classname=get_class($p_Obj);
	if(preg_match('@\\\\([\w]+)$@',$classname,$matches)){
		$classname=$matches[1];
	}
	
	return $classname;
}
function forceHTTPS(){
	if($_SERVER["HTTPS"] != "on"){
		header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
		exit();
	}
}
function str_replace_first($haystack,$needle){
	$pos=strpos($haystack,$needle);
	$ret=$haystack;
	if($pos !== false){
		$ret=substr_replace($haystack,$needle,$pos,strlen($haystack));
	}
	return $ret;
}
?>
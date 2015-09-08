<?
	$number_news_on_page=10;				
	$number_materials_on_page=20;			
	$number_msg_on_page=10;					
	$time_add_msg=10;						//интервал добавления сообщений в гостевую (в секундах)
	$pass_admin="Lgtu4Ever)";				
	$name_admin="admin";					
	$max_file_size=10*1024*1024;			
	$timeedit=2; 							//время, в течении которого можно редактировать записи
	//include('db_connect_server.php');
	include('db_connect_local.php');
	
	session_start();
	if($_SESSION['password']=="$pass_admin" && $_SESSION['user']=="$name_admin")
	{
		$check=true;
	}
    
	function unxss($info)
	{
		$info = strip_tags($info, '<p><h1><span><em><strong><sup><sub><img><hr><adress><pre><h1><h2><h3><h4><h5<h6><ul><li><ol><a>');
		$info = strip_tags($info, '<p><h1><span><em><strong><sup><sub><img><hr><adress><pre><h1><h2><h3><h4><h5<h6><ul><li><ol><a>');
		$info = preg_replace("#<script(.+?)/script>#is",'',$info);
   		$info = preg_replace("#(href|src)=([\"|\']{0,1})(\s*)javascript:(.+?)\\2#is",'',$info);
    	$info = preg_replace("#(onclick|onchange|onchangefiltr|onmouseover|onmouseout|onmousedown|onmouseup|onselect|onfocus|onblur|onload|onkeydown|onkeyup|ondblclick|onunload|onmouseup|onsubmit)=([\"|\']{0,1})(.+?)\\2#is",'',$info);
		return $info;
	}
    
	function _filter( $var , $sql = 0) 
	{
	 
		$var = strip_tags($var);
		$var=str_replace ("\n"," ", $var);
		$var=str_replace ("\r","", $var);
		$var=trim($var);
		//$var = htmlentities($var);
		if ( $sql == 1) 
		{ 
			$var = mysql_real_escape_string($var);
		}
		return $var;
	}
?>
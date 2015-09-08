<?
	$dblocation='localhost';
	$dbname='obmennik_lgtu';
	$dbuser='root';
	$dbpassword='';
	
	$dbconnect=mysql_connect($dblocation,$dbuser,$dbpassword);
	mysql_select_db($dbname,$dbconnect);
    mysql_query("SET names 'cp1251' COLLATE 'cp1251_general_ci'");
	if(!$dbconnect){echo('<p>Не удалось подключиться к базе данных</p>');}
?>
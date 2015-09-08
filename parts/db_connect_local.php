<?
	$dblocation='localhost';
	$dbname='student48';
	$dbuser='root';
	$dbpassword='positron48rus';
	
	$dbconnect=mysql_connect($dblocation,$dbuser,$dbpassword);
	mysql_select_db($dbname,$dbconnect);
    mysql_query("SET names 'utf8' COLLATE 'utf8_general_ci'");
	if(!$dbconnect){echo('<p>Не удалось подключиться к базе данных</p>');}
?>
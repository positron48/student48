<?
	$dblocation='localhost';
	$dbname='obmennik_lgtu';
	$dbuser='obmennik_lgtu';
	$dbpassword='elXmI(rh2;r!';
	
	$dbconnect=mysql_connect($dblocation,$dbuser,$dbpassword);
	mysql_select_db($dbname,$dbconnect);
	if(!$dbconnect){echo('<p>Не удалось подключиться к базе данных</p>');}
?>
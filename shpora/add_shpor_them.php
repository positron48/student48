<?
	include('../parts/settings.php');
	$dbdata_predmets=mysql_query("SELECT * FROM predmets ORDER BY semestr ASC, title_predmet ASC", $dbconnect);
	$predmets=mysql_fetch_array($dbdata_predmets);
	$add=false;
	if(isset($_POST['title']) && $check)
	{
		$title=_filter($_POST['title']);
		$predmet=_filter($_POST['predmet']);
		$date=date("Y-m-d H:i:s"); 
		$query="INSERT INTO shpora_themes VALUES(NULL, '$title', '$date', 0, '$predmet')";
		setcookie(md5($title.$date),'true',time()+3600*$timeedit);
		header("location: http://student48.ru/shpora/index.php");
		$add=true;
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ | Добавить тему</title>
<? include('../parts/head.php'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head>
<body>

 
	<? include("../parts/top.php"); ?>
    <? include('../parts/header.php'); ?>
    <div class="container">
        <? if($check && !$add):?>
     		<p><h1>Добавьте новость:</h1>
            <form name="addnews" method="post" action="add_shpor_them.php">
            	<table class="form">
                <tr>
                    <td>Заголовок:</td><td><input type="text" name="title" size="83"></td>
                </tr><tr>
                	<td>Предмет:</td><td><input type="text" name="predmet" size="83"></td>
                </tr>
                <tr><td colspan="2"> 
                    <input type="submit" value="Отправить" class="btn" />
                </td></tr>
                </table>
        	</form>
        <? elseif($check && $add):?>
        	<?
    			$result=mysql_query($query);
    			mysql_close($dbconnect);
    			if(!$result)
    				printf("<p clas='alert alert-error'>Ошибка при записи в базу данных</p>");
    			else
    				printf("<p clas='alert alert-succes'>Тема добавлена!</p>");
    		?>
        <? else: ?>
        	<p clas='alert alert-danger'>У вас недостаточно прав для добавления темы</p>
        <? endif ?>
    
        <? include('../parts/footer.php'); ?>
    
    </div>

</body>
</html>
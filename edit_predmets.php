<?
	include('parts/settings.php');
	if(isset($_POST['title_predmet']) && $check)
	{
		$id=$_POST['id'];
			$title_predmet=$_POST['title_predmet'];
			$title_predmet_english=$_POST['title_predmet_english'];
			$semestr=$_POST['semestr'];
			if($semestr<11 && $semestr>0)
			{
				$query="UPDATE predmets SET title_predmet='$title_predmet', title_predmet_english='$title_predmet_english', semestr='$semestr' WHERE id='$id'";
			}
			else
			{
				$query="UPDATE predmets SET title_predmet='$title_predmet', title_predmet_english='$title_predmet_english' WHERE id='$id'";
			}	
			$edit=true;
	}
	elseif(isset($_GET['id']) && $check)
	{
		$id=$_GET['id'];
		$dbdata=mysql_query("SELECT * FROM predmets WHERE id='$id'", $dbconnect);
		$pagedata=mysql_fetch_array($dbdata);
	}
	else
	{
		$dbdata=mysql_query('SELECT * FROM predmets ORDER BY semestr ASC, title_predmet ASC', $dbconnect);
		$pagedata=mysql_fetch_array($dbdata);
	}
	
?>
<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ|Редактирование предметов</title>
<? include('parts/head.php'); ?>
</head>
<body>

 
	<? include("parts/top.php"); ?>
    
    	
        	<? include('parts/header.php'); ?>
        <div class="container">
                       <?
							if($edit)
							{
								$result=mysql_query($query);
								mysql_close($dbconnect);
								if(!$result)
								{
									printf("<p class='alert alert-error'>Ошибка при записи в базу данных");							
								}
								else
								{
									printf("<p class='alert alert-success'>Предмет отредактирован!");
								}
							}	
							elseif($check && isset($id))
							{
								printf('
								<form name="addnews" method="post" action="edit_predmets.php?id=%s">
									<table class="form">
									<tr><td>id:</td><td><input type="text" name="id" size="83" value="%s" readonly></td>
									<tr><td>Название:</td><td><input type="text" name="title_predmet" size="83" value="%s"></td>
									<tr><td>Английское название:</td><td><input type="text" name="title_predmet_english" size="83" value="%s"></td>
									<tr><td>Семестр (1-10):</td><td><input type="text" name="semestr" size="83" value="%s"></td>
									</tr><tr><td colspan="2"><input type="submit" value="Отправить" class="btn"><input type="reset" value="Очистить" class="btn">
									</td></tr>
									</table>
								</form>
								',$pagedata['id'],$pagedata['id'],$pagedata['title_predmet'],$pagedata['title_predmet_english'],$pagedata['semestr']);
							}
							elseif($check)
							{
								echo("<p><h1>Предметы:</h1><br>");
								echo('<table class="table table-striped table-bordered table-condensed">
									<thead><tr>
									<td><i class="icon-time"></i></td>
									<td>Предмет</td>
									<td>Англ. название</td>
									<td><i class="icon-edit"></i></td>
                                    <td><i class="icon-remove"></i></td></tr></thead>');
								do
								{
									printf('<tr>
										<td>%s</td>
										<td>%s</td>
										<td>%s</td>
										<td><a href="edit_predmets.php?id=%s"><i class="icon-edit"></i></a></td>
										<td><a href="delete_predmets.php?id=%s"><i class="icon-remove"></i></a></td>'
										,$pagedata['semestr'],$pagedata['title_predmet'],$pagedata['title_predmet_english'],$pagedata['id'],$pagedata['id']);
								}while($pagedata=mysql_fetch_array($dbdata));
								echo('</table>');
							}
							
							else
							 	print("<p class='alert alert-danger'>У вас недостаточно прав для редактирования предметов</p>");
						?>

    		<? include('parts/footer.php'); ?>

    
</div>

</body>
</html>
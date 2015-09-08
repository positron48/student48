<?
	include('parts/settings.php');
	if(isset($_GET['id']))
	{
		$date=date("Y-m-d H:i:s "); 
		$id=$_GET['id'];
		$dbdata=mysql_query("SELECT * FROM materials WHERE id='$id'", $dbconnect);
		$dbdata1=mysql_query("SELECT * FROM predmets ORDER BY semestr ASC, title_predmet ASC",$dbconnect);
		$pagedata1=mysql_fetch_array($dbdata1);
	}
	else
	{
		$dbdata=mysql_query("SELECT materials.id, title_material, metakey, predmetid, link, filesize, downloads, dateadd, title_predmet, semestr FROM materials, predmets WHERE materials.predmetid=predmets.id ORDER BY predmets.semestr ASC, title_predmet ASC, title_material ASC", $dbconnect);
	}
	$pagedata=mysql_fetch_array($dbdata);

	if(isset($_POST['id']) && $check)
	{
		$id=$_POST['id'];
		$title_material=$_POST['title_material'];
		$metakey=$_POST['metakey'];
		$predmetid=$_POST['predmetid'];
		$link=$_POST['link'];
		$filesize=$_POST['filesize'];
		$downloads=$_POST['downloads'];
		$dateadd=$_POST['dateadd']; 
		$query="UPDATE materials SET title_material='$title_material', metakey='$metakey', predmetid='$predmetid', link='$link', filesize='$filesize', downloads='$downloads', dateadd='$dateadd' WHERE id='$id'";
		$edit=true;
		//print('<script> alert("Материал отредактирован") </script>');
		header("Location: materials.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ|Редактирование материалов</title>
<? include('parts/head.php'); ?>
</head>
<body>

 
	<? include("parts/top.php"); ?>
    <? include('parts/header.php'); ?>
    <div class="container">
   <?
		if(isset($_GET['id']) && $check && !$edit)
		{
			printf('
			<form name="addnews" method="post" action="edit_materials.php">
				<table class="form">
				<tr><td>id:</td><td><input type="text" name="id" size="83" value="%s" readonly></td>
				<tr><td>Скачиваний:</td><td><input type="text" name="downloads" size="83" value="%s"></td>
				<tr><td>Дата добавления:</td><td><input type="text" name="dateadd" size="83" value="%s" readonly></td>
				<tr><td>Заголовок:</td><td><input type="text" name="title_material" size="83" value="%s"></td>
				</tr><tr><td>Ключевые слова:</td><td><input type="text" name="metakey" size="83" value="%s"></td>
				</tr><tr><td>Ссылка на файл:</td><td><input type="text" name="link" size="83" value="%s"></td>
				</tr><tr><td>Размер файла (Кб):</td><td><input type="text" name="filesize" size="83" value="%s"></td>
				</tr><tr><td>id предмета:</td><td><input type="text" name="predmetid" size="83" value="%s"></td>
				</tr><tr><td>Предмет:</td><td><select multiple disabled>',$pagedata['id'],$pagedata['downloads'],$pagedata['dateadd'],$pagedata['title_material'],$pagedata['metakey'],$pagedata['link'],$pagedata['filesize'],$pagedata['predmetid']);
				do
				{
					printf('<option>id#%s  semestr %s: %s</option>',$pagedata1['id'],$pagedata1['semestr'],$pagedata1['title_predmet']);
				}while($pagedata1=mysql_fetch_array($dbdata1));
			printf('</select></td>
				</tr><tr><td colspan="2"><input type="submit" value="Отправить"><input type="reset" value="Очистить">
				</td></tr>
				</table>
			</form>
			',$pagedata['title_news'],$pagedata['datecreate'],$pagedata['views'],$pagedata['fulltext']);
		}
		elseif($check && $edit)
		{
			$result=mysql_query($query);
			mysql_close($dbconnect);
			if(!$result)
			{
				printf("<p class='alert alert-error'>Ошибка при записи в базу данных</p>");							
			}
			else
			{
				printf("<p class='alert alert-success'>Материал отредактирован!</p>");
				$edit_result=true;
			}
		}
		else
			print("<p class='alert alert-danger'>У вас недостаточно прав для редактирования данного материала</p>");
	?>
    
    <? include('parts/footer.php'); ?>
   
</div>

</body>
</html>

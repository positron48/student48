<?
	include('parts/settings.php');

	$handle = mysql_query("SELECT COUNT(*) FROM news", $dbconnect);
	$number_news  = mysql_fetch_array($handle);
	if(isset($_POST['title_news']) && $check)
	{
		$id=$_POST['id'];
		$title_news=$_POST['title_news'];
		$introtext=unxss($_POST['introtext']);
		$fullcontent=unxss($_POST['fullcontent']);
		$metakey=$_POST['metakey'];
		$datecreate=$_POST['datecreate'];
		$dateupdate=$_POST['dateupdate'];
		$dateview=$_POST['dateview'];
		$views=$_POST['views'];
		$query="UPDATE news SET title_news='$title_news', introtext='$introtext', fullcontent='$fullcontent', metakey='$metakey', datecreate='$datecreate', dateupdate='$dateupdate', dateview='$dateview', views='$views' WHERE id='$id'";
		$edit=true;
	}
	elseif(isset($_GET['id']) && $check)
	{
		$date=date("Y-m-d H:i:s "); 
		$id=$_GET['id'];
		$dbdata=mysql_query("SELECT * FROM news WHERE id='$id'", $dbconnect);
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ|Редактирование новостей</title>
<? include('parts/head.php'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head>
<body>
<script type="text/javascript">
	tinyMCE.init({
		mode:"textareas",
		theme:"advanced",
		plugins:"autoresize, advimage, autolink, lists, spellchecker, pagebreak, style, layer, table, save, advhr, advimage, advlink, emotions, iespell, inlinepopups, insertdatetime, preview, media, searchreplace, print, contextmenu, paste, directionality, fullscreen, noneditable, visualchars, nonbreaking, xhtmlxtras, template",
		language:"ru",
		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect,|,forecolor,|,fullscreen",
		theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,undo,redo,|,link,unlink,image,code,|,preview,|,sub,sup,|,charmap,emotions,advhr",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,					
		// Skin options
		skin : "o2k7",
		//skin_variant : "silver",
		// Example content CSS (should be your site CSS)
		content_css : "css/example.css",
	});
</script>
 
	<? include("parts/top.php"); ?>
    <? include('parts/header.php'); ?>
    <div class="container">
	
   <?
		if(isset($_GET['id']) && $check && !$edit)
		{
			$pagedata=mysql_fetch_array($dbdata);
			printf('
			<form name="addnews" method="post" action="edit_news.php?id=%s">
				<table class="table">
				<tr><td>id:</td><td><input type="text" name="id" size="160" value="%s" readonly /></td>
				<tr><td>Заголовок:</td><td><input type="text" name="title_news" size="160" value="%s"></td>
				</tr><tr><td>Краткое содержание:</td><td><textarea cols="100" rows="8" name="introtext">%s</textarea></td>
				</tr><tr><td>Полное содержание:</td><td><textarea cols="100" rows="8" name="fullcontent">%s</textarea></td>
				<tr><td>Ключевые слова:</td><td><input type="text" name="metakey" size="160" value="%s"></td>
				<tr><td>Дата создания:</td><td><input type="text" name="datecreate" size="160" value="%s" readonly></td>
				<tr><td>Дата редактирования:</td><td><input type="text" name="dateupdate" size="160" value="%s" readonly></td>
				<tr><td>Дата просмотра:</td><td><input type="text" name="dateview" size="160" value="%s" readonly></td>
				<tr><td>Просмотров:</td><td><input type="text" name="views" size="160" value="%s"></td>
				</tr><tr><td colspan="2"><input type="submit" class="btn" value="Отправить"><input type="reset" class="btn" value="Очистить">
				</td></tr>
				</table>
			</form>
			',$pagedata['id'],$pagedata['id'],$pagedata['title_news'],$pagedata['introtext'],$pagedata['fullcontent'],$pagedata['metakey'],$pagedata['datecreate'],$pagedata['dateupdate'],$pagedata['dateview'],$pagedata['views']);
		}
		elseif($edit)
		{
			$result=mysql_query($query);
			if($result)
				$result1=mysql_query("UPDATE news SET dateupdate='$date' WHERE id='$id'");
			mysql_close($dbconnect);
			if(!$result)
			{
				printf("<p class='alert alert-error'>Ошибка при записи в базу данных</p>");							
			}
			else
			{
				printf("<p class='alert alert-success'>Новость отредактирована!</p>");
			}
		}
		else
			print("<p class='alert alert-danger'>У вас недостаточно прав для редактирования данной новости</p>");
	?>
    
    <? include('parts/footer.php'); ?>

</div>

</body>
</html>
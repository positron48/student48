<?
	include('parts/settings.php');
	if(isset($_POST['title']) && $check)
	{
		$title=$_POST['title'];
		$metakey=$_POST['metakey'];
		$introtext=unxss($_POST['introtext']);
		$fullcontent=unxss($_POST['fullcontent']);
		$date=date("Y-m-d H:i:s "); 
		$query="INSERT INTO news VALUES(NULL,'$title','$introtext','$fullcontent','$metakey','$date','$date','$date',1)";
		$add=true;
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ|Добавление новости</title>

<? include('parts/head.php'); ?>

</head>
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
		theme_advanced_resizing : true,					
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
                <? if(!$add && $check):?>
             		<p><h1>Добавьте новость:</h1>
                    <form name="addnews" method="post" action="addnews.php">
                    	<table>
                        <tr>
                            <td>Заголовок:</td><td><input type="text" name="title" size="83"></td>
                        </tr><tr>
                            <td>Ключевые слова:</td><td><input type="text" name="metakey" size="83"></td>
                        </tr><tr>
                            <td>Краткий текст:</td><td><textarea cols="64" rows="5" name="introtext"></textarea></td>
                       	</tr><tr>
                            <td>Полный текст:</td><td><textarea cols="64" rows="5" name="fullcontent"></textarea></td>
                        </tr>
                        <tr><td colspan="2"> <br />
                            <input type="submit" value="Отправить" class="btn"><input type="reset" class="btn" value="Очистить">
                        </td></tr>
                        </table>
                	</form>
                <? elseif($check && $add):?>
                	<?
						$result=mysql_query($query);
						mysql_close($dbconnect);
						if(!$result)
							printf("<p>Ошибка при записи в базу данных");
						else
							printf("<p><center>Новость добавлена!</center>");
					?>
                <? else: ?>
                	<br><div class="alert alert-danger"><center>У вас недостаточно прав для добавления новости</center></div>
                <? endif ?>
    		<? include('parts/footer.php'); ?>
     </div>    


</body>
</html>
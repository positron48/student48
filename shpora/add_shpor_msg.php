<?
	include('../parts/settings.php');
	$dbdata_predmets=mysql_query("SELECT * FROM predmets ORDER BY semestr ASC, title_predmet ASC", $dbconnect);
	$predmets=mysql_fetch_array($dbdata_predmets);
	if(is_numeric($_GET['id']))
	{
		$db=mysql_query("SELECT * FROM shpora_themes WHERE shp_them_id='".$_GET['id']."'", $dbconnect);
		$pgdata=mysql_fetch_array($db);
	}
	if(isset($_POST['title']) && ($check || ($_COOKIE[md5($pgdata['shp_them_title'].$pgdata['shp_them_date'])]==true)) && is_numeric($_GET['id']) && is_numeric($_GET['id']))
	{
		$add=true;
		if(_filter($_POST['title'])!="")
			$title=_filter($_POST['title']);
		else
			$add=false;
		$themid=_filter($_GET['id']);
		$date=date("Y-m-d H:i:s"); 
		
		if(trim($_POST['content'])!="")
		{
			$content=$_POST['content'];
			$content=unxss($content);
		}
		else
			$add=false;
		if($add)
		{
			$query="INSERT INTO shpora_messages VALUES(NULL, '$themid', '$date', '$title', '$content',0)";
			$result=mysql_query($query);
			if(result)
				header("location: http://student48.ru/shpora/themes.php?id=".$_GET['id']);
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ | Добавить сообщение</title>
<? include('../parts/head.php'); ?>
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
		theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,undo,redo,|,link,unlink,image,code,|,preview,|,sub,sup,|,charmap,emotions,media,advhr",
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
 
	<? include("../parts/top.php"); ?>
    <? include('../parts/header.php'); ?>
    <div class="container">
   	<? if(!$add && ($check || ($_COOKIE[md5($pgdata['shp_them_title'].$pgdata['shp_them_date'])]==true))):?>
 		<p><h1>Добавьте новость:</h1>
        <form name="addmsg" method="post" action="add_shpor_msg.php?id=<? printf("%s",$_GET['id']); ?>">
        	<table class="form">
            <tr>
                <td>Заголовок:</td><td><input type="text" name="title" size="83" <? if($_POST['title']!="") printf('value="%s"',$_POST['title']) ?>></td>
            </tr><tr>
            	<td>Содержание:</td>
                <td>
                	<textarea cols="64" rows="5" name="content"><? if($_POST['content']!="") printf('%s',$_POST['content']) ?></textarea>
                </td>
            </tr>
            <tr><td colspan="2"> 
                <input type="submit" class="btn" value="Отправить">
            </td></tr>
            </table>
    	</form>
    <? elseif(($check || ($_COOKIE[md5($pgdata['shp_them_title'].$pgdata['shp_them_date'])]==true)) && $add):?>
    	<?
			if(!$result)
				printf("<p class='alert alert-error'>Ошибка при записи в базу данных</p>");
			else
				printf("<p class='alert alert-success'>Сообщение добавлено!</p>");
		?>
    <? else: ?>
    	<br><p class='alert alert-danger'>У вас недостаточно прав для добавления темы</p>
    <? endif ?>
              
	<? include('../parts/footer.php'); ?>
        
</div>

</body>
</html>
<?
	include('../parts/settings.php');
	if(is_numeric($_GET['id']))
	{
		$id=$_GET['id'];
		$dbdata1=mysql_query("SELECT * FROM shpora_themes WHERE shp_them_id='$id'");
		$themdata=mysql_fetch_array($dbdata1);
	}
	if(is_numeric($_GET['del_id']))
	{
		if($check || ($_COOKIE[md5($themdata['shp_them_title'].$themdata['shp_them_date'])]==true))
		{
			$resultdelmsg=mysql_query("DELETE FROM shpora_messages WHERE shp_msg_id='".$_GET['del_id']."' LIMIT 1", $dbconnect);
		}
	}
	if(is_numeric($_GET['edit_id']))
	{
		$edit_id=$_GET['edit_id'];
		if($check || ($_COOKIE[md5($themdata['shp_them_title'].$themdata['shp_them_date'])]==true))
		{
			$dbmsg=mysql_query("SELECT * FROM shpora_messages WHERE shp_msg_them_id='".$id."' AND shp_msg_id='".$_GET['edit_id']."' LIMIT 1", $dbconnect);
			$msgdata=mysql_fetch_array($dbmsg);
		}
		if(isset($_POST['msgtitle']))
		{
			$msgtitle=_filter($_POST['msgtitle']);
			$msgcontent=unxss($_POST['msgcontent']);
			if($msgtitle!="" && $msgcontent!="")
				$resulteditmsg=mysql_query("UPDATE shpora_messages SET shp_msg_title='$msgtitle', shp_msg_content='$msgcontent' WHERE shp_msg_them_id='$id' AND shp_msg_id='$edit_id'", $dbconnect);
			if($resulteditmsg)
				header("location: http://student48.ru/shpora/themes.php?id=".$id);
		}
	}
	$query="SELECT * FROM shpora_messages WHERE shp_msg_them_id='$id' ORDER BY shpora_messages.shp_msg_title+0 ASC ";
	$dbdata=mysql_query($query, $dbconnect);
	
?>

<html>
<head>
<title>ЛГТУ | Темы</title>

<? include('../parts/head.php'); ?>

<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"></head>
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
<div id="outer" align="center"> 
	<? include("../parts/top.php"); ?>
    <div id="inner" align="left">
    	<div id="header">
        	<? include('../parts/header.php'); ?>

        </div>
        <table cellpadding="0" cellspacing="0">
            <tr>
            	<td id="left">
                	<? include('../parts/left.php'); ?>
                </td>
                <td id="main">
                	<h1>Шпора!</h1>
					<?
						if(is_numeric($_GET['del_id']) && ($check || ($_COOKIE[md5($themdata['shp_them_title'].$themdata['shp_them_date'])]==true)))
							if($resultdelmsg)
								print('<h3>Шпора удалена!</h3>');
							else
								print('<h3>Ошибка удаления</h3>');
						if(is_numeric($_GET['edit_id']) && ($check || ($_COOKIE[md5($themdata['shp_them_title'].$themdata['shp_them_date'])]==true)) && ($_GET['id']==$themdata['shp_them_id']))
						{
							if(!isset($msgtitle))
								printf('<form name="editmsg" method="post" action="themes.php?id=%s&edit_id=%s">
										<table class="form">
										<tr>
											<td>Заголовок:</td><td><input type="text" name="msgtitle" size="83" value="%s"></td>
										</tr><tr>
											<td>Содержание:</td>
											<td>
												<textarea cols="64" rows="5" name="msgcontent">%s</textarea>
											</td>
										</tr>
										<tr><td colspan="2"> 
											<input type="submit" value="Отправить">
										</td></tr>
										</table>
									</form>'
									,$id,$_GET['edit_id'],$msgdata['shp_msg_title'],$msgdata['shp_msg_content']);
							else
								printf('<form name="editmsg" method="post" action="themes.php?id=%s&edit_id=%s">
										<table class="form">
										<tr>
											<td>Заголовок:</td><td><input type="text" name="msgtitle" size="83" value="%s"></td>
										</tr><tr>
											<td>Содержание:</td>
											<td>
												<textarea cols="64" rows="5" name="msgcontent">%s</textarea>
											</td>
										</tr>
										<tr><td colspan="2"> 
											<input type="submit" value="Отправить">
										</td></tr>
										</table>
									</form>'
									,$id,$_GET['edit_id'],$msgtitle,stripslashes($_POST['msgcontent']));
						}
						else
						{
							printf('<h2><a href="index.php">Вернуться к списку тем</a></h2>');
							if($check || ($_COOKIE[md5($themdata['shp_them_title'].$themdata['shp_them_date'])]==true))
							{
								printf("<a href='add_shpor_msg.php?id=%s'>Добавить сообщение в тему</a>",$id);
							}
							$views=$themdata['shp_them_views']+1;
							mysql_query("UPDATE shpora_themes SET shp_them_views='$views' WHERE shp_them_id='$id'");
							print('<table class="shpora_themes">');
							while($pagedata=mysql_fetch_array($dbdata))
							{
								printf('<tr>
											<td class="shp_tr">');
								if(($_COOKIE[md5($themdata['shp_them_title'].$themdata['shp_them_date'])]==true) || $check)
									printf('
												<a href="themes.php?id=%s&edit_id=%s"><img src="../images/icon_edit.gif"></a>
												<a href="themes.php?id=%s&del_id=%s" onclick="if(!confirm(\'Точно хочешь удалить?\')) return false;"><img src="../images/icon_delete.gif"></a>
												&nbsp;
												',$id,$pagedata['shp_msg_id']
												,$id,$pagedata['shp_msg_id']);
											
								printf('		<a href="msg.php?id=%s&them_id=%s">%s</a></td><td class="shp_tr">%s</td></tr>
									',$pagedata['shp_msg_id'],$id,$pagedata['shp_msg_title'],$pagedata['shp_msg_views']);
							};
							
							printf("</div><table><tr><td>
								<script type='text/javascript'>
								document.write(VK.Share.button({
									url: '%s',
									title: '%s',
									description: '","http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"],$themdata['shp_them_title']);
									//printf('%s',_filter($pagedata['fullcontent']));
									print("',
									noparse: false
								},{type: 'button', text: 'Сохранить'}));
								</script></td>");
							print('<td>
							<!-- Put this div tag to the place, where the Like block will be -->
								<div class="like"><div id="vk_like"></div></div>
									<script type="text/javascript">
									VK.Widgets.Like("vk_like", {type: "full"});
									</script>
								</td></tr></table>');
						}
					?>
                </td><td>
                </td>
            </tr>
        </table>
	    <div id="footer">
    		<? include('../parts/footer.php'); ?>
        </div>    
	</div>
    </center>
</div>

</body>
</html>
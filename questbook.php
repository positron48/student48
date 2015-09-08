<?
	include('parts/settings.php');
	
	$dbdata1=mysql_query("SELECT * FROM questbook ORDER BY id DESC LIMIT 1", $dbconnect);
	$pagedata1=mysql_fetch_array($dbdata1);
	$flag_add=true;
	if($check && isset($_GET['del_id']))
	{
		$del_id=_filter($_GET['del_id']);
		$dbdata2=mysql_query("DELETE FROM questbook WHERE id=$del_id LIMIT 1", $dbconnect);
		header("location: questbook.php");
	}
	$handle = mysql_query("SELECT COUNT(*) FROM questbook", $dbconnect);
	$number_msg  = mysql_fetch_array($handle);	
	if(isset($_POST['user']) && isset($_POST['title_message'])&&isset($_POST['msg'])&&isset($_POST['123']))
	{
		$dateadd=date("Y-m-d H:i:s ");
		$diff = abs(strtotime($dateadd) - strtotime($pagedata1['dateadd']));
		$user=_filter($_POST['user']);
		$title_message=_filter($_POST['title_message']);		
		$msg=unxss($_POST['msg']);
        if($_POST['123']!="11")
            $is_robot=true;
        else
            $is_robot=false;
		$error="";
		
		if(!$is_robot && $user!="" && $title_message!="" && $msg!="" && ($diff>=$time_add_msg || $diff<0) && $msg!=$pagedata1['msg'])
		{
			$query1="INSERT INTO questbook VALUES(NULL,'$user','$title_message','$msg','$dateadd',0)";
			$result=mysql_query($query1);
			$flag_add=true;
			header("Location: questbook.php");
		}
		else if($diff<=$time_add_msg && $diff>0)
		{
			$error.="<br>Слишком малый промежуток времени";
			$flag_add=false;
		}
		else
        {
			if($user="") $error.="<br>Поле 'Имя пользователя' не заполнено";
            if($title_message="") $error.="<br>Поле 'Тема' не заполнено";
            if($msg="") $error.="<br>Поле 'Сообщение' не заполнено";
            if($is_robot)
                $error.="<br>Вы робот!";
        }
	}
	if(isset($_GET['page']))
	{
		$page=_filter($_GET['page']);
		$number_min=($page-1)*$number_msg_on_page;
		$dbdata=mysql_query("SELECT * FROM questbook ORDER BY id DESC LIMIT $number_min, $number_news_on_page", $dbconnect);
	}
	else
	{
		$dbdata=mysql_query("SELECT * FROM questbook ORDER BY id DESC LIMIT $number_msg_on_page", $dbconnect);
	}
	
?>
<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ|Гостевая</title>
<? include('parts/head.php'); ?>
<script>
	function checkForm(obj)
	{
		var return_value=true;
		var error_msg="Некорректный ввод данных в полях:";
		if(obj.user.value=="" || obj.user.value.toLowerCase()=="админ" || obj.user.value.toLowerCase()=="admin" || obj.user.value.toLowerCase()=="administrator" || obj.user.value.toLowerCase()=="администратор")
		{
			obj.user.focus();
			error_msg+="\n'Имя'";
			return_value=false;
		}
		if(obj.title_message.value=="")
		{
			obj.title_message.focus();
			error_msg+="\n'Тема'";
			return_value=false;
		}
		if(obj.msg.value=="")
		{
			obj.msg.focus();
			error_msg+="\n'Сообщение'";
			return_value=false;
		}
		obj.error.value=true
		return return_value;
	}

</script>
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
	<? include("parts/top.php"); ?>
    <? include('parts/header.php'); ?>
    <div class="container">
        <h1>Гостевая</h1><br />
                <?		
					while($pagedata=mysql_fetch_array($dbdata))
					{
                    	printf('
							<table class="table table-striped table-bordered table-condensed">
								<tr><td>
								');
						if($check)
							printf('<a href="questbook.php?admin=ololo48&del_id=%s" onclick="if(!confirm(\'Точно хочешь удалить?\')) return false;" class="pull-right"><i class="icon-remove"></i></a>',$pagedata['id']);
						printf('%s
								<div class="pull-right">Добавлено:%s, %s
								</div></td></tr>
								<tr><td>%s</td></tr></table>
								',$pagedata['title_message'],$pagedata['user'],$pagedata['dateadd'],$pagedata['message']);
					}
					echo("<center><div class='pagination'><ul>");
					for($i=1;$i<($number_msg[0]/$number_news_on_page+1);$i++)
						if($_GET['page']==$i)
							printf("<li class='active'><a href ='questbook.php?page=%s'> %s</a></li>",$i,$i);
						else if(!isset($_GET['page']) && $i==1)
							printf("<li class='active'><a href ='questbook.php?page=%s'> %s</a></li>",$i,$i);
						else 
							printf("<li><a href='questbook.php?page=%s'> %s</a></li>",$i,$i);	
					echo("</center>");				
				?>

                <form action="questbook.php" onSubmit="return checkForm(this);" method="post">
                <table>
                    <tr>
                    <td colspan="2">
                    	<? 	
							if($error!="")
								printf("<div class='alert alert-error'> Сообщение не добавлено: %s </div>", $error); 
						?>
                    </td></tr><tr>
                    <td colspan="2"><h2>Добавить сообщение:</h2></td></tr>
                    <tr><td align="right">Имя:</td><td><input type="text" name="user" size="90" <? if($_POST['error_form']==true) printf("value='%s'",$user) ?>/></td></tr>
                    <tr><td align="right">Тема:</td><td><input type="text" name="title_message" size="90" <? if($_POST['error_form']==true) printf("value='%s'",$title_message) ?>/></td></tr>
                    <tr><td align="right">Сообщение:</td><td><textarea cols="69" rows="5" name="msg"><? if($_POST['error_form']==true) printf("%s",$msg) ?></textarea></td></tr>
                    <tr><td></td><td><input type="hidden" name="error_form" value="false"></td></tr>
					<tr><td></td><td>
						<table cellpadding=5 cellspacing=0>
							<tr>
							<div style="display: none;"><input type="radio" name="123" checked="true" value="1" /></div>
                            <input type="radio" name="123" value="11" /> Я не робот
							</td>
							</tr>
						</table>
					</td></tr>
                    <tr><td></td><td><input type="submit" value="Отправить" class="btn" /></td><td></td></tr>
                   </table>
                </form>
                </td>
            </tr>
        </table>
	    <div id="footer">
    		<? include('parts/footer.php'); ?>
        </div>    
	</div>
    </center>
</div>
	<?
		if($error!="" || isset($_POST['user']) || isset($_POST['title_message']) || isset($_POST['msg']))
			print('<script> self.scroll(10000,10000); </script> ');
	?>
</body>
</html>
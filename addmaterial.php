<?
	include('parts/settings.php');
	$dbdata=mysql_query("SELECT * FROM predmets ORDER BY semestr ASC, title_predmet ASC", $dbconnect);
	$dbdata1=mysql_query("SELECT * FROM predmets ORDER BY semestr ASC, title_predmet ASC", $dbconnect);
	$pagedata=mysql_fetch_array($dbdata1);
	$err_msg="";
	if(isset($_POST['title']) && $check)
	{
		$title=_filter($_POST['title']);
		$metakey=_filter($_POST['metakey']);
		$link=_filter($_POST['link']);
		$predmetid=_filter($_POST['predmetid']);
		if($title && $metakey && $link && $predmetid)
			if($_FILES["filename"]["size"] < $max_filesize)
			{
				$link.=$_FILES["filename"]["name"];
				if(copy($_FILES["filename"]["tmp_name"],$link))
				{
					
					$date=date("Y-m-d H:i:s "); 
					$filesize=$_FILES["filename"]["size"]/1024;
					$query="INSERT INTO materials VALUES(NULL,'$title','$metakey','$predmetid','$link','$filesize',0,'$date')";
					$add=true;
				}
				else
				{
					$add=false;
					$err_msg.="Файл не может быть размещен в данной дирректории";
				}
			}
			else
			{
				$add=false;
				$err_msg.="Ошибка загрузки файла<br>";
			}
		else
		{
			$add=false;
			$err_msg.="Неправильный ввод двнных<br>";
		}
		if(md5($_POST['turing']) != $_SESSION['turing_string'])
		{
			$add=false;
			$err_msg.="Неверный проверочный код<br>";
		}
	}

	
	
?>
<html>
<head>
<title>ЛГТУ|Добавление материала</title>

<? include('parts/head.php'); ?>

</head>
<body>

<div id="outer" align="center"> 
	<? include("parts/top.php"); ?>
    <div id="inner" align="left">
    	<div id="header">
        	<? include('parts/header.php'); ?>
        </div>
        <table cellpadding="0" cellspacing="0">
            <tr>
            	<td id="left">
                	<? include('parts/left.php'); ?>
                </td>
                <td id="main">
                	<? if(!$add && $check):?>
					
					<script>
						var predmets = new Array();
						<?
							$i=0;
							while($predmets=mysql_fetch_array($dbdata))
							{
								printf("predmets[%s] = '%s'\n",$predmets['id'],"materials/semestr_".$predmets['semestr']."/".$predmets['title_predmet_english']."/");	
							}
						?>
						function changeDir(forma)
						{
							if(forma.predmetid.options[0].value==0)
								forma.predmetid.options[0]=null;
							forma.link.value=predmets[forma.predmetid.value];
							
						}
					</script>
             		
                    <p><h1>Добавьте материал:</h1>
                    <? 
						if($err_msg!="")
							printf("<h3><font color='#CC3300'>%s</font></h3>",$err_msg);
					?>
                    <form name="addnews" method="post" action="addmaterial.php" enctype="multipart/form-data">
                    	<table class="form">
                        <tr>
                            <td>Заголовок:</td>
                            <td><input type="text" name="title" size="83"></td>
                        </tr><tr>
                            <td>Ключевые слова:</td>
                            <td><input type="text" name="metakey" size="83"></td>
                        
                        </tr><tr>
                            <td>Дирректория:</td>
                            <td><input type="text" name="link" size="83" value="Выберите предмет" readonly></td>
                        </tr><tr>
                        	<td>Предмет:</td>
                            <td>
                            	<select name="predmetid" onChange="changeDir(this.form)">
                                	<option value="0" selected>Выберите предмет</option>
                                <?
									do
                                    {
                                        printf("<option value='%s'>%s: %s</option>\n",$pagedata['id'],$pagedata['semestr'],$pagedata['title_predmet']);
                                    }while($pagedata=mysql_fetch_array($dbdata1));
								?>
                            	</select>
                            </td>
                        </tr><tr>
                            <td>Файл:</td>
                            <td><input type="file" name="filename"></td>
                        </tr>
                        <tr><td></td><td>
                            <table cellpadding=5 cellspacing=0>
                            <tr>
                            
                            <td style="padding: 2px;" width="10"><img src="/captcha/captchac_code.php" id="captcha"></td>
                            <td valign="top"><font color="#000000">Введите код с картинки:</font><br>
                            <input type="text" name="turing" maxlength="10" size="10">
                                <a href="#" onclick=" document.getElementById('captcha').src = document.getElementById('captcha').src + '?' + (new Date()).getMilliseconds();">Обновить</a>
                            </td>
                            </tr>
                            </table>
                        </td>
                        </tr>
                        <tr><td colspan="2"> 
                            <input type="submit" value="Отправить"><input type="reset" value="Очистить">
                        </td></tr>
                        </table>
                	</form>
                    <? elseif($add && $check):?>
                    	<?
							$result=mysql_query($query);
							mysql_close($dbconnect);
							if(!$result)
								printf("<p>Ошибка при загрузке файла");
							else
								printf("<p>Материал добавлен!");
						?>
                    <? else: ?>
                    	<h3>У вас недостаточно прав для добавления материала</h3>
               		<? endif ?>
                </td>
            </tr>
        </table>
	    <div id="footer">
    		<? include('parts/footer.php'); ?>
        </div>    
	</div>
    </center>
</div>

</body>
</html>
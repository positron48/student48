<?
	include('parts/settings.php');
	$uploaddir = 'pmfiles/';
	$err = "";
	if(isset($_POST['pmfiletitle']))
	{
		$file_ext =  strtolower(strrchr($_FILES['pmfile']['name'],'.'));
		if($file_ext == ".rar" || $file_ext == ".zip")
		{
			if($_FILES['pmfile']['size'] < $max_file_size)
			{
				$filedest = _filter($_POST['pmfiledest']);
				$filename = _filter($_FILES['pmfile']['name']);
				$filetitle = _filter($_POST['pmfiletitle']);
				$filesize = _filter($_FILES['pmfile']['size'])/1024;
				$predmetid =_filter($_POST['predmetid']);
				$pmfilemetakey = _filter($_POST['pmfilemetakey']);
				$predmetsemestr = _filter($_POST['predmetsemestr']);
				$predmetname = _filter($_POST['predmetname']);
				$date=date("Y-m-d H:i:s "); 
				if(is_file("pmfiles/".$filename))
				{
						$num = rand(1000000,9999999);
						$filename = $num."_".$filename;
				}
				if($filetitle!="" && $filename!="" && (($predmetid!="" && $filedest!="") || ($predmetsemestr!="" && $predmetname!="")))
				{
					if(move_uploaded_file($_FILES['pmfile']['tmp_name'],$uploaddir.$filename))
					{
						if(mysql_query("INSERT INTO pm_files VALUES(NULL,'$filetitle','$predmetid','$pmfilemetakey','$filename','$filesize','$predmetsemestr','$predmetname','$filedest','$date')"))
							$file = true;
						else
							$err.="<br>Ошибка записи в базу данных";
					}
					else
					{
						$err .= "<br>Ошибка добавления файла";
					}
				}
				else 
				{
					$err.="<br>Некорректные данные";
				}
			}
			else
			{
				$err.= "<br>Размер файла превышает допустимые 10 Мб. Размер: ".$_FILES['pmfile']['size'];
			}
		}
		else
		{
			$err .= "<br>Недопустимое расширение";
		}
        if($err!="")
            $err = "Ошибка:".$err;
	}
	$dbdata=mysql_query("SELECT * FROM predmets ORDER BY semestr ASC, title_predmet ASC", $dbconnect);
	$dbdata1=mysql_query("SELECT * FROM predmets ORDER BY semestr ASC, title_predmet ASC", $dbconnect);
	$pagedata1=mysql_fetch_array($dbdata1);
?>
<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ|Добавить</title>
<? include('parts/head.php'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"></head>
<body>
<script>
	var predmets = new Array(4);
	for(var i=0;i<4;i++)
		predmets[i]=new Array();
	<?
		$i=0;
		while($predmets=mysql_fetch_array($dbdata))
		{
			printf("predmets[0][%s] = '%s';\n",$i,"materials/semestr_".$predmets['semestr']."/".$predmets['title_predmet_english']."/");
			printf("predmets[1][%s] = '%s';\n",$i,$predmets['semestr']);
			printf("predmets[2][%s] = '%s';\n",$i,$predmets['title_predmet']);	
			printf("predmets[3][%s] = '%s';\n",$i,$predmets['id']);	
			$i++;
		}
	?>
	var num=0;
	function changeDir(form)
	{
		if(form.predmetid.options[0].value=='lol')
			form.predmetid.options[0]=null;
		
		if(form.predmetid.value=='0')
		{
			form.pmfiledest.value='';
			form.predmetsemestr.value='';
			form.predmetname.value='';
			document.getElementById('tdsemestr1').style.display = 'inline';
			document.getElementById('tdname1').style.display = 'inline';
		}
		else
		{
			for(var j=0;j<predmets[0].length;j++)
			{
				if(form.predmetid.value==predmets[3][j])
				{
					form.pmfiledest.value=predmets[0][j];
					form.predmetsemestr.value=predmets[1][j];
					form.predmetname.value=predmets[2][j];
					document.getElementById('tdsemestr1').style.display = 'none';
					document.getElementById('tdsemestr2').style.display = 'none';
					document.getElementById('tdname1').style.display = 'none';
					document.getElementById('tdname2').style.display = 'none';
				}
			}
		}
	}
	function changeSem(form)
	{
		if(form.semestr.options[0].value=='none')
			form.semestr.options[0]=null;
		form.predmetid.options.length=0;
		form.predmetid.options[0]=new Option('Выберите предмет','lol');
		for(var j=0;j<predmets[0].length;j++)
			if(predmets[1][j]==form.semestr.options[form.semestr.selectedIndex].value)
			{
				form.predmetid.options[form.predmetid.length]=new Option(predmets[2][j],predmets[3][j]);
				if(predmets[3][j]==<? printf("'%s'",$_POST['predmetid']) ?>)
					form.predmetid.options[form.predmetid.length-1].selected=true;
			}
		form.predmetid.options[form.predmetid.options.length]=new Option('Другой','0');
	}
</script>
<? include("parts/top.php"); ?>
<? include('parts/header.php'); ?>
<div class="container">
					<? if($file): ?>
						<div class="alert alert-success">Материал добавлен!</div>
						<table class="table table-striped table-bordered table-condensed">
						<tr><td>Заголовок материала</td><td><? printf("%s",_filter($_POST['pmfiletitle'])); ?></td></tr>
						<tr><td>Имя файла</td><td><? printf("%s",_filter($_FILES['pmfile']['name'])); ?></td></tr>
						<tr><td>Размер файла</td><td><? printf("%s",$_FILES['pmfile']['size']); ?></td></tr>
						</table>
					<? endif ?>
                    <? if($check) printf("<a class='btn' href='http://student48.ru/moderation.php'>Модерация</a>"); ?>
					<center><h1>Добавление файла:</h1></center>
					<?
                    if($err!="")
						printf("<div class='alert alert-error'>%s</div>",$err);
					?>
					<p>Внимание! При загрузке файла соблюдайте некоторые правила:
					<ul>
						<li>Размер загружаемого файла не должен превышать 10 Мб
						<li>Допустимые расширения файла: "rar" и "zip"
						<li>Все поля, за исключением поля "ключевые слова" обязательны для заполнения
						<li>Если предмета нет в списке, выберите из списка пункт "Другой" и введите необходимые данные о предмете
					</ul>
					<table>
						<form method="post" enctype="multipart/form-data" action="upload.php" id="formgeneral"> 
							<tr>
								<td>Заголовок:</td>
								<td>
									<input type="text" name="pmfiletitle" size="83" <? if(isset($_POST['pmfiletitle'])) printf("value='%s'",_filter($_POST['pmfiletitle'])) ?> />
								</td>
							</tr><tr>
								<td>Ключевые слова:</td>
								<td>
									<input type="text" name="pmfilemetakey" size="83" <? if(isset($_POST['pmfilemetakey'])) printf("value='%s'",_filter($_POST['pmfilemetakey'])) ?> >
								</td>
							</tr><tr style="display:none">
								<td>Дирректория:</td>
								<td>
									<input type="text" name="pmfiledest" size="83"  value="Выберите предмет" readonly />
								</td>
							</tr><tr>
								<td>Предмет:</td>
								<td>
									 <select name="semestr"  onChange="changeSem(this.form)">
									 <?
									 	if($_POST['semestr']=="none") echo('<option value="none" selected>Все семестры</option>'); else echo('<option value="none">семестр</option>');
										if($_POST['semestr']=="1") echo('<option value="1" selected>1</option>'); else echo('<option value="1">1</option>');
										if($_POST['semestr']=="2") echo('<option value="2" selected>2</option>'); else echo('<option value="2">2</option>');
										if($_POST['semestr']=="3") echo('<option value="3" selected>3</option>'); else echo('<option value="3">3</option>');
										if($_POST['semestr']=="4") echo('<option value="4" selected>4</option>'); else echo('<option value="4">4</option>');
										if($_POST['semestr']=="5") echo('<option value="5" selected>5</option>'); else echo('<option value="5">5</option>');
										if($_POST['semestr']=="6") echo('<option value="6" selected>6</option>'); else echo('<option value="6">6</option>');
										if($_POST['semestr']=="7") echo('<option value="7" selected>7</option>'); else echo('<option value="7">7</option>');
										if($_POST['semestr']=="8") echo('<option value="8" selected>8</option>'); else echo('<option value="8">8</option>');
										if($_POST['semestr']=="9") echo('<option value="9" selected>9</option>'); else echo('<option value="9">9</option>');
										if($_POST['semestr']=="10") echo('<option value="10" selected>10</option>'); else echo('<option value="10">10</option>');
									 ?>
									 </select>
									 <select name="predmetid" onChange="changeDir(this.form)">
										<option value="lol" selected>Выберите семестр</option>
										<option value="0">Другой</option>
										</select>
								</td>
							</tr><tr style="display:none" id="tdsemestr1">
								<td>Семестр:</td>
								<td>
									<input type="text" size="83" name="predmetsemestr" value=""/>
								</td>
							</tr><tr style="display:none" id="tdname1">
								<td>Название предмета:</td>
								<td>
									<input type="text" size="83" name="predmetname"  value=""/>
								</td>
							</tr><tr>
								<td>Файл:</td>
								<td>
									<input type="file" name="pmfile" />
								</td>
							</tr><tr>
								<td colspan="2">
									<input type="submit" value="Отправить" class="btn"/>
								</td>
							</tr>
						</form>
					</table>
    		<? include('parts/footer.php'); ?>   
</div>
<script>
changeSem(document.getElementById('formgeneral'));
changeDir(document.getElementById('formgeneral'));
</script>
</body>
</html>
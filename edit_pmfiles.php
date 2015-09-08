<?
	include('parts/settings.php');
	$err="";
	if(isset($_POST['pmfiletitle']))
	{
		$pmfiletitle = _filter($_POST['pmfiletitle']);
		$pmfilename = _filter($_POST['pmfilename']);
		$pmfiledest = _filter($_POST['pmfiledest']);
		$pmfileid = _filter($_POST['pmfileid']);
		$oldpmfilename = _filter($_POST['oldpmfilename']);
		$metakey = _filter($_POST['pmfilemetakey']);
		$predmetsemestr = _filter($_POST['predmetsemestr']);
		$predmetname = _filter($_POST['predmetname']);
		$predmetid = _filter($_POST['predmetid']);
		if($pmfiletitle!="" && $pmfilename!="" && $pmfiledest!="" && $oldpmfilename!="" && $predmetsemestr!="" && $predmetname!="" && $predmetid!="")
		{
			if(rename("pmfiles/".$oldpmfilename,"pmfiles/".$pmfilename))
			{
				if(mysql_query("UPDATE pm_files SET pmfiletitle='$pmfiletitle', pmfilepredmetsemestr='$predmetsemestr', pmfilepredmetname='$predmetname', pmfilepredmetid='$predmetid', pmfilename='$pmfilename', pmfiledest='$pmfiledest', pmfilemetakey='$metakey' WHERE pmfileid='$pmfileid'"))
				{
					$edit=true;
				}
				else
				{
					$err .= "<br>Ошибка при записи в базу данных";
				}
			}
			else
			{
				$err.="<br>Не удалось переименовать файл";
			}
		}
		else
		{
			$err .= "<br>Некорректно введенны данные";
		}
	}
	if(isset($_GET['pmfileid']))
	{
		$pmfileid=_filter($_GET['pmfileid']);
		$dbdata=mysql_query("SELECT * FROM pm_files WHERE pmfileid='$pmfileid' LIMIT 1");
		$pagedata=mysql_fetch_array($dbdata);
	}
	$dbdata=mysql_query("SELECT * FROM predmets ORDER BY semestr ASC, title_predmet ASC", $dbconnect);
	$dbdata1=mysql_query("SELECT * FROM predmets ORDER BY semestr ASC, title_predmet ASC", $dbconnect);
	$pagedata1=mysql_fetch_array($dbdata1);
?>
<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ|Редактирование</title>
<? include('parts/head.php'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head>
<body> 
<?  //printf("choosePredmet %s,%s ",$pagedata['pmfilepredmetsemestr'],$pagedata['pmfilepredmetid']); ?>
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
			document.getElementById('tdsemestr2').style.display = 'inline';
			document.getElementById('tdname1').style.display = 'inline';
			document.getElementById('tdname2').style.display = 'inline';
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
	function choosePredmet(semestr,predmetid)
	{
	
	}
</script>
 
	<? include("parts/top.php"); ?>
    <? include('parts/header.php'); ?>
    <div class="container">
	<h1>Редактирование</h1><br />
	<?
        if($err!="")
            printf("<p class='alert alert-error'>%s</p>",$err);
		if($edit)
			printf("<p class='alert alert-success'>Файл успешно отредактирован</p>");
	?>
	<? if(!$_POST['pmfilename'] && $err==""): ?>
		<table>
			<form method="post" enctype="multipart/form-data" <? printf("action='edit_pmfiles.php?pmfileid=%s'",$pmfileid) ?>> 
				<input type="hidden" name="pmfileid" <? printf("value='%s'",$pagedata['pmfileid']); ?>>
				<input type="hidden" name="oldpmfilename" <? printf("value='%s'",$pagedata['pmfilename']); ?>>
				<tr>
					<td>Заголовок материала</td>
					<td>
						<input type="text" name="pmfiletitle" size="50" 
						<? 
							if(isset($_POST['pmfiletitle'])) 
								printf("value='%s'",_filter($_POST['pmfiletitle']));
							else 
								printf("value='%s'",$pagedata['pmfiletitle']);
						?> />
					</td>
				</tr><tr>
					<td>Ключевые слова</td>
					<td>
						<input type="text" name="pmfilemetakey" size="50" 
						<? 
							if(isset($_POST['pmfilemetakey'])) 
								printf("value='%s'",_filter($_POST['pmfilemetakey']));
							else 
								printf("value='%s'",$pagedata['pmfilemetakey']);
						?> />
					</td>
				</tr><tr>
					<td>Дирректория</td>
					<td>
						<input type="text" name="pmfiledest" size="50" 
						<? 
							if(isset($_POST['pmfiledest'])) 
								printf("value='%s'",_filter($_POST['pmfiledest']));
							else 
								printf("value='%s'",_filter($pagedata['pmfiledest']));
						?>/>
					</td>
				</tr><tr>
					<td>Имя файла:</td>
					<td>
						<input type="text" name="pmfilename" 
						<? 
							if(isset($_POST['pmfilename'])) 
								printf("value='%s'",_filter($_POST['pmfilename'])); 
							else 
								printf("value='%s'",_filter($pagedata['pmfilename']));
						?>/>
					</td>
				</tr><tr>
					<td style="display:none" id="tdsemestr1">Семестр:</td>
					<td style="display:none" id="tdsemestr2">
						<input type="text" name="predmetsemestr" size="83"  value=""/>
					</td>
				</tr><tr>
					<td style="display:none" id="tdname1">Название предмета:</td>
					<td style="display:none" id="tdname2">
						<input type="text" name="predmetname" size="83"  value=""/>
					</td>
				</tr><tr>
					<td>Предмет:</td>
					<td>
						 <select name="semestr"  onChange="changeSem(this.form)">
						 <?
						 	if($_POST['semestr']=="none") 
								echo('<option value="none" selected>Все семестры</option>'); 
							else echo('<option value="none">семестр</option>');
							if($_POST['semestr']=="1") 
								echo('<option value="1" selected>1</option>'); 
							else echo('<option value="1">1</option>');
							if($_POST['semestr']=="2") 
								echo('<option value="2" selected>2</option>'); 
							else echo('<option value="2">2</option>');
							if($_POST['semestr']=="3") 
								echo('<option value="3" selected>3</option>'); 
							else echo('<option value="3">3</option>');
							if($_POST['semestr']=="4") 
								echo('<option value="4" selected>4</option>'); 
							else echo('<option value="4">4</option>');
							if($_POST['semestr']=="5") 
								echo('<option value="5" selected>5</option>'); 
							else echo('<option value="5">5</option>');
							if($_POST['semestr']=="6") 
								echo('<option value="6" selected>6</option>'); 
							else echo('<option value="6">6</option>');
							if($_POST['semestr']=="7") 
								echo('<option value="7" selected>7</option>'); 
							else echo('<option value="7">7</option>');
							if($_POST['semestr']=="8") 
								echo('<option value="8" selected>8</option>'); 
							else echo('<option value="8">8</option>');
							if($_POST['semestr']=="9") 
							echo('<option value="9" selected>9</option>'); 
								else echo('<option value="9">9</option>');
							if($_POST['semestr']=="10") 
								echo('<option value="10" selected>10</option>'); 
							else 
							echo('<option value="10">10</option>');
						 ?>
						 </select>
						 <select name="predmetid" onChange="changeDir(this.form)">
							<option value="lol" selected>Выберите семестр</option>
							<option value="0">Другой</option>
							</select>
					</td>
				</tr><tr>
					<td colspan="2">
						<input type="submit" class="btn" value="Сохранить" />
					</td>
				</tr>
			</form>
		</table>
	<? endif ?>
                
	<? include('parts/footer.php'); ?>

    
</div>
</body>
</html>

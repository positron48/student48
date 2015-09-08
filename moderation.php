<?
	include('parts/settings.php');
	$option=_filter($_GET['option']);
	$pmfileid=_filter($_GET['pmfileid']);
	$err = "";
    if($_GET['fileadd']==1) $fileadd=true;
    if($_GET['del']==1) $del=true;
	if($option==1)
	{
		$dbdata1 = mysql_query("SELECT * FROM pm_files WHERE pmfileid='$pmfileid' LIMIT 1");
		$pagedata1 = mysql_fetch_array($dbdata1);
		if($pagedata1['pmfiledest']!="")
		{	
			if(!is_dir($pagedata1['pmfiledest']))
			{
				$err .= "Папки не существует";
			}
			$file_name=$pagedata1['pmfilename'];
			if(is_file($pagedata1['pmfiledest'].$file_name))
			{
				$num = rand(1000000,9999999);
				$file_name = $num."_".$file_name;
			}
			if(copy("pmfiles/".$pagedata1['pmfilename'],$pagedata1['pmfiledest'].$file_name))
			{
				$filetitle = $pagedata1['pmfiletitle'];
				$filedir = $pagedata1['pmfiledest'];
				$metakey = $pagedata1['pmfilemetakey'];
				$predmetid = $pagedata1['pmfilepredmetid'];
				$link = $pagedata1['pmfiledest'].$file_name;
				$filesize = $pagedata1['pmfilesize'];
				$date=date("Y-m-d H:i:s "); 
				if(mysql_query("INSERT INTO materials VALUES(NULL,'$filetitle','$metakey','$predmetid','$link','$filesize',0,'$date')"))
				{
					if(mysql_query("DELETE FROM pm_files WHERE pmfileid='$pmfileid' LIMIT 1"))
					{
						$fileadd = true;
						if(is_file("pmfiles/".$pagedata1['pmfilename']))
							unlink("pmfiles/".$pagedata1['pmfilename']);
                        header("http://student48.ru/moderation.php?fileadd=1");
					}
					else
					{
						$err .= "<br>Ошибка при работе с БД";
					}
				}
				else
				{
					$err .= "<br>Ошибка добавления материала";
				}
			}
			else
			{
				$err .= "<br>Ошибка перемещения файла";
			}
		}
		else
		{
			$err .= "<br>Некорректные данные, сначала отредактируйте материал";
		}
	}
	if($option==2)
	{
		$dbdata1 = mysql_query("SELECT * FROM pm_files WHERE pmfileid='$pmfileid' LIMIT 1");
		$pagedata1 = mysql_fetch_array($dbdata1);
		if(is_file("pmfiles/".$pagedata1['pmfilename']))
		{
			if(unlink("pmfiles/".$pagedata1['pmfilename']))
			{	
				if(mysql_query("DELETE FROM pm_files WHERE pmfileid='$pmfileid' LIMIT 1"))
					$del = true;
                header("http://student48.ru/moderation.php?del=1");
			}
			else
			{
				$err.="<br>Ошибка удаления файла";
			}
		}
		else
			if(mysql_query("DELETE FROM pm_files WHERE pmfileid='$pmfileid' LIMIT 1"))
				$del = true;
			else
				$err.="<br>Ошибка удаления записи из БД";	
			
	}
	$dbdata=mysql_query("SELECT * FROM pm_files", $dbconnect);
    $handle = mysql_query("SELECT COUNT(*) FROM pm_files", $dbconnect);
	$number_pmfiles  = mysql_fetch_array($handle);
?>
<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ|Модерация</title>
<? include('parts/head.php'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"></head>
<body>
	<? include("parts/top.php"); ?>
    <? include('parts/header.php'); ?>
    <div class="container">
					<h1>Модерация</h1><br />
					<? if($check): ?>
    					<?
    						if($del) print("<p class='alert alert-success'>Файл успешно удален</p>");
    						if($fileadd) print("<p class='alert alert-success'>Файл успешно добавлен</p>");
    						if($err!="") printf("<p class='alert alert-error'>%s</p>",$err);
    					?>
                        <? if($number_pmfiles[0] != 0): ?>
                            <? printf("<br>Файлов на модерации: $number_pmfiles[0]"); ?>
        					<table class="table table-striped table-bordered table-condensed">
        					<tr><td><i class="icon-ok"></i></td><td><i class="icon-remove"></i></td><td><i class="icon-edit"></i></td><td>title</td><td>name</td><td>Metakey</td><td>size</td><td>Predmet</td><td>Date</td></tr>
        					<?
        						while($pagedata=mysql_fetch_array($dbdata))
        						{
        							printf("<tr> 
        							<td><a href='moderation.php?option=1&pmfileid=%s'><i class='icon-ok'></i></a></td> 
        							<td><a href='moderation.php?option=2&pmfileid=%s'><i class='icon-remove'></i></a></td> 
        							<td><a href='edit_pmfiles.php?pmfileid=%s'><i class='icon-edit'></i></a></td>
        							<td>%s</td> 
        							<td><a href='pmfiles/%s'>%s</a></td> 
        							<td>%s</td> 
        							<td>%s</td> 
        							<td>%s:%s</td> 
        							<td>%s</td>  </tr>", 
        							$pagedata['pmfileid'], 
        							$pagedata['pmfileid'], 
        							$pagedata['pmfileid'], 
        							$pagedata['pmfiletitle'], 
        							$pagedata['pmfilename'], 
        							$pagedata['pmfilename'], 
        							$pagedata['pmfilemetakey'], 
        							$pagedata['pmfilesize'], 
        							$pagedata['pmfilepredmetsemestr'], 
        							$pagedata['pmfilepredmetname'], 
        							$pagedata['pmfiledateadd']);
        						}
        					?>
        					</table>
                        <? else: ?>
                            <div class="alert alert-info">Отсутствуют файлы на модерации</div>
                        <? endif; ?>
					<? else: ?>
    					<br /><div class="alert alert-danger">У вас недостаточно прав для просмотра данного раздела</div>
					<? endif; ?>
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
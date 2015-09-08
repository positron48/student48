<?
	include('../parts/settings.php');
	if(is_numeric($_POST['them_id']))
	{
		$db=mysql_query("SELECT * FROM shpora_themes WHERE shp_them_id='".$_POST['them_id']."'", $dbconnect);
		$pgdata=mysql_fetch_array($db);
		if($check || ($_COOKIE[md5($pgdata['shp_them_title'].$pgdata['shp_them_date'])]==true))
		{
			$them_id=_filter($_POST['them_id']);
			$them_title=_filter($_POST['them_title']);
			$them_predmet=_filter($_POST['them_predmet']);
			if($them_title!="" && $them_predmet!="")
			{
				$resulteditthem=mysql_query("UPDATE shpora_themes SET shp_them_title='".$them_title."', shp_them_predmet='".$them_predmet."' WHERE shp_them_id='".$them_id."'", $dbconnect);
				setcookie(md5($them_title.$pgdata['shp_them_date']),'true',time()+3600*$timeedit);
				header("location: http://student48.ru/shpora/index.php");
			}
			else
				echo "<script language='javascript' type='text/javascript'>java script:history.go(-1);</script>";
		}
	}
	if(is_numeric($_GET['del_id']))
	{
		$db=mysql_query("SELECT * FROM shpora_themes WHERE shp_them_id='".$_GET['del_id']."'", $dbconnect);
		$pgdata=mysql_fetch_array($db);
		if($check || ($_COOKIE[md5($pgdata['shp_them_title'].$pgdata['shp_them_date'])]==true))
		{
			$resultdelthem=mysql_query("DELETE FROM shpora_themes WHERE shp_them_id='".$_GET['del_id']."' LIMIT 1", $dbconnect);
			$resultdelmsg=mysql_query("DELETE FROM shpora_messages WHERE shp_msg_them_id='".$_GET['del_id']."'", $dbconnect);
		}
	}
	$dbdata=mysql_query("SELECT * FROM shpora_themes ORDER BY shp_them_title ASC", $dbconnect);
?>
<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ | Шпоры!</title>
<? include('../parts/head.php'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"></head>
<body>

<? include("../parts/top.php"); ?>
<? include('../parts/header.php'); ?>
    <div class="container">
                	<h1>Шпоры!</h1><br />
					<? if(is_numeric($_GET['del_id']) && ($check || ($_COOKIE[md5($pgdata['shp_them_title'].$pgdata['shp_them_date'])]==true)))
							if($resultdelmsg && $resultdelthem)
								print('<h3>Шпора удалена!</h3>');
							else
								print('<h3>Ошибка удаления</h3>');
					?>
						<? if($check)
						{
							print("<a href='add_shpor_them.php' class='btn'> Добавить шпору</a><br /><br />");
						}
						?>
						<table class="table table-striped table-bordered table-condensed"><!--<tr><td>Тема</td><td>Дата</td><td>Просмотры</td></tr> -->
						<?
							while($pagedata=mysql_fetch_array($dbdata))
							{
								if(is_numeric($_GET['edit_id']) && ($check || ($_COOKIE[md5($pagedata['shp_them_title'].$pagedata['shp_them_date'])]==true)) && ($_GET['edit_id']==$pagedata['shp_them_id']))
								{
									printf('<tr>
												<td>
													<form class="form-inline" action="http://student48.ru/shpora/index.php" method="POST">
													<input name="them_id" value="%s" type="hidden"/>
													<input name="them_title" value="%s" type="text"/>
												</td>
												<td  class="form-inline"><input name="them_predmet" value="%s" type="text"/><input type="submit" class="btn" value="ok"/></td>
												<td>%s</td>
												<td>%s</td>
											</form>
											</tr>'	
											,$pagedata['shp_them_id'],$pagedata['shp_them_title']
											,$pagedata['shp_them_predmet']
											,date('d', strtotime($pagedata['shp_them_date'])).'.'.date('m', strtotime($pagedata['shp_them_date'])).'.'.date('Y', strtotime($pagedata['shp_them_date']))
											,$pagedata['shp_them_views']);
								}
								else
								{
									printf('<tr>
												<td>');
									if(($_COOKIE[md5($pagedata['shp_them_title'].$pagedata['shp_them_date'])]==true) || $check)
										printf('
													<a href="index.php?edit_id=%s"><i class="icon-edit"></i></a>
													<a href="index.php?del_id=%s" onclick="if(!confirm(\'Точно хочешь удалить?\')) return false;"><i class="icon-remove"></i></a>
													&nbsp;
											',$pagedata['shp_them_id'],$pagedata['shp_them_id']);
													
									printf('		<a href="themes.php?id=%s">%s</a></td>
												<td>%s</td>
												<td>%s</td>
												<td>%s</td>
											</tr>'	
											,$pagedata['shp_them_id'],$pagedata['shp_them_title']
											,$pagedata['shp_them_predmet']
											,date('d', strtotime($pagedata['shp_them_date'])).'.'.date('m', strtotime($pagedata['shp_them_date'])).'.'.date('Y', strtotime($pagedata['shp_them_date']))
											,$pagedata['shp_them_views']);
								}
							}
						?>
						</table>
    		<? include('../parts/footer.php'); ?>
</div>

</body>
</html>
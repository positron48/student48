<?
	include('parts/settings.php');
	if(isset($_GET['search_text']) && $_GET['search_text']!="")
	{
		$search_text=_filter($_GET['search_text']);
		$search_text=strtolower($search_text);
		$dbdata=mysql_query("SELECT * FROM materials, predmets WHERE materials.predmetid=predmets.id AND (LOWER(title_material) LIKE '%$search_text%' OR LOWER(metakey) LIKE '%$search_text%' OR LOWER(title_predmet) LIKE '%$search_text%' OR LOWER(link) LIKE '%$search_text%') ORDER BY predmets.semestr ASC, title_predmet ASC, title_material ASC", $dbconnect);
		$dbdata1=mysql_query("SELECT materials.id, title_material, metakey, predmetid, link, filesize, downloads, dateadd, title_predmet, semestr FROM materials, predmets WHERE materials.predmetid=predmets.id AND (LOWER(title_material) LIKE '%$search_text%' OR LOWER(metakey) LIKE '%$search_text%' OR LOWER(title_predmet) LIKE '%$search_text%' OR LOWER(link) LIKE '%$search_text%') ORDER BY predmets.semestr ASC, title_predmet ASC, title_material ASC",$dbconnect);
		$flag=true;
		$handle = mysql_query("SELECT count(1) FROM materials, predmets WHERE materials.predmetid=predmets.id AND (LOWER(title_material) LIKE '%$search_text%' OR LOWER(metakey) LIKE '%$search_text%' OR LOWER(title_predmet) LIKE '%$search_text%' OR LOWER(link) LIKE '%$search_text%') ORDER BY predmets.semestr ASC, title_predmet ASC, title_material ASC", $dbconnect);
		$size  = mysql_fetch_array($handle);
	}
	else
		$flag=false;
?>
<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ|Поиск по сайту</title>
<? include('parts/head.php'); ?>
</head>
<body>
<? include("parts/top.php"); ?>
<? include('parts/header.php'); ?>
<div class="container">
		<?
                	if($flag==true)
			{	
				printf('<h1>Поиск по запросу: "%s" </h1><h2>Результаты:</h2>',$search_text);
				if($size[0])
				{
					echo('<table class="table table-striped table-bordered table-condensed">
						<tr class="title_materials">
						<td class="td_material">семестр</td>
						<td class="td_material">предмет</td>
						<td class="td_material">описание</td>
						<td class="td_material">размер</td>
						<td class="td_material">ссылка</td></tr>');
					echo("Количество материалов: $size[0]");
					while($pagedata=mysql_fetch_array($dbdata))
					{	
						$pagedata1=mysql_fetch_array($dbdata1);
						printf('<tr><td class="td_material">%s</td><td class="td_material">%s</td><td class="td_material">%s</td><td class="td_material_filesize">%s Кб</td><td class="td_material"><a href="downloads.php?id=%s">Скачать</a></td>',$pagedata['semestr'],$pagedata['title_predmet'],$pagedata['title_material'],$pagedata['filesize'],$pagedata1['id']);
		
					}
            		echo('</table>');	
				}
				else
					print('<h3 class="alert alert-info">По введенным параметрам записей не обнаружено</h3>');
			}
			else
				echo('<center><h2>Ошибка запроса</h2></center>');
		?>
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
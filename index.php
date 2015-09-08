<?
	include('parts/settings.php');
	$dbdata=mysql_query("SELECT * FROM news ORDER BY id DESC LIMIT 3", $dbconnect);
	$dbdata_materials=mysql_query("SELECT * FROM materials, predmets WHERE materials.predmetid=predmets.id ORDER BY dateadd DESC LIMIT 20",$dbconnect);
	$dbdata_materials2=mysql_query("SELECT materials.id, title_material, metakey, predmetid, link, filesize, downloads, dateadd, title_predmet, semestr FROM materials, predmets WHERE materials.predmetid=predmets.id ORDER BY dateadd DESC LIMIT 20",$dbconnect);
    $handle = mysql_query("SELECT COUNT(*) FROM materials, predmets WHERE materials.predmetid=predmets.id ORDER BY dateadd DESC LIMIT 10", $dbconnect);
	$number_materials  = mysql_fetch_array($handle);
?>

<!DOCTYPE html>
<html>
<head>
    <title>ЛГТУ | Главная страница</title>
    
    <? include('parts/head.php'); ?>

    <meta name="description" content="Здесь вы можете скачать лабораторные, методички, графические работы, пособия, курсовые, рефераты по большому количеству дисциплин: дискретная математика, информатика, математический анализ, информационные технологии, история, компьютерная графика, логическое программирование, математическая логика и теория алгоритмов, начертательная геометрия, программирование на ЯВУ, психология, социология, структуры и алгоритмы, технология программирования, физика, философия и другие">
    <meta name="Keywords" content="скачать материалы, лабораторные, методички, графические работы, пособия, курсовые, рефераты, дискретная математика, информатика, математический анализ, информационные технологии, история, компьютерная графика, логическое программирование, математическая логика и теория алгоритмов, начертательная геометрия, программирование на ЯВУ, психология, социология, структуры и алгоритмы, технология программирования, физика, философия">
</head>

<body>

	<? include("parts/top.php"); ?>
    <? include('parts/header.php'); ?>
    <div class="container">
        <blockquote>
            <?
                $row_count = mysql_result(mysql_query('SELECT COUNT(*) FROM quote;'), 0);
                $query = '(SELECT * FROM quote LIMIT '.rand(0, $row_count).', 1)';
                $res = mysql_query($query);
                $quote_data = mysql_fetch_array($res);
                printf(
                    '<p> %s </p> <small> %s </small>',
                    $quote_data['text'],$quote_data['author']); 
            ?>
    	</blockquote>
        <div class="row-fluid">         
                    <? 
						while($pagedata=mysql_fetch_array($dbdata))
						{
							printf('
								<div class="span4" align="justify">
									<h2>
                                        %s
                                    </h2>
                                    <h5>Добавлено:%s  Просмотров:%s</h5>
                                    <br>
									%s
								    <p><a class="btn" href="news.php?id=%s">Подробнее »</a></p>
                                </div><!--/span-->
								',$pagedata['title_news'],$pagedata['datecreate'],$pagedata['views'],$pagedata['introtext'],$pagedata['id']);
						}?>
        </div><!--/row-->
                    <?
						if($number_materials[0])
						{
							echo("<br><h2>Последние добавления:</h2>");
							echo('<table class="table table-striped table-bordered table-condensed">
                                		<thead>
                                		<tr>
                                			<th><i class="icon-time"></i></th>
                                			<th class="td_material_predmet">Предмет</th>
                                			<th>Описание</th>
                                			<th>Размер</th>
                                			<th><i class="icon-download"></i></th>
                                			<th><i class="icon-download-alt"></i></th>
                                		</tr>
                                		</thead>');
							while($pagedata1=mysql_fetch_array($dbdata_materials))
							{	
								$pagedata2=mysql_fetch_array($dbdata_materials2);
								printf('<tr><td class="td_material"><a href="http://student48.ru/materials.php?semestr=%s&predmet=none">%s</a></td>
											<td class="td_material_predmet"><a href="http://student48.ru/materials.php?semestr=none&predmet=%s"">%s</a></td>
											<td class="td_material"><a href="downloads.php?id=%s"">%s</a></td>
											<td class="td_material_filesize">%s Кб</td>
											<td class="td_material_filesize">%s</td>
											<td class="td_material"><a href="downloads.php?id=%s"><i class="icon-download-alt"></i></a></td>',
											$pagedata1['semestr'],$pagedata1['semestr'],$pagedata1['title_predmet_english'],$pagedata1['title_predmet'],$pagedata2['id'],$pagedata1['title_material'],$pagedata1['filesize'],$pagedata1['downloads'],$pagedata2['id']);
							}
							echo('</table>');
						}
						?>
                </td>
            </tr>
        </table>
	    <div id="footer">
    		<? include('parts/footer.php'); ?>
        </div>    
	</div>
    </center>

</body>
</html>

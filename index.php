<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>
		<title>ЛГТУ | Главная страница</title>
<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>

	<blockquote>
	<?
		$rowCount = $dbWorker->query('SELECT COUNT(*) FROM quote;')->fetch()[0];
		$dbQuote = $dbWorker->query('SELECT * FROM quote LIMIT '.rand(0, $rowCount).', 1');
		$quoteData = $dbQuote->fetch();
		echo "<p>".$quoteData['text']."</p><small>".$quoteData['author']."</small>";
	?>
	</blockquote>
    <div class="row">
		<?
		foreach($dbWorker->query("SELECT * FROM news ORDER BY id DESC LIMIT 3") as $news){
		?>
		<div class="col-xs-4">
			<h2><?=$news['title_news']?></h2>
			<h5>Добавлено:<?=$news['datecreate']?>  Просмотров:<?=$news['views']?></h5>
			<br>
			<?=$news['introtext']?>
			<p><a class="btn btn-info" href="http://<?=$_SERVER['SERVER_NAME']?>/news/<?=$news['id']?>/">Подробнее »</a></p>
		</div>
    	<?
		}
		?>
		
		<br><h2>Последние добавления:</h2>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th><span class="glyphicon glyphicon-time"></span></th>
					<th class="td_material_predmet">Предмет</th>
					<th>Описание</th>
					<th>Размер</th>
					<th><center><span class="glyphicon glyphicon-download"></span></center></th>
					<th><center><span class="glyphicon glyphicon-download-alt"></span></center></th>
				</tr>
			</thead>
			<tbody>
			<? foreach($dbWorker->query("SELECT	M.id, M.title_material, M.filesize, M.downloads,
						P.title_predmet_english, P.title_predmet, P.semestr
					FROM materials M INNER JOIN predmets P ON M.predmetid=P.id
					ORDER BY M.dateadd DESC LIMIT {$countMaterialsOnStartPage}") as $material){ ?>
				<tr><td class="td_material"><a href="http://student48.ru/materials/semestr<?=$material['semestr']?>/"><?=$material['semestr']?></a></td>
					<td class="td_material_predmet"><a href="http://student48.ru/materials/<?=$material['title_predmet_english']?>/"><?=$material['title_predmet']?></a></td>
					<td class="td_material"><a href="http://localhost/student48/downloads/<?=$material['id']?>/"><?=$material['title_material']?></a></td>
					<td class="td_material_filesize"><?=$material['filesize']?> Кб</td>
					<td class="td_material_filesize"><?=$material['downloads']?></td>
					<td class="td_material"><a href="http://localhost/student48/downloads/<?=$material['id']?>/"><center><span class="glyphicon glyphicon-download-alt"></span></center></a></td>
				</tr>
			<?}?>
			</tbody>
		</table>                

<? require($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?>

<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>
		<title>ЛГТУ | Главная страница</title>
<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>

<blockquote>
<?
$rowCount = $dbWorker->query('SELECT COUNT(*) FROM quote;')->fetch()[0];
$dbQuote = $dbWorker->prepare('SELECT * FROM quote LIMIT :randValue, 1');
$dbQuote->bindParam(':randValue',$randValue,PDO::PARAM_INT);
$randValue = rand(0, $rowCount-1);
if($dbQuote->execute())
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
		<h5>Добавлено:<?=date('d.m.Y г. ',strtotime($news['datecreate']));?>  Просмотров:<?=$news['views']?></h5>
		<br>
		<?=$news['introtext']?>
		<p><a class="btn btn-info" href="http://<?=$_SERVER['SERVER_NAME']?>/news/<?=$news['id']?>/">Подробнее »</a></p>
	</div>
	<?
	}
	?>
</div>
<div class="row">
	<h2>Последние добавления материалов:</h2>
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
		<?
		$materials = $dbWorker->prepare("SELECT	M.id, M.title_material, M.filesize, M.downloads,
				P.title_predmet_english, P.title_predmet, P.semestr
			FROM materials M INNER JOIN predmets P ON M.predmetid=P.id
			ORDER BY M.dateadd DESC LIMIT :count");
		$materials->bindParam(':count', $countMaterialsOnStartPage, PDO::PARAM_INT);
		if($materials->execute()) {
			while ($material = $materials->fetch()) { ?>
				<tr>
					<td class="td_material"><a
							href="/materials/semestr<?= $material['semestr'] ?>/"><?= $material['semestr'] ?></a>
					</td>
					<td class="td_material_predmet"><a
							href="/materials/<?= $material['title_predmet_english'] ?>/"><?= $material['title_predmet'] ?></a>
					</td>
					<td class="td_material"><a
							href="/downloads/<?= $material['id'] ?>/"><?= $material['title_material'] ?></a></td>
					<td class="td_material_filesize"><?= $material['filesize'] ?> Кб</td>
					<td class="td_material_filesize"><?= $material['downloads'] ?></td>
					<td class="td_material"><a href="/downloads/<?= $material['id'] ?>/">
							<center><span class="glyphicon glyphicon-download-alt"></span></center>
						</a>
					</td>
				</tr>
			<?
			}
		}?>
		</tbody>
	</table>
</div>
<div class="row">
	<h2>Последние сообщения в <a href="/questbook/">гостевой</a>:</h2>
	<?
	$questbookDb = $dbWorker->prepare("SELECT * FROM questbook ORDER BY id DESC LIMIT 3");
	$questbookDb->execute();
	while($pagedata=$questbookDb->fetch()){?>
		<table class="table table-striped table-bordered table-condensed">
			<tr>
				<td><?=$pagedata['user']?>: <?=$pagedata['title_message']?>
					<div class="pull-right">Добавлено: <?=date('d.m.Y г. h:i',strtotime($pagedata['dateadd']));?>
					</div>
				</td>
			</tr>
			<tr><td><?=$pagedata['message']?></td></tr>
		</table>
	<?	}?>
</div>
<? require($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?>

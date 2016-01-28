<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>
<title>ЛГТУ | Поиск</title>
<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>

<? require_once($_SERVER['DOCUMENT_ROOT'].'/include/sphinxapi.php');?>
<?
$query = '*'.str_replace(' ','* *',htmlspecialchars($_REQUEST['q'])).'*';

$cl = new SphinxClient();
$cl->SetServer( "127.0.0.1", 9312 );

$cl->SetMatchMode(SPH_MATCH_ALL);
$cl->setIndexWeights (["title_material"=>40,"title_predmet"=>10]);
$resultMaterials = $cl->Query($query,"student48_index_materials"); // поисковый запрос
$materialIds = [];
if ( $resultMaterials !== false ) {
	$materialIds = array_keys($resultMaterials['matches']);
}

$cl->setIndexWeights (["title_news"=>50,"introtext"=>30, "fullcontent"=>10]);
$resultNews = $cl->Query($query,"student48_index_news"); // поисковый запрос
$newsIds = [];
if ( $resultNews !== false ) {
	$newsIds = array_keys($resultNews['matches']);
}

$arMaterials = [];
if(count($materialIds)>0) {
	$qMarks = str_repeat('?,', count($materialIds) - 1) . '?';
	$queryMaterials = "SELECT M.id, M.title_material, M.metakey, M.predmetid, M.link, M.filesize, M.downloads, M.dateadd,
	P.title_predmet, P.title_predmet_english, P.semestr FROM materials M INNER JOIN predmets P ON M.predmetid=P.id WHERE M.id IN ($qMarks)";
	$dbMaterials = $dbWorker->prepare($queryMaterials);
	$dbMaterials->execute($materialIds);

	while ($material = $dbMaterials->fetch()) {
		$arMaterials[$material['id']] = $material;
	}
}

$arNews = [];
if(count($newsIds)>0) {
	$qMarks = str_repeat('?,', count($newsIds) - 1) . '?';
	$dbNews = $dbWorker->prepare("SELECT * FROM news WHERE id IN ($qMarks)");
	$dbNews->execute($newsIds);

	while ($news = $dbNews->fetch()) {
		$arNews[$news['id']] = $news;
	}
}
?>
<h1>Поиск по запросу "<?= htmlspecialchars($_REQUEST['q']);?>"</h1>
<?if(count($arMaterials)==0 && count($arMaterials)==0){?><h2>Результатов не найдено.</h2><?}?>
<?if(count($arMaterials)>0){?>
		<h4>Количество материалов: <?=$countMaterials?></h4>
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
			<? foreach($arMaterials as $material){ ?>
				<tr>
					<td class="td_material"><a href="/materials/semestr<?=$material['semestr']?>/"><?=$material['semestr']?></a></td>
					<td class="td_material_predmet"><a href="/materials/<?=$material['title_predmet_english']?>/"><?=$material['title_predmet']?></a></td>
					<td class="td_material"><a href="/downloads/<?=$material['id']?>/"><?=$material['title_material']?></a></td>
					<td class="td_material_filesize"><?=$material['filesize']?> Кб</td>
					<td class="td_material_filesize"><center><?=$material['downloads']?></center></td>
					<td class="td_material"><a href="/downloads/<?=$material['id']?>/"><center><span class="glyphicon glyphicon-download-alt"></span></center></a></td>
				</tr>
			<?}?>
			</tbody>
		</table>
<?}?>
<?if(count($arNews)>0){?>
	<p><h1>Новости:</h1>
	<hr>
	<? foreach($arNews as $news){ //выводим по 2 штуки в строку?>
		<div class="row">
			<div class="col-xs-6" align="justify">
				<h2><?=$news['title_news']?></h2>
				<h5>Добавлено: <?=date('d.m.Y г. h:i ',strtotime($news['datecreate']));?>  Просмотров:<?=$news['views']?></h5>
				<br>
				<p><?=$news['introtext']?></p>
				<p><a class="btn btn-info" href="http://<?=$_SERVER['SERVER_NAME']?>/news/<?=$news['id']?>/">Подробнее</a></p>
			</div>
		<?if($news = next($arNews)){ ?>
			<div class="col-xs-6" align="justify">
				<h2><?=$news['title_news']?></h2>
				<h5>Добавлено: <?=date('d.m.Y г. h:i ',strtotime($news['datecreate']));?>  Просмотров:<?=$news['views']?></h5>
				<br>
				<p><?=$news['introtext']?></p>
				<p><a class="btn btn-info" href="http://<?=$_SERVER['SERVER_NAME']?>/news/<?=$news['id']?>/">Подробнее</a></p>
			</div>
		<?}?>
		</div>
	<? } ?>
<?}?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?>

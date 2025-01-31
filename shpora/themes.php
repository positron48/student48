<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>
<?
$id=0;
if(isset($_GET['id'])){
	$id = intval($_GET['id']);

	$themdata = $dbWorker->prepare("SELECT * FROM shpora_themes WHERE shp_them_id = ?");
	$themdata->execute(array($id));
	$themdata=$themdata->fetch();

	$views=$themdata['shp_them_views']+1;
	$updateViews = $dbWorker->prepare("UPDATE shpora_themes SET shp_them_views = ? WHERE shp_them_id = ?");
	$updateViews->execute(array($views,$id));
}

$dbData = $dbWorker->prepare("SELECT * FROM shpora_messages WHERE shp_msg_them_id = ? ORDER BY shpora_messages.shp_msg_title+0 ASC ");
if($dbData->execute(array($id))) {
	while ($data = $dbData->fetch()) {
		$messages[] = $data;
	}
}else {
	$messages = array();
}

?>
		<title>ЛГТУ | Шпора <?=isset($themdata)?': '.$themdata['shp_them_title']:'';?></title>
<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>

<h1>Шпора!</h1>
<h3><a href="/shpora/">Вернуться к списку тем</a></h3>
	<table class="table table-striped table-bordered table-condensed">
<?	foreach($messages as $pagedata){ ?>
	<tr>
		<td class="shp_tr"><a href="/shpora/theme-<?=$id?>/<?=$pagedata['shp_msg_id']?>/"><?=$pagedata['shp_msg_title']?></a></td>
		<td class="shp_tr"><?=$pagedata['shp_msg_views']?></td>
	</tr>
<?}?>
	</table>

<? require($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?>

<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>
<?
	$dbThemes=$dbWorker->query("SELECT * FROM shpora_themes ORDER BY shp_them_title ASC");
	while($theme = $dbThemes->fetch()){
		$themes[]=$theme;
	}
?>
		<title>ЛГТУ | Шпоры</title>
<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>

<h1>Шпоры!</h1><br />
<table class="table table-striped table-bordered table-condensed">
    <tr><td>Тема</td><td>Предмет</td><td>Дата добавления</td><td>Просмотры</td></tr>
<?
foreach($themes as $pagedata)
{
?>
    <tr>
        <td><a href="/shpora/theme-<?=$pagedata['shp_them_id']?>/"><?=$pagedata['shp_them_title']?></a></td>
        <td><?=$pagedata['shp_them_predmet']?></td>
        <td><?=date('d.m.Y', strtotime($pagedata['shp_them_date']))?></td>
        <td><?=$pagedata['shp_them_views']?></td>
    </tr>
<?
}
?>
</table>

<? require($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?>
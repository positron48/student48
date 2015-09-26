<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>
<?
    $id=0;
    if(isset($_GET['id'])) {
        $id = intval($_GET['id']);
    }

    $theme_id=0;
    if(isset($_GET['theme_id']))
        $theme_id=intval($_GET['theme_id']);

    $pagedata=$dbWorker->query("SELECT * FROM shpora_messages WHERE shp_msg_id='$id'")->fetch();

    $views=$pagedata['shp_msg_views']+1;
    $dbWorker->query("UPDATE shpora_messages SET shp_msg_views='$views' WHERE shp_msg_id='$id'");
?>
	<title>ЛГТУ | Шпора <?=$pagedata['shp_msg_title']?></title>
<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>

<h1>Шпора!</h1>
<h4><a href="/shpora/theme-<?=$theme_id?>/">Вернуться к теме</a></h4>
<div class="shpora_msg">
    <h4>
        <?=$pagedata['shp_msg_title']?>
        <div class="pull-right">Просмотров:<?=$pagedata['shp_msg_views']?></div>
    </h4>
    <div class="shpora_msg_content">
        <?=$pagedata['shp_msg_content']?>
    </div>
</div>

<? require($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?>

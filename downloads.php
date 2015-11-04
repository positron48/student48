<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>
<?
$id=0;
if(isset($_GET['id']))
    $id=(int)htmlspecialchars($_GET['id']);

$material = $dbWorker->prepare("SELECT title_material, metakey, link, filesize, downloads, dateadd, title_predmet, semestr FROM materials M INNER JOIN predmets P ON M.predmetid=P.id WHERE M.id = ?");
if ($material->execute(array($id)))
    $material=$material->fetch();
else
    $material=array();

?>
<title>
    <?="ЛГТУ|Скачать: ".$material['title_material']." / ".$material['title_predmet']." (".$material['metakey'].")";?>
</title>
<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>

<h2>Информация о файле:</h2>
<table class="table table-striped table-bordered table-condensed">
    <tr><td><b>Название: </b></td><td> <?=$material['title_material']?></td></tr>
    <tr><td><b>Предмет: </b></td><td> <?=$material['title_predmet']?></td></tr>
    <tr><td><b>Добавлено: </b></td><td> <?=date('d.m.Y г. h:i ',strtotime($material['dateadd']));?></td></tr>
    <tr><td><b>Семестр: </b></td><td> <?=$material['semestr']?></td></tr>
    <tr><td><b>Размер: </b></td><td> <?=$material['filesize']?> Kb</td></tr>
    <tr><td><b>Cкачиваний: </b></td><td> <?=$material['downloads']?></td></tr>
</table>
<h4>Перед тем как скачать файл, ознакомьтесь, пожалуйста, с нашими условиями:</h4>
<p>1. Все материалы, расположенные на сайте выложены для ознакомления. За использование материалов в личных интересах
    администрация сайта ответственности не несет. Размещение на других ресурсах разрешается только в случае размещения
    ссылки на данный ресурс.</p>
<p>2. Все файлы, расположенные на сервере проверены на отсутствие вирусов, иные файлы, ссылки на которые расположены
    у нас, рекомендательно просим проверять антивирусными программами.</p>
<p>3. Все файлы мы предоставляем согласно схеме "AS IS" ("Как есть"), т.е. за все возможные последствия после их
    применения мы ответственности не несем.</p>
<p>4. Для скачивания нажмите правой кнопкой мыши на ссылке и выберите пункт "Сохранить как".</p>

<center>
</br>
<h4>Если скачивание не началось автоматически, перейдите по ссылке:</h4>
<a href="/<?=$material['link']?>" class="btn btn-success btn-lg">Скачать</a>
<?
$downloads=$material['downloads']+1;
$updateDownloads = $dbWorker->prepare("UPDATE materials SET downloads= ? WHERE id = ?");
$updateDownloads->execute(array($downloads,$id));
?>
</center>

<? require($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?>
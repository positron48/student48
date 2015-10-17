<? require($_SERVER['DOCUMENT_ROOT'] . "/include/head_before.php"); ?>
<?
$id=0;
if(isset($_GET['id']))
    $id=$_GET['id'];

$file = $dbWorker->query("SELECT * FROM uploads WHERE link='$id'")->fetch();
if(isset($file['link']) && $file['link']!=''){
    echo "<meta http-equiv='Refresh' content='10; url=script/downloadnow.php?id=$id'>";
}
$file_path = '../storage/'.$file['link'];
?>
<title>ЛГТУ | Обменник</title>

<? require($_SERVER['DOCUMENT_ROOT'] . "/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT'] . "/include/header.php"); ?>


<? if(isset($file['link']) && $file['link']!=''){?>
    <h2>Информация о файле:</h2>
    <table class="table table-striped table-bordered table-condensed">
        <tr><td><b>Название: </b></td><td> <?=$file['file_name_orig']?></td></tr>
        <tr><td><b>Транслитом: </b></td><td> <?=$file['file_name']?></td></tr>
        <tr><td><b>Добавлено: </b></td><td> <?=$file['date_add']?></td></tr>
        <tr><td><b>Последнее скачивание: </b></td><td> <?=$file['date_last_update']?></td></tr>
        <tr><td><b>Размер: </b></td><td> <?=(int)($file['file_size']/1024)?> Kb</td></tr>
        <tr><td><b>Cкачиваний: </b></td><td> <?=$file['downloads']?></td></tr>
    </table>

    <center>
        </br>
        <h4>Если скачивание не началось автоматически, перейдите по ссылке:</h4>
        <a href="script/downloadnow.php?id=<?=$file['link']?>" class="btn btn-success btn-lg">Скачать</a>
    </center>
<?}else{?>
    <h2>Информация о файле:</h2>
    <h4>Возможно, он никогда не существовал или был удален.</h4>
<?}?>

<? require($_SERVER['DOCUMENT_ROOT'] . "/include/footer.php"); ?>
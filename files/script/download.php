<? require($_SERVER['DOCUMENT_ROOT'] . "/include/head_before.php"); ?>
<?
$id=0;
if(isset($_GET['id']))
    $id=$_GET['id'];

$file = $dbWorker->query("SELECT * FROM uploads WHERE link='$id'")->fetch();
if(isset($file['link']) && $file['link']!=''){
    echo "<meta http-equiv='Refresh' content='10; url=script/downloadnow.php?id={$file['link']}'>";
}
$file_path = '../storage/'.$file['link'];
?>
<title>ЛГТУ | Обменник</title>

<? require($_SERVER['DOCUMENT_ROOT'] . "/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT'] . "/include/header.php"); ?>

<pre>
    <?print_r($file);?>
</pre>

<? require($_SERVER['DOCUMENT_ROOT'] . "/include/footer.php"); ?>
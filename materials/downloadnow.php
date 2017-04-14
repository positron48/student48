<?
require_once($_SERVER['DOCUMENT_ROOT'].'/include/database.php');

$id=0;
if(isset($_GET['id']))
    $id=$_GET['id'];

$material = $dbWorker->prepare("SELECT title_material, metakey, link, filesize, downloads, dateadd, title_predmet, semestr FROM materials M INNER JOIN predmets P ON M.predmetid=P.id WHERE M.id = ?");
if ($material->execute(array($id)))
    $material=$material->fetch();
else
    $material=array();

$file_path = '../'.$material['link'];
if (!is_file($file_path)) {
    header('HTTP/1.1 404 Not Found');
}else {
    $downloads=$material['downloads']+1;
    $updateDownloads = $dbWorker->prepare("UPDATE materials SET downloads= ? WHERE id = ?");
    $updateDownloads->execute(array($downloads,$id));

    $filename = substr($file_path,strripos($file_path,'/')+1);

    header("X-Sendfile: $file_path");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment;filename={$filename}");
    die();
}
?>
<pre>
    <?print_r($material);?>
</pre>

<?
require_once($_SERVER['DOCUMENT_ROOT'].'/include/database.php');

$id=0;
if(isset($_GET['id']))
    $id=$_GET['id'];

$file = $dbWorker->query("SELECT * FROM uploads WHERE link='$id'")->fetch();

$file_path = '../storage/'.$file['link'];
if (!is_file($file_path)) {
    header('HTTP/1.1 404 Not Found');
}else {
    $downloads = $file['downloads']+1;
    $dateUpdate = date("Y-m-d H:i:s ");
    $dbWorker->query("UPDATE uploads SET downloads='$downloads', date_last_update='$dateUpdate' WHERE link='$id'");

    header("X-Sendfile: $file_path");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment;filename={$file['file_name_orig']}");
    exit;
}
?>
<pre>
    <?print_r($file);?>
</pre>
?>
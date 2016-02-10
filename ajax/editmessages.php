<?
require_once($_SERVER['DOCUMENT_ROOT'].'/include/settings.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/include/database.php');

if(!$isAdmin){
    echo 'false';
    die();
}

$id = isset($_REQUEST['message_id'])?intval($_REQUEST['message_id']):0;

if($id>0){
    $message = $dbWorker->prepare("DELETE FROM questbook WHERE id = :id");
    $message->bindParam(':id', $id, PDO::PARAM_INT);
    if ($message->execute())
        echo 'true';
    else
        echo 'false';
}else{
    echo 'false';
}

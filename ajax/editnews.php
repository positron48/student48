<?
require_once($_SERVER['DOCUMENT_ROOT'].'/include/database.php');

$id = isset($_REQUEST['news_id'])?intval($_REQUEST['news_id']):0;
$title_news = isset($_REQUEST['title_news'])?trim(htmlspecialchars($_REQUEST['title_news'])):'';
$introtext = isset($_REQUEST['introtext'])?trim(htmlspecialchars_decode($_REQUEST['introtext'])):'';
$fullcontent = isset($_REQUEST['fullcontent'])?trim(htmlspecialchars_decode($_REQUEST['fullcontent'])):'';
$metakey = isset($_REQUEST['metakey'])?trim(htmlspecialchars($_REQUEST['metakey'])):'';
$datecreate = isset($_REQUEST['datecreate'])?trim(htmlspecialchars($_REQUEST['datecreate'])):date('Y-m-d H:i:s');
$dateupdate = date('Y-m-d H:i:s');
$dateview = isset($_REQUEST['dateview'])?trim(htmlspecialchars($_REQUEST['dateview'])):date('Y-m-d H:i:s');
$views = isset($_REQUEST['views'])?trim(htmlspecialchars($_REQUEST['views'])):0;


if($title_news!='' && $introtext!='' && $fullcontent!='') {
    if($id>0){
        $predmet = $dbWorker->prepare("UPDATE news SET
            title_news = :title_news,
            introtext = :introtext,
            fullcontent = :fullcontent,
            metakey = :metakey,
            datecreate = :datecreate,
            dateupdate = :dateupdate,
            dateview = :dateview,
            views = :views
        WHERE id = :id");
        $predmet->bindParam(':id', $id, PDO::PARAM_INT);
    }else{
        $predmet = $dbWorker->prepare("INSERT INTO news VALUES(NULL,:title_news,:introtext,:fullcontent,:metakey,:datecreate,:dateupdate,:dateview,:views)");
    }

    $predmet->bindParam(':title_news', $title_news);
    $predmet->bindParam(':introtext', $introtext);
    $predmet->bindParam(':fullcontent', $fullcontent);
    $predmet->bindParam(':metakey', $metakey);
    $predmet->bindParam(':datecreate', $datecreate);
    $predmet->bindParam(':dateupdate', $dateupdate);
    $predmet->bindParam(':dateview', $dateview);
    $predmet->bindParam(':views', $views);

    if ($predmet->execute())
        echo 'true';
    else
        echo print_r($predmet->errorInfo(),true).'false';
}elseif($id>0){
    $predmet = $dbWorker->prepare("DELETE FROM news WHERE id = :id");
    $predmet->bindParam(':id', $id, PDO::PARAM_INT);
    if ($predmet->execute())
        echo 'true';
    else
        echo 'false';
}else{
    echo 'false';
}

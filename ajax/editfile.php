<?
require_once($_SERVER['DOCUMENT_ROOT'].'/include/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/include/settings.php');

if(!$isAdmin){
    echo 'false';
    die();
}

$id = intval($_REQUEST['fileid']);
$semestr = intval($_REQUEST['semestr']);
$predmet = (string)htmlspecialchars($_REQUEST['predmet']);

$predmetId = 0;
$newPredmet = '';
if($predmet === 'another'){
    $newPredmet = (string) htmlspecialchars($_REQUEST['new_predmet']);
}else{
    $predmetId = $dbWorker->prepare("SELECT id FROM predmets WHERE semestr = :semestr AND title_predmet_english = :predmet");
    $predmetId->bindParam(':semestr',$semestr, PDO::PARAM_INT);
    $predmetId->bindParam(':predmet',$predmet);
    if($predmetId->execute())
        $predmetId = intval($predmetId->fetch()['id']);
}
$title = trim(htmlspecialchars($_REQUEST['title']));
$keywords = trim(htmlspecialchars($_REQUEST['keywords']));
$link = trim(htmlspecialchars($_REQUEST['link']));
$dateadd=date("Y-m-d H:i:s ");

if($title!='' && $link!='' && ($predmetId!=0 || ($predmet === 'another' && $newPredmet!=''))) {
    $insertMaterial = $dbWorker->prepare("UPDATE pm_files SET
            pmfiletitle = :title,
            pmfilepredmetid = :predmetId,
            pmfilemetakey = :keywords,
            pmfilename = :link,
            pmfilepredmetsemestr = :semestr,
            pmfilepredmetname = :newPredmet
        WHERE pmfileid = :id");

    $insertMaterial->bindParam(':title', $title);
    $insertMaterial->bindParam(':predmetId', $predmetId, PDO::PARAM_INT);
    $insertMaterial->bindParam(':keywords', $keywords);
    $insertMaterial->bindParam(':link', $link);
    $insertMaterial->bindParam(':semestr', $semestr, PDO::PARAM_INT);
    $insertMaterial->bindParam(':newPredmet', $newPredmet);
    $insertMaterial->bindParam(':id', $id, PDO::PARAM_INT);
//var_dump($dateadd);
    if ($insertMaterial->execute())
        echo 'true';
    else
        echo 'false';
}else{
    echo 'false';
}

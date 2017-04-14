<?
require_once($_SERVER['DOCUMENT_ROOT'].'/include/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/include/settings.php');

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
    $insertMaterial = $dbWorker->prepare("INSERT INTO pm_files VALUES(NULL,:title,:predmetId,:keywords,
    :link,0,:semestr,:newPredmet,'',:dateadd)");

    $insertMaterial->bindParam(':title', $title);
    $insertMaterial->bindParam(':predmetId', $predmetId, PDO::PARAM_INT);
    $insertMaterial->bindParam(':keywords', $keywords);
    $insertMaterial->bindParam(':link', $link);
    $insertMaterial->bindParam(':semestr', $semestr, PDO::PARAM_INT);
    $insertMaterial->bindParam(':newPredmet', $newPredmet);
    $insertMaterial->bindParam(':dateadd', $dateadd);

    if ($insertMaterial->execute()) {
        echo 'true';

        $headers = "MIME-Version: 1.0\nContent-type: text/html;\nFrom: admin@student48.ru\n";
        mail(ADMIN_MAIL, 'Student48.ru: added material to moderation', 'title: '.$title.PHP_EOL.'link: '.$link,$headers);
    }else {
        echo 'false';
    }
}else{
    echo 'false';
}

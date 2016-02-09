<?
require_once($_SERVER['DOCUMENT_ROOT'].'/include/settings.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/include/database.php');

if(!$isAdmin){
    echo 'false';
    die();
}

$id = isset($_REQUEST['predmet_id'])?intval($_REQUEST['predmet_id']):0;
$semestr = isset($_REQUEST['semestr'])?intval($_REQUEST['semestr']):'';
$title = isset($_REQUEST['title'])?trim(htmlspecialchars($_REQUEST['title'])):'';
$english_title = isset($_REQUEST['english_title'])?trim(htmlspecialchars($_REQUEST['english_title'])):'';

if($title!='' && $english_title!='' && $semestr>0) {
    if($id>0){
        $predmet = $dbWorker->prepare("UPDATE predmets SET
            semestr = :semestr,
            title_predmet = :title_predmet,
            title_predmet_english = :title_predmet_english
        WHERE id = :id");
        $predmet->bindParam(':id', $id, PDO::PARAM_INT);
    }else{
        $predmet = $dbWorker->prepare("INSERT INTO predmets VALUES(NULL,:title_predmet,:title_predmet_english,:semestr)");
    }

    $predmet->bindParam(':semestr', $semestr, PDO::PARAM_INT);
    $predmet->bindParam(':title_predmet', $title);
    $predmet->bindParam(':title_predmet_english', $english_title);

    if ($predmet->execute())
        echo 'true';
    else
        echo 'false';
}elseif($id>0){
    $predmet = $dbWorker->prepare("DELETE FROM predmets WHERE id = :id");
    $predmet->bindParam(':id', $id, PDO::PARAM_INT);
    if ($predmet->execute())
        echo 'true';
    else
        echo 'false';
}else{
    echo 'false';
}

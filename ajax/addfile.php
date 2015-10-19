<?
require_once($_SERVER['DOCUMENT_ROOT'].'/include/database.php');

$semestr = (int)$_REQUEST['semestr'];
$predmet = (string)htmlspecialchars($_REQUEST['predmet']);

$predmetId = '';
$newPredmet = '';
if($predmet === 'another'){
    $newPredmet = (string) htmlspecialchars($_REQUEST['new_predmet']);
}else{
    $predmetId = $dbWorker->query("SELECT id FROM predmets WHERE semestr = '$semestr' AND title_predmet_english='$predmet'")->fetch()['id'];
}
$title = (string)htmlspecialchars($_REQUEST['title']);
$keywords = (string)htmlspecialchars($_REQUEST['keywords']);
$link = (string)htmlspecialchars($_REQUEST['link']);
$dateadd=date("Y-m-d H:i:s ");

if($dbWorker->query("INSERT INTO pm_files VALUES(
    NULL,
    '$title',
    '$predmetId',
    '$keywords',
    '$link',
    0,
    $semestr,
    '$newPredmet',
    '',
    '$dateadd'
)"))
    echo 'true';
else
    echo 'false';


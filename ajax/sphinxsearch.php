<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/include/sphinxapi.php');

$cl = new SphinxClient();
$cl->SetServer( "127.0.0.1", 9312 );

$cl->SetMatchMode( SPH_MATCH_ANY  );
$cl->setIndexWeights (["title_material"=>40,"title_predmet"=>10]);
$resultMaterials = $cl->Query($_REQUEST['q'],"student48_index_materials"); // поисковый запрос
$materialIds = [];
if ( $resultMaterials !== false ) {
    $materialIds = array_keys($resultMaterials['matches']);
    //берем только первые 5 элементов
    $materialIds = array_slice($materialIds,0,5);
}

$cl->setIndexWeights (["title_news"=>50,"introtext"=>30, "fullcontent"=>10]);
$resultNews = $cl->Query($_REQUEST['q'],"student48_index_news"); // поисковый запрос
$newsIds = [];
if ( $resultNews !== false ) {
    $newsIds = array_keys($resultNews['matches']);
    //берем только первые 5 элементов
    $newsIds = array_slice($newsIds,0,5);
}

$arMaterials = [];
if(count($materialIds)>0) {
    $qMarks = str_repeat('?,', count($materialIds) - 1) . '?';
    $queryMaterials = "SELECT M.id, M.title_material, M.metakey, M.predmetid, M.link, M.filesize, M.downloads, M.dateadd,
	P.title_predmet, P.title_predmet_english, P.semestr FROM materials M INNER JOIN predmets P ON M.predmetid=P.id WHERE M.id IN ($qMarks)";
    $dbMaterials = $dbWorker->prepare($queryMaterials);
    $dbMaterials->execute($materialIds);

    while ($material = $dbMaterials->fetch()) {
        $arMaterials[$material['id']] = $material;
    }
}

$arNews = [];
if(count($newsIds)>0) {
    $qMarks = str_repeat('?,', count($newsIds) - 1) . '?';
    $dbNews = $dbWorker->prepare("SELECT * FROM news WHERE id IN ($qMarks)");
    $dbNews->execute($newsIds);

    while ($news = $dbNews->fetch()) {
        $arNews[$news['id']] = $news;
    }
}

if(count($arMaterials)>0 || count($arNews)>0){
    echo "<div id='searchResult'>";
    if(count($arMaterials)>0 && count($arNews)>0){
        echo "<div class='searchHead'>Материалы</div>";
        foreach($arMaterials as $material){
            echo "<div class='searchItem'>";
            echo "<a href='/downloads/{$material['id']}/'>{$material['title_material']}</a>";
            echo " (<a href='/materials/{$material['title_predmet_english']}/semestr{$material['semestr']}/'>{$material['title_predmet']}</a>)";
            echo "</div>";
        }
    }
    if(count($arMaterials)>0 && count($arNews)>0){
        echo "<div class='searchHead'>Новости</div>";
        foreach($arNews as $news){
            echo "<div class='searchItem'>";
            $date = date('d.m.Y',strtotime($news['datecreate']));
            echo "<a href='/news/{$news['id']}/'>{$news['title_news']} ($date)</a>";
            echo "</div>";
        }
    }
    echo "</div>";
<?}
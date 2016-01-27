<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/sphinxapi.php');

// Создадим объект - клиент сфинкса и подключимся к нашей службе
$cl = new SphinxClient();
$cl->SetServer( "127.0.0.1", 9312 );

// Собственно поиск
$cl->SetMatchMode( SPH_MATCH_ANY  ); // ищем хотя бы 1 слово из поисковой фразы

$cl->setIndexWeights (["title_material"=>40,"title_predmet"=>10]);

$resultMaterials = $cl->Query($_REQUEST['q'],"student48_index_materials"); // поисковый запрос
if ( $resultMaterials === false ) {
    echo "Query failed: " . $cl->GetLastError() . ".\n"; // выводим ошибку если произошла
}
$cl->setIndexWeights (["title_news"=>50,"introtext"=>30, "fullcontent"=>10]);
$resultNews = $cl->Query($_REQUEST['q'],"student48_index_news"); // поисковый запрос
if ( $resultNews === false ) {
    echo "Query failed: " . $cl->GetLastError() . ".\n"; // выводим ошибку если произошла
}
echo "<pre>Materials:\n";
print_r($resultMaterials);
echo "</pre>";
echo "<pre>News:\n";
print_r($resultNews);
echo "</pre>";
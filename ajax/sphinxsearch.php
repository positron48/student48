<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/sphinxapi.php');

// Создаем объект клиента для Sphinx API
$sphinx = new SphinxClient();

// Подсоединяемся к Sphinx-серверу
$sphinx->SetServer('localhost', 3306);

// Совпадение по любому слову
$sphinx->SetMatchMode(SPH_MATCH_ANY);

// Результаты сортировать по релевантности
$sphinx->SetSortMode(SPH_SORT_RELEVANCE);

// Результат по запросу (* - использование всех индексов)
echo $_REQUEST['q'].":<br>\n";
$result = $sphinx->Query($_REQUEST['q'], 'student48_index_news');

if($result){
    echo '<pre>';
    print_r($result);
    echo '</pre>';
}
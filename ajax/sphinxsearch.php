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
$result = $sphinx->Query($_REQUEST['q'], '*');

if($result){
    echo '<pre>';
    print_r($result);
    echo '</pre>';
}
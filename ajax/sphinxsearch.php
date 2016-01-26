<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/sphinxapi.php');

// Создадим объект - клиент сфинкса и подключимся к нашей службе
$cl = new SphinxClient();
$cl->SetServer( "localhost", 3306 );

// Собственно поиск
$cl->SetMatchMode( SPH_MATCH_ANY  ); // ищем хотя бы 1 слово из поисковой фразы
$result = $cl->Query("computer"); // поисковый запрос

// обработка результатов запроса
if ( $result === false ) {
    echo "Query failed: " . $cl->GetLastError() . ".\n"; // выводим ошибку если произошла
}
else {
    if ( $cl->GetLastWarning() ) {
        echo "WARNING: " . $cl->GetLastWarning() . " // выводим предупреждение если оно было
    ";
    }

    if ( ! empty($result["matches"]) ) { // если есть результаты поиска - обрабатываем их
        foreach ( $result["matches"] as $product => $info ) {
            echo $product . "<br />"; // просто выводим id найденных товаров
        }
    }
}
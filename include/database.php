<?php
try {
    $dbWorker = new PDO('mysql:host=localhost;dbname=student48;charset=utf8', 'student48', 'positron48rus');
} catch (PDOException $e) {
    print "Ошибка подключения к базе данных: " . $e->getMessage() . "<br/>";
    die();
}
?>

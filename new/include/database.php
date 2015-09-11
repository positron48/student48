<?php
try {
    $dbWorker = new PDO('mysql:host=localhost;dbname=student48;charset=utf8', 'root', 'positron48rus');
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
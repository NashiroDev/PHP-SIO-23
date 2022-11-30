<?php

try {
    $db = new PDO(
        'mysql:host=dataBase;dbname=data_site;charset=utf8mb4',
        'root'
    );
} catch (PDOException $e) {
    die("Erreur : ".$e->getMessage());
}
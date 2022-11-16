<?php

session_start();

include_once('/app/config/variables.php');
include_once($rootPath.'requests/users.php');
include_once($rootPath.'config/mysql.php');

if (
    !empty($_POST['id']) && !empty($_POST['token'])
    && $_POST['token'] === $_SESSION['token']
) {
    if (deleteUser($_POST['id'])) {
        $_SESSION['message']['success'] = "Utilisateur supprimé avec succès.";
    } else {
        $_SESSION['message']['error'] = "Une erreur est survenue, veuillez réessayer.";
    }
} else {
    $_SESSION['message']['error'] = "Une erreur est survenue, veuillez réessayer.";
}

header("LOCATION:$rootUrl/admin/users");


?>
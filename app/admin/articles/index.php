<?php

session_start(); //on top

include_once('/app/config/variables.php');
include_once($rootPath . 'requests/articles.php');
include_once($rootPath . 'config/mysql.php');

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?= $stylePath ?>main.css">
    <link rel="stylesheet" href="<?= $stylePath ?>articles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>ADMIN - Articles</title>
</head>

<body>

    <?php include_once($rootTemplates . 'header.php'); ?>

    <main>
        <?php include_once($rootTemplates . 'login.php'); ?>
        <?php if (isset($_SESSION['LOGGED_USER']) && in_array('ROLE_ADMIN', $_SESSION['LOGGED_USER']['roles'])) : ?>
            <section>
                <h1>Administration des articles</h1>
                <a href="<?= "$rootUrl/admin/articles/create.php"; ?>" class="btn btn-primary">Créer un article</a>
                <?php include_once($rootTemplates . 'messages.php') ?>

                <div class="list-articles">
                    <?php foreach (findAllArticlesWithUser() as $article) : ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h2><?= "$article[titre]" ?></h2>
                                </div>
                                <p class="card-text"><b>De : </b><?= "$article[nom] $article[prenom]"; ?></p>
                                <p class="card-text"><?= "$article[description]"; ?></p>
                                <p class="card-text">Date : <?= "$article[date]"; ?></p>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </section>
        <?php elseif (isset($_SESSION['LOGGED_USER'])) : ?>
            <section>
                <div class="alert alert-danger">
                    <p>Vous n'avez pas les droits pour cette page</p>
                </div>
            </section>
        <?php endif; ?>
    </main>


    <?php include_once($rootTemplates . 'footer.php'); ?>

</body>


</html>
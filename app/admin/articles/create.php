<?php

session_start(); //on top

include_once('/app/config/variables.php');
include_once($rootPath . 'requests/articles.php');

if (!empty($_POST['titre']) && !empty($_POST['description'])) {
    $token = filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

    if (!$token || $token !== $_SESSION['token']) {
        $errorMessage = 'une erreur est survenue, token invalide.';
    } else {
        $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);
        $description = strip_tags($_POST['description']);

        if (createArticle($_POST['titre'], $_POST['description'], (new DateTime())->format('Y-m-d_H:i:s'), $_SESSION['LOGGED_USER']['id'])) {

            $_SESSION['message']['success'] = "Article created successfully";

            header("Location:$rootUrl/admin/articles");
        } else {

            $errorMessage = 'Une erreur est survenue';
        }
    }
} else {
    $_SESSION['token'] = bin2hex(random_bytes(35));
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?= $stylePath ?>main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>Création - My App PHP</title>
</head>

<body>

    <?php include_once($rootTemplates . 'header.php'); ?>

    <main>
        <section>
            <?php if (isset($_SESSION['LOGGED_USER']) && in_array('ROLE_ADMIN', $_SESSION['LOGGED_USER']['roles'])) : ?>
                <?php if (!isset($response)) : ?>
                    <div class="form-content">
                        <h1>Creation</h1>
                        <?php if (isset($errorMessage)) : ?>
                            <div class="alert alert-danger">
                                <p><?= $errorMessage; ?></p>
                            </div>
                        <?php endif; ?>
                        <form action="<?php $_SERVER['REQUEST_URI']; ?>" method="POST" class="form form-create" enctype="multipart/form-data">
                            <div class="form-raw">
                                <div class="input-group">
                                    <label for="titre">Titre :</label>
                                    <input type="text" name="titre" placeholder="Ceci est un titre" required>
                                </div>
                            </div>
                            <div class="form-raw">
                                <div class="input-group">
                                    <label for="description">Description :</label>
                                    <textarea name="description" rows="20" cols="33" placeholder="Ceci est une description" required></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                            <button type="submit" class="btn btn-primary">Créer</button>
                        </form>
                    </div>
                <?php else : ?>
                    <?php if ($response) : ?>
                        <div class="alert alert-success">
                            <p>Vous êtes bien inscrit sur notre application.</p>
                        </div>
                    <?php else : ?>
                        <div class="alert alert-danger">
                            <p>Une erreur est survenue.</p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
        </section>


    <?php endif; ?>
    </main>

    <?php include_once($rootTemplates . 'footer.php'); ?>

</body>

</html>
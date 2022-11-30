<?php

session_start();

include_once('config/variables.php');

if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    // check si le fichier existe et s'il n'y a pas d"erreurs
    if ($_FILES['image']['size'] <= 8000000) {
        // check si la taille du fichier est inferieure a 8M
        $fileInfo = pathinfo($_FILES['image']['name']);
        $extension = $fileInfo['extension'];
        $extensionAllowed = ['jpg', 'jpeg', 'png', 'pdf'];
        
        if(in_array($extension, $extensionAllowed)) {
            move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/'.str_replace(" ", "-", $_FILES['image']['name']));
            $uploaded = true;
        }
    }
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
    <title>Contact</title>
</head>
<body>
    <?php include_once($rootTemplates . 'header.php'); ?>
    <main>
        <section>
            <?php if (isset($_POST['nom']) && isset($_POST['age'])) : ?>
                <h1>Bonjour <?= strip_tags($_POST['nom']) ?></h1>
                <p>Tu t'appelles <?= strip_tags($_POST['nom']) ?> et tu as <?= strip_tags($_POST['age']) ?> ans.</p>
                <?= isset($uploaded) ? '<p> Ton fichier a bien été uploadé</p>' : null ?>
            <?php else : ?>
                <div class="alert alert-danger">
                    <p>Erreur, vous devez soumettre le formulaire</p>
                </div>

            <?php endif; ?>
        </section>
    </main>
    <?php include_once($rootTemplates . 'footer.php'); ?>
</body>
</html>
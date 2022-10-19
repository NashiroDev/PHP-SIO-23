<?php
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
                <h1>Erreur, vous devez soumettre le formulaire</h1>
            <?php endif; ?>
        </section>
    </main>
    <?php include_once($rootTemplates . 'footer.php'); ?>
</body>
</html>
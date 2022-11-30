<?php 

session_start(); //on top

include_once('config/variables.php');
include_once('requests/users.php');

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?= $stylePath ?>main.css">
    <link rel="stylesheet" href="<?= $stylePath ?>index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>PHP</title>
</head>

<body>
    
<?php include_once($rootTemplates . 'header.php'); ?>

    <main>
        <section>
            <?php var_dump(findAllUsers()); ?>
            <form action="contact.php" method="POST" enctype="multipart/form-data">
                <div>
                    <label for ="nom">Votre nom:</label>
                    <input type="text" name="nom">
                </div>
                <div>
                    <label for ="age">Votre age:</label>
                    <input type="number" name="age">
                </div>
                <div>
                    <label for ="image">Votre image:</label>
                    <input type="file" name="image">
                </div>
                <button type="submit">Envoyer</button>
            </form>
        </section>
    </main>

<?php include_once($rootTemplates . 'footer.php'); ?>

</body>

</html>
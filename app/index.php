<?php 

session_start(); //on top

include_once('config/variables.php');
$users = [
    [
    'nom' => 'Pauchon',
    'prenom' => 'Nathan',
    'email' => 'nathan.pauchon@les-charmilles.fr',
    'password' => '1234',
    ],
];
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

        <?php include_once($rootTemplates . 'login.php'); ?>

        <?php if(isset($_SESSION['LOGGED_USER'])) : ?>
            <section>
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
        <?php endif; ?>
    </main>

<?php include_once($rootTemplates . 'footer.php'); ?>

</body>

</html>
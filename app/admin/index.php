<?php 

session_start(); //on top

include_once('/app/config/variables.php');
include_once($rootPath.'requests/users.php');
include_once($rootPath.'config/mysql.php');

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
    <title>ADMIN - My App PHP</title>
</head>

<body>
    
<?php include_once($rootTemplates . 'header.php'); ?>

    <main>
        <?php include_once($rootTemplates . 'login.php'); ?>
        <?php if(isset($_SESSION['LOGGED_USER'])) : ?>
            <section>
                <h1>Administration du site</h1>
            </section>
        <?php endif; ?>
    </main>

<?php include_once($rootTemplates . 'footer.php'); ?>

</body>

</html>
<?php 

session_start(); //on top

include_once('/app/config/variables.php');
include_once($rootPath.'requests/users.php');
include_once($rootPath.'config/mysql.php');

$_SESSION['token'] = bin2hex(random_bytes(35));

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?= $stylePath ?>main.css">
    <link rel="stylesheet" href="<?= $stylePath ?>users.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>ADMIN - Users</title>
</head>

<body>
    
<?php include_once($rootTemplates . 'header.php'); ?>

    <main>
        <?php include_once($rootTemplates . 'login.php'); ?>
        <?php if(isset($_SESSION['LOGGED_USER']) && in_array('ROLE_ADMIN', $_SESSION['LOGGED_USER']['roles'])) : ?>
            <section>
                <h1>Administration des users</h1>
                <?php include_once($rootTemplates. 'messages.php'); ?>

                <div class="list-users">
                    <?php foreach(findAllUsers() as $user) : ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <?php if ($user['image']) : ?>
                                        <div class="card-img">
                                            <img src="/uploads/users/<?= $user['image']; ?>" alt="<?= "$user[nom] $user[prenom]"; ?>">
                                        </div>
                                    <?php endif; ?>
                                    <h2><?= "$user[nom] $user[prenom]"; ?></h2>
                                </div>
                                <p class="card-text">
                                    <b>Email</b> : <?= strip_tags($user['email']); ?>
                                </p>
                            </div>
                            <div class="card-btn">
                                <a href="<?= "$rootUrl/admin/users/update.php?id=$user[id]"; ?>" class="btn btn-success">Modifier</a>
                                <form action="<?= "$rootUrl/admin/users/delete.php"; ?>" method='POST' onsubmit="return confirm('Êtes-vous sur de vouloir supprimer ce user ?')">
                                    <input type="hidden" name="id" value="<?= $user['id']; ?>">
                                    <input type="hidden" name='token' value="<?= $_SESSION['token']; ?>">
                                    <button class="btn btn-danger">Supprimer</button>
                                </form>
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
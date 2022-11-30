<?php

session_start(); //on top

include_once('/app/config/variables.php');
include_once($rootPath . 'requests/users.php');
include_once($rootPath . 'config/mysql.php');

$user = findUserById((int) $_GET['id']);

if (!$user) {
    //user non trouvé
    $_SESSION['message']['error'] = "User not found";

    header("Location:$rootUrl/admin/users");
}

if (
    !empty($_POST['nom'])
    && !empty($_POST['prenom'])
    && !empty($_POST['email'])
    && !empty($_POST['roles'])
) {
    $token = filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

    if (!$token || $token !== $_SESSION['token']) {

        $errorMessage = 'Une erreur est survenue';
    } else {

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
        $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS);
        $roles = $_POST['roles'];

        if(isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            if($_FILES['image']['size'] < 8000000) {
                $fileInfo = pathinfo($_FILES['image']['name']);
                $extension = $fileInfo['extension'];
                $extensionAllowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                if(in_array($extension, $extensionAllowed)) {
                    $imageUploadName = str_replace(' ', '_', $fileInfo['filename']) . (new DateTime())->format('Y-m-d_H:i:s'). '.' . $fileInfo['extension'];

                    if (!empty($user['image'])) {
                        $imagePath = "/app/uploads/users/$user[image]";
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }
                    }

                    move_uploaded_file($_FILES['image']['tmp_name'], '/app/uploads/users/' . $imageUploadName);


                } else {
                    $errorMessage = "Fichier invalide, veuillez télécharger un fichier de type image.";
                }
            } else {
                $errorMessage = "Fichier trop volumineux, la limite est de 8M";
            }
        }

        if(!isset($errorMessage)) {
            if (updateUser($user['id'], $nom, $prenom, $email, $roles, isset($imageUploadName) ? $imageUploadName : null)) {

                $_SESSION['message']['success'] = "User updated successfully";
    
                header("Location:$rootUrl/admin/users");
            } else {
    
                $errorMessage = 'Une erreur est survenue';
            }
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
    <link rel="stylesheet" href="<?= $stylePath ?>users.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>ADMIN - Users</title>
</head>

<body>

    <?php include_once($rootTemplates . 'header.php'); ?>

    <main>
        <?php include_once($rootTemplates . 'login.php'); ?>
        <?php if (isset($_SESSION['LOGGED_USER']) && in_array('ROLE_ADMIN', $_SESSION['LOGGED_USER']['roles'])) : ?>
            <section>
                <div class="form-content">
                    <h1>Modifier</h1>
                    <?php if (isset($errorMessage)) : ?>
                        <div class="alert alert-danger">
                            <p><?= $errorMessage; ?></p>
                        </div>
                    <?php endif; ?>
                    <form action="<?php $_SERVER['REQUEST_URI']; ?>" method="POST" class="form form-register" enctype="multipart/form-data">
                        <?php if(!empty($user['image'])) : ?>
                            <div class="form-raw">
                                <div class="form-img">
                                    <img src="/uploads/users/<?= $user['image'] ?>" alt="<?= "$user[prenom] $user[nom]" ?>">
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="form-raw">
                            <div class="input-group">
                                <label for="nom">Nom:</label>
                                <input type="text" name="nom" placeholder="Doe" required value="<?= strip_tags($user['nom']) ?>">
                            </div>
                            <div class="input-group">
                                <label for="prenom">Prénom:</label>
                                <input type="text" name="prenom" placeholder="John" required value="<?= strip_tags($user['prenom']) ?>">
                            </div>
                        </div>
                        <div class="form-raw">
                            <div class="input-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" placeholder="john.doe@exemple.fr" required value="<?= strip_tags($user['email']) ?>">
                            </div>
                        </div>
                        <div class="form-raw">
                            <div class="input-group">
                                <label for="roles[]">User</label>
                                <input type="checkbox" name="roles[]" value="ROLE_USER" <?= in_array("ROLE_USER", json_decode($user['roles'])) ? 'checked' : null; ?>>
                                <label for="roles[]">Admin</label>
                                <input type="checkbox" name="roles[]" value="ROLE_ADMIN" <?= in_array("ROLE_ADMIN", json_decode($user['roles'])) ? 'checked' : null; ?>>
                            </div>
                        </div>
                        <div class="form-raw">
                            <div class="input-group">
                                <label for="image">Image :</label>
                                <input type=file name="image">
                            </div>
                        </div>
                        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </form>
                </div>
                <a href="<?= "$rootUrl/admin/users"; ?>" class="btn btn-success">Back to list</a>
            </section>
        <?php endif; ?>
    </main>
</body>
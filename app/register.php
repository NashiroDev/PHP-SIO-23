<?php 

session_start(); //on top

include_once('config/variables.php');
include_once('requests/users.php');

if (
    !empty($_POST['nom'])
    && !empty($_POST['prenom'])
    && !empty($_POST['email'])
    && !empty($_POST['password'])
) {
    $token = filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

    if (!$token || $token !== $_SESSION['token']) {
        $errorMessage = 'une erreur est survenue, token invalide.';
    } else {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
        $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = $_POST['password'];

        if(isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            if($_FILES['image']['size'] < 8000000) {
                $fileInfo = pathinfo($_FILES['image']['name']);
                $extension = $fileInfo['extension'];
                $extensionAllowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                if(in_array($extension, $extensionAllowed)) {
                    $imageUploadName = str_replace(' ', '_', $fileInfo['filename']) . (new DateTime())->format('Y-m-d_H:i:s'). '.' . $fileInfo['extension'];

                    move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/users/' . $imageUploadName);


                } else {
                    $errorMessage = "Fichier invalide, veuillez télécharger un fichier de type image.";
                }
            } else {
                $errorMessage = "Fichier trop volumineux, la limite est de 8M";
            }
        }

        $isEmailExist = findUserByEmail($email);

        if (!$isEmailExist && !isset($errorMessage)) {
            $response = addUser($nom, $prenom, $email, $password, isset($imageUploadName) ? $imageUploadName : null);
        } else {
            $errorMessage = isset($errorMessage) ? $errorMessage : "L'email est déja utilisé par un autre compte";
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
    <link rel="stylesheet" href="<?= $stylePath ?>index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>Inscription - My App PHP</title>
</head>

<body>
    
<?php include_once($rootTemplates . 'header.php'); ?>

    <main>
        <section>
            <?php if (!isset($response)) : ?>
            <div class="form-content">
                <h1>Inscription</h1>
                <?php if (isset($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <p><?= $errorMessage; ?></p>
                    </div>
                <?php endif; ?>
                <form action="<?php $_SERVER['REQUEST_URI']; ?>" method="POST" class="form form-register" enctype="multipart/form-data">
                    <div class="form-raw">
                        <div class="input-group">
                            <label for ="nom">Nom:</label>
                            <input type="text" name="nom" placeholder="Doe" required>
                        </div>
                        <div class="input-group">
                            <label for ="prenom">Prénom:</label>
                            <input type="text" name="prenom" placeholder="John" required>
                        </div>
                    </div>
                    <div class="form-raw">
                        <div class="input-group">
                            <label for ="email">Email:</label>
                            <input type="email" name="email" placeholder="john.doe@exemple.fr" required>
                        </div>
                        <div class="input-group">
                            <label for ="password">Password:</label>
                            <input type="password" name="password" placeholder="Ox6AfT4ZjjF5afee" required>
                        </div>
                    </div>
                    <div class="form-raw">
                        <div class="input-group">
                            <label for="image">Image :</label>
                            <input type=file name="image">
                        </div>
                    </div>
                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                    <button type="submit" class="btn btn-primary">S'inscrire</button>  
                </form>
            </div>
            <?php else: ?>
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
    </main>

<?php include_once($rootTemplates . 'footer.php'); ?>

</body>

</html>
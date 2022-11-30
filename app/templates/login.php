<?php

//validation du formulaire
if (isset($_POST['email']) && isset($_POST['password'])) {

    $user = findUserByEmail($_POST['email']);

    if ($user && password_verify($_POST['password'], $user['password'])) {
        //email trouvé en bdd
        $_SESSION['LOGGED_USER'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'roles' => json_decode($user['roles']),
        ];
    } else {
        $errorMessage = sprintf(
            "Les informations envoyées ne permettent pas de vous identifier : (%s/%s)",
            $_POST['email'],
            $_POST['password'],
        );
    }
}

?>

<?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
    <section>
        <div class="form-content">
            <h1>Connectez-vous</h1>
            <p>Pour avoir accès au site</p>
            <form action="<?= $_SERVER['REQUEST_URI']; ?>" class="form-login" method="POST">
                <?php if (isset($errorMessage)) : ?>
                <div class="alert alert-danger">
                    <?= $errorMessage ?>
                </div>
                <?php endif; ?> 
                <div class="form-raw">
                    <div class="input-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email">
                    </div>
                    <div class="input-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password">
                    </div>
                </div>
                <button class="btn btn-primary">Se connecter</button>
            </form>
        </div>
    </section>
<?php endif; 
<?php 

//validation du formulaire
if (isset($_POST['email']) && isset($_POST['password'])) {
    foreach($users as $user) {
        if ($user['email'] === $_POST['email'] && $user['password'] === $_POST['password']) { 
            $_SESSION['LOGGED_USER'] = [
                'email' => $user['email'],
                'nom' => $user['nom'],
                'prenom' => $user['prenom'],
            ];
        } else {
            $errorMessage = sprintf(
                "Les informations envoyées ne permettent pas de vous identifier : (%s/%s)",
                $_POST['email'],
                $_POST['password'],
            );
        }
    }
}

?>

<?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
    <section>
        <div class="form-login-area">
            <h1>Connectez-vous</h1>
            <p>Pour avoir accès au site</p>
            <form action="/" class="form-login" method="POST">
                <?php if (isset($errorMessage)) : ?>
                <div class="alert alert-danger">
                    <?= $errorMessage ?>
                </div>
                <?php endif; ?> 
                <div class="form-login-input">
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
<?php else : ?>
    <div class="alert alert-success">
        <p>Bonjour <strong><?php echo $_SESSION['LOGGED_USER']['prenom']." ". $_SESSION['LOGGED_USER']['nom']; ?></strong> et bienvenu sur le site !</p>
    </div>
<?php endif; 
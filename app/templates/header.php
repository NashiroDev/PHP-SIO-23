<header>
    <nav class="navbar">
        <div class="container navbar-content">
            <div class="logo">
                <a href="/"><b>My App PHP</b></a>
            </div>
            <ul class="navbar-list">
                <li><a href=contact.php>Contact</a></li>
                <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
                <li><a href="logout.php">Déconnexion</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>
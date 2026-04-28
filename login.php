<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Top Games - Connexion</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="css/auth.css"/>
</head>
<body>

    <!-- Menu -->
    <header class="header-section">
        <div class="container">
            <a class="site-logo" href="gamecontroller.php?p=home">
                <img src="img/logo.png" alt="">
            </a>
            <div class="user-panel">
                <a href="login.php">Login</a>  /  <a href="login.php?mode=register">Register</a>
            </div>
            <nav class="main-menu">
                <ul>
                    <li><a href="gamecontroller.php?p=home">Home</a></li>
                    <li><a href="gamecontroller.php?p=games">Games</a></li>
                    <li><a href="gamecontroller.php?p=categories">Blog</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">

                    <?php
                    if (!empty($_GET['error'])) {
                        echo '<div class="alert-box error">' . htmlspecialchars($_GET['error']) . '</div>';
                    }
                    if (!empty($_GET['success'])) {
                        echo '<div class="alert-box success">' . htmlspecialchars($_GET['success']) . '</div>';
                    }

                    $mode = (!empty($_GET['mode']) && $_GET['mode'] === 'register') ? 'register' : 'login';
                    ?>

                    <!-- Tabs -->
                    <div class="auth-tabs">
                        <a href="login.php" class="auth-tab <?= $mode === 'login' ? 'active' : '' ?>">Connexion</a>
                        <a href="login.php?mode=register" class="auth-tab <?= $mode === 'register' ? 'active' : '' ?>">Créer un compte</a>
                    </div>

                    <?php if ($mode === 'login'): ?>
                    <!-- Formulaire Connexion -->
                    <form class="auth-form" action="auth.php" method="POST">
                        <input type="hidden" name="action" value="login">
                        <div class="form-group">
                            <label>Nom d'utilisateur</label>
                            <input type="text" name="username" class="auth-input" required>
                        </div>
                        <div class="form-group">
                            <label>Mot de passe</label>
                            <input type="password" name="password" class="auth-input" required>
                        </div>
                        <button type="submit" class="site-btn" style="width:100%;">Se connecter</button>
                    </form>
                    <?php else: ?>
                    <!-- Formulaire Register -->
                    <form class="auth-form" action="auth.php" method="POST">
                        <input type="hidden" name="action" value="register">
                        <div class="form-group">
                            <label>Nom d'utilisateur</label>
                            <input type="text" name="username" class="auth-input" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="auth-input" required>
                        </div>
                        <div class="form-group">
                            <label>Mot de passe</label>
                            <input type="password" name="password" class="auth-input" required minlength="6">
                        </div>
                        <div class="form-group">
                            <label>Confirmer le mot de passe</label>
                            <input type="password" name="password_confirm" class="auth-input" required minlength="6">
                        </div>
                        <button type="submit" class="site-btn" style="width:100%;">Créer mon compte</button>
                    </form>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>

<script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>

<?php
session_start();

$host = 'localhost';
$dbname = 'Modex';
$username = 'root';
$password = 'root';

$mysqli = mysqli_connect($host, $username, $password, $dbname);
if (!$mysqli) {
    die('Erreur de connexion MySQL : ' . mysqli_connect_error());
}
mysqli_set_charset($mysqli, 'utf8');

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $passwordInput = trim($_POST['password'] ?? '');

    if (empty($email) || empty($passwordInput)) {
        $error = 'Veuillez remplir tous les champs.';
    } else {
        $query = 'SELECT id, password FROM users WHERE email = ? LIMIT 1';
        if ($stmt = mysqli_prepare($mysqli, $query)) {
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $userId, $userPassword);
            $found = mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            if ($found && !empty($userPassword) && password_verify($passwordInput, $userPassword)) {
                $_SESSION['user_id'] = $userId;
                header('Location: liste_annonces.php');
                exit;
            }

            $error = 'Identifiants incorrects.';
        } else {
            $error = 'Erreur de requête SQL.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Connexion</h1>
            <?php if ($error): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
                </div>
                <div class="input-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </form>
            <p class="help">Pas de compte ? Contactez l’administrateur.</p>
        </div>
    </div>
</body>

</html>
<?php
$host = 'localhost';
$dbname = 'Modex';
$username = 'root';
$password = 'root';

$mysqli = mysqli_connect($host, $username, $password, $dbname);
if (!$mysqli) {
    die('Erreur de connexion MySQL : ' . mysqli_connect_error());
}
mysqli_set_charset($mysqli, 'utf8');

$sql = "SELECT * FROM annonces";
$result = mysqli_query($mysqli, $sql);
$annonces = [];
while ($row = mysqli_fetch_assoc($result)) {
    $annonces[] = $row;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des annonces</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="main-container">
        <header class="header">
            <h1>Liste des annonces</h1>
            <a href="ajouter_annonce.php" class="btn btn-primary">Ajouter une annonce</a>
        </header>

        <div class="annonces-grid">
            <?php foreach ($annonces as $annonce): ?>
                <div class="annonce-card">
                    <img src="images/<?= htmlspecialchars($annonce["image"]) ?>" alt="Image de l'annonce" class="annonce-image">
                    <div class="annonce-content">
                        <h3 class="annonce-title"><?= htmlspecialchars($annonce["titre"]) ?></h3>
                        <p class="annonce-description"><?= htmlspecialchars($annonce["description"]) ?></p>
                        <p class="annonce-price">Prix : <?= htmlspecialchars($annonce["prix"]) ?> €</p>
                        <div class="annonce-actions">
                            <a href="modifier_annonce.php?id=<?= $annonce["id"] ?>" class="btn btn-secondary">Modifier</a>
                            <a href="supprimer_annonce.php?id=<?= $annonce["id"] ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">Supprimer</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>
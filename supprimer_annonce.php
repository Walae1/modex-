<?php
require "connexion.php";

$id = $_GET["id"];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["confirm"])) {
    $sql = "DELETE FROM annonces WHERE id = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: liste_annonces.php");
    exit();
}

$sql = "SELECT * FROM annonces WHERE id = ?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$annonce = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$annonce) {
    header("Location: liste_annonces.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer une annonce</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="main-container">
        <div class="form-card">
            <h1>Confirmer la suppression</h1>

            <div class="annonce-preview">
                <img src="images/<?= htmlspecialchars($annonce["image"]) ?>" alt="Image de l'annonce" class="preview-image">
                <h3 class="preview-title"><?= htmlspecialchars($annonce["titre"]) ?></h3>
                <p class="preview-description"><?= htmlspecialchars($annonce["description"]) ?></p>
                <p class="preview-price">Prix : <?= htmlspecialchars($annonce["prix"]) ?> €</p>
            </div>

            <p class="warning">Êtes-vous sûr de vouloir supprimer cette annonce ? Cette action est irréversible.</p>

            <form method="POST" style="display: inline;">
                <button type="submit" name="confirm" class="btn btn-danger">Confirmer la suppression</button>
            </form>

            <div class="form-actions">
                <a href="liste_annonces.php" class="btn btn-secondary">Annuler</a>
            </div>
        </div>
    </div>
</body>

</html>
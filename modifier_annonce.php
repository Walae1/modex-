<?php
require "connexion.php";

$id = $_GET["id"];

$sql = "SELECT * FROM annonces WHERE id = ?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$annonce = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST["titre"];
    $description = $_POST["description"];
    $prix = $_POST["prix"];

    $sql = "UPDATE annonces SET titre = ?, description = ?, prix = ? WHERE id = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 'ssdi', $titre, $description, $prix, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: liste_annonces.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une annonce</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="main-container">
        <div class="form-card">
            <h1>Modifier une annonce</h1>

            <form method="POST">
                <div class="input-group">
                    <label for="titre">Titre</label>
                    <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($annonce["titre"]) ?>" required>
                </div>

                <div class="input-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required><?= htmlspecialchars($annonce["description"]) ?></textarea>
                </div>

                <div class="input-group">
                    <label for="prix">Prix (€)</label>
                    <input type="number" id="prix" name="prix" value="<?= htmlspecialchars($annonce["prix"]) ?>" step="0.01" required>
                </div>

                <button type="submit" class="btn btn-primary">Modifier l'annonce</button>
            </form>

            <div class="form-actions">
                <a href="liste_annonces.php" class="btn btn-secondary">Retour à la liste</a>
            </div>
        </div>
    </div>
</body>

</html>
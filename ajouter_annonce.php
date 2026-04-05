<?php
require "connexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST["titre"];
    $description = $_POST["description"];
    $prix = $_POST["prix"];

    $image = $_FILES["image"]["name"];
    move_uploaded_file($_FILES["image"]["tmp_name"], "images/" . $image);

    $sql = "INSERT INTO annonces (titre, description, prix, image, user_id) VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($mysqli, $sql);
    $userId = 1;
    mysqli_stmt_bind_param($stmt, 'ssdsi', $titre, $description, $prix, $image, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo "<div class='alert alert-success'>Annonce ajoutée avec succès !</div>";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une annonce</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="main-container">
        <div class="form-card">
            <h1>Ajouter une annonce</h1>

            <form method="POST" enctype="multipart/form-data">
                <div class="input-group">
                    <label for="titre">Titre</label>
                    <input type="text" id="titre" name="titre" required>
                </div>

                <div class="input-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required></textarea>
                </div>

                <div class="input-group">
                    <label for="prix">Prix (€)</label>
                    <input type="number" id="prix" name="prix" step="0.01" required>
                </div>

                <div class="input-group">
                    <label for="image">Image</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>

                <button type="submit" class="btn btn-primary">Ajouter l'annonce</button>
            </form>

            <div class="form-actions">
                <a href="liste_annonces.php" class="btn btn-secondary">Retour à la liste</a>
            </div>
        </div>
    </div>
</body>

</html>

<?php

require_once "../database/connexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupérer les données du formulaire
    $nom = $_POST["nom_formation"];
    $description = $_POST["description"];
    $duree = $_POST["duree"];

    // Préparer la requête SQL
    $sql = "INSERT INTO formation (nom_formation, description, duree)
            VALUES (:nom, :description, :duree)";

    $stmt = $pdo->prepare($sql);

    // Exécuter la requête
    $stmt->execute([
        ":nom" => $nom,
        ":description" => $description,
        ":duree" => $duree
    ]);

    // Rediriger vers la liste
    header("Location: index.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une formation</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="form-container">

    <h1>Ajouter une formation</h1>
    <p class="form-description">
        Remplissez les informations de la nouvelle formation.
    </p>

    <form method="POST">

        <div class="form-group">
            <label>Nom de la formation</label>
            <input type="text" name="nom_formation"
                   placeholder="Ex : Développement Web" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description"
                      placeholder="Décrivez la formation..."></textarea>
        </div>

        <div class="form-group">
            <label>Durée (mois)</label>
            <input type="number" name="duree"
                   min="1" placeholder="Ex : 12" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                Ajouter la formation
            </button>

            <a href="index.php" class="btn-cancel">Annuler</a>
        </div>

    </form>

</div>

</body>
</html>

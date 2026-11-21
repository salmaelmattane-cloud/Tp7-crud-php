
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
</head>
<body>

    <h1>Ajouter une formation</h1>

    <form method="POST">

        <label>Nom de la formation :</label>
        <input type="text" name="nom_formation" required>

        <br><br>

        <label>Description :</label>
        <textarea name="description"></textarea>

        <br><br>

        <label>Durée (mois) :</label>
        <input type="number" name="duree" min="1" required>

        <br><br>

        <button type="submit">Ajouter</button>

    </form>

    <br>

    <a href="index.php">Retour à la liste</a>

</body>
</html>


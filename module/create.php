
<?php

require_once "../database/connexion.php";

// Récupérer les formations
$sql = "SELECT * FROM formation";
$stmt = $pdo->query($sql);
$formations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier l'envoi du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupérer les données
    $nom = $_POST["nom_module"];
    $description = $_POST["description"];
    $id_formation = $_POST["id_formation"];

    // Préparer la requête
    $sql = "INSERT INTO module (nom_module, description, id_formation)
            VALUES (:nom, :description, :id_formation)";

    $stmt = $pdo->prepare($sql);

    // Exécuter la requête
    $stmt->execute([
        ":nom" => $nom,
        ":description" => $description,
        ":id_formation" => $id_formation
    ]);

    // Redirection
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un module</title>
</head>
<body>

    <h1>Ajouter un module</h1>

    <form method="POST">

        <label>Nom du module :</label>
        <input type="text" name="nom_module" required>

        <br><br>

        <label>Description :</label>
        <textarea name="description"></textarea>

        <br><br>

        <label>Formation :</label>

        <select name="id_formation" required>

            <option value="">Choisir une formation</option>

            <?php foreach ($formations as $formation): ?>

                <option value="<?= $formation['id_formation'] ?>">
                    <?= htmlspecialchars($formation['nom_formation']) ?>
                </option>

            <?php endforeach; ?>

        </select>

        <br><br>

        <button type="submit">Ajouter</button>

    </form>

    <br>

    <a href="index.php">Retour à la liste</a>

</body>
</html>

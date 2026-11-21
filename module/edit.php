
<?php
require_once "../database/connexion.php";

// a. Récupérer l'identifiant
$id = (int) ($_GET["id"] ?? 0);

if ($id <= 0) {
    die("Identifiant invalide.");
}

// Charger les formations pour la liste déroulante
$sql = "SELECT * FROM formation";
$stmt = $pdo->query($sql);
$formations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// b. Charger les données du module
$sql = "SELECT * FROM module WHERE id_module = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([":id" => $id]);

$module = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$module) {
    die("Module introuvable.");
}

// Vérifier si le formulaire a été envoyé
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = $_POST["nom_module"];
    $description = $_POST["description"];
    $id_formation = $_POST["id_formation"];

    // d. Exécuter la requête UPDATE
    $sql = "UPDATE module
            SET nom_module = :nom,
                description = :description,
                id_formation = :id_formation
            WHERE id_module = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":nom" => $nom,
        ":description" => $description,
        ":id_formation" => $id_formation,
        ":id" => $id
    ]);

    // e. Rediriger vers la liste
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un module</title>
</head>
<body>

    <h1>Modifier un module</h1>

    <form method="POST" action="edit.php?id=<?= $id ?>">

        <label>Nom du module :</label>
        <input type="text" name="nom_module"
               value="<?= htmlspecialchars($module['nom_module']) ?>"
               required>

        <br><br>

        <label>Description :</label>
        <textarea name="description"><?= htmlspecialchars($module['description'] ?? '') ?></textarea>

        <br><br>

        <label>Formation :</label>

        <select name="id_formation" required>
            <?php foreach ($formations as $formation): ?>
                <option value="<?= $formation['id_formation'] ?>"
                    <?= ($formation['id_formation'] == $module['id_formation']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($formation['nom_formation']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <br><br>

        <button type="submit">Modifier</button>

    </form>

    <br>
    <a href="index.php">Retour à la liste</a>

</body>
</html>

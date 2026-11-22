
<?php
require_once "../database/connexion.php";

// Récupérer l'identifiant
$id = (int) ($_GET["id"] ?? 0);

if ($id <= 0) {
    die("Identifiant invalide.");
}

// Charger les formations
$sql = "SELECT * FROM formation";
$stmt = $pdo->query($sql);
$formations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Charger les données du module
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

    // Modifier le module
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

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un module</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="form-container">

    <h1>Modifier un module</h1>

    <p class="form-description">
        Modifiez les informations de ce module.
    </p>

    <form method="POST" action="edit.php?id=<?= $id ?>">

        <div class="form-group">
            <label>Nom du module :</label>
            <input type="text" name="nom_module"
                value="<?= htmlspecialchars($module['nom_module']) ?>"
                required>
        </div>

        <div class="form-group">
            <label>Description :</label>
            <textarea name="description"><?= htmlspecialchars($module['description'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label>Formation :</label>

            <select name="id_formation" required>
                <?php foreach ($formations as $formation): ?>
                    <option value="<?= $formation['id_formation'] ?>"
                        <?= ($formation['id_formation'] == $module['id_formation']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($formation['nom_formation']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                Enregistrer les modifications
            </button>

            <a href="index.php" class="btn-cancel">
                Annuler
            </a>
        </div>

    </form>

</div>

</body>
</html>


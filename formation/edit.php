

<?php
require_once "../database/connexion.php";

// Récupérer l'identifiant
$id = (int) ($_GET["id"] ?? 0);

if ($id <= 0) {
    die("Identifiant invalide.");
}

// Charger les données de la formation
$sql = "SELECT * FROM formation WHERE id_formation = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([":id" => $id]);

$formation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$formation) {
    die("Formation introuvable.");
}

// Vérifier si le formulaire a été envoyé
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = $_POST["nom_formation"];
    $description = $_POST["description"];
    $duree = $_POST["duree"];

    // Modifier la formation
    $sql = "UPDATE formation
            SET nom_formation = :nom,
                description = :description,
                duree = :duree
            WHERE id_formation = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":nom" => $nom,
        ":description" => $description,
        ":duree" => $duree,
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
    <title>Modifier une formation</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="form-container">

    <h1>Modifier une formation</h1>

    <p class="form-description">
        Modifiez les informations de cette formation.
    </p>

    <form method="POST" action="edit.php?id=<?= $id ?>">

        <div class="form-group">
            <label>Nom de la formation :</label>
            <input type="text" name="nom_formation"
                value="<?= htmlspecialchars($formation['nom_formation']) ?>"
                required>
        </div>

        <div class="form-group">
            <label>Description :</label>
            <textarea name="description"><?= htmlspecialchars($formation['description'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label>Durée (mois) :</label>
            <input type="number" name="duree"
                value="<?= htmlspecialchars($formation['duree'] ?? '') ?>"
                min="1" required>
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

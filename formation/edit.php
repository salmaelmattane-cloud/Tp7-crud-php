
<?php
require_once "../database/connexion.php";

// a. Récupérer l'identifiant
$id = (int) ($_GET["id"] ?? 0);

if ($id <= 0) {
    die("Identifiant invalide.");
}

// b. Charger les données de la formation
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

    // d. Exécuter la requête UPDATE
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

    // e. Rediriger vers la liste
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une formation</title>
</head>
<body>

    <h1>Modifier une formation</h1>

    <form method="POST" action="edit.php?id=<?= $id ?>">

        <label>Nom de la formation :</label>
        <input type="text" name="nom_formation"
               value="<?= htmlspecialchars($formation['nom_formation']) ?>"
               required>

        <br><br>

        <label>Description :</label>
        <textarea name="description"><?= htmlspecialchars($formation['description'] ?? '') ?></textarea>

        <br><br>

        <label>Durée (mois) :</label>
        <input type="number" name="duree"
               value="<?= htmlspecialchars($formation['duree'] ?? '') ?>"
               min="1" required>

        <br><br>

        <button type="submit">Modifier</button>

    </form>

    <br>
    <a href="index.php">Retour à la liste</a>

</body>
</html>


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

// Charger les données de l'étudiant
$sql = "SELECT * FROM etudiant WHERE id_etudiant = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([":id" => $id]);

$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$etudiant) {
    die("Étudiant introuvable.");
}

// Vérifier si le formulaire a été envoyé
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $id_formation = $_POST["id_formation"];

    // Modifier l'étudiant
    $sql = "UPDATE etudiant
            SET nom = :nom,
                prenom = :prenom,
                email = :email,
                id_formation = :id_formation
            WHERE id_etudiant = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":nom" => $nom,
        ":prenom" => $prenom,
        ":email" => $email,
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
    <title>Modifier un étudiant</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="form-container">

    <h1>Modifier un étudiant</h1>

    <p class="form-description">
        Modifiez les informations de cet étudiant.
    </p>

    <form method="POST" action="edit.php?id=<?= $id ?>">

        <div class="form-group">
            <label>Nom :</label>
            <input type="text" name="nom"
                value="<?= htmlspecialchars($etudiant['nom']) ?>"
                required>
        </div>

        <div class="form-group">
            <label>Prénom :</label>
            <input type="text" name="prenom"
                value="<?= htmlspecialchars($etudiant['prenom']) ?>"
                required>
        </div>

        <div class="form-group">
            <label>Email :</label>
            <input type="email" name="email"
                value="<?= htmlspecialchars($etudiant['email'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Formation :</label>

            <select name="id_formation" required>
                <?php foreach ($formations as $formation): ?>
                    <option value="<?= $formation['id_formation'] ?>"
                        <?= ($formation['id_formation'] == $etudiant['id_formation']) ? 'selected' : '' ?>>
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


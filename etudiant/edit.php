
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

// b. Charger les données de l'étudiant
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

    // d. Exécuter la requête UPDATE
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

    // e. Rediriger vers la liste
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un étudiant</title>
</head>
<body>

    <h1>Modifier un étudiant</h1>

    <form method="POST" action="edit.php?id=<?= $id ?>">

        <label>Nom :</label>
        <input type="text" name="nom"
               value="<?= htmlspecialchars($etudiant['nom']) ?>"
               required>

        <br><br>

        <label>Prénom :</label>
        <input type="text" name="prenom"
               value="<?= htmlspecialchars($etudiant['prenom']) ?>"
               required>

        <br><br>

        <label>Email :</label>
        <input type="email" name="email"
               value="<?= htmlspecialchars($etudiant['email'] ?? '') ?>">

        <br><br>

        <label>Formation :</label>

        <select name="id_formation" required>
            <?php foreach ($formations as $formation): ?>
                <option value="<?= $formation['id_formation'] ?>"
                    <?= ($formation['id_formation'] == $etudiant['id_formation']) ? 'selected' : '' ?>>
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

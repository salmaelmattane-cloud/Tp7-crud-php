
<?php

require_once "../database/connexion.php";

// Récupérer les formations pour remplir la liste
$sql = "SELECT * FROM formation";
$stmt = $pdo->query($sql);
$formations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si le formulaire est envoyé
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupérer les données
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $id_formation = $_POST["id_formation"];

    // Préparer la requête
    $sql = "INSERT INTO etudiant (nom, prenom, email, id_formation)
            VALUES (:nom, :prenom, :email, :id_formation)";

    $stmt = $pdo->prepare($sql);

    // Exécuter la requête
    $stmt->execute([
        ":nom" => $nom,
        ":prenom" => $prenom,
        ":email" => $email,
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
    <title>Ajouter un étudiant</title>
</head>
<body>

    <h1>Ajouter un étudiant</h1>

    <form method="POST">

        <label>Nom :</label>
        <input type="text" name="nom" required>

        <br><br>

        <label>Prénom :</label>
        <input type="text" name="prenom" required>

        <br><br>

        <label>Email :</label>
        <input type="email" name="email">

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


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

<
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un étudiant</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="form-container">

    <h1>Ajouter un étudiant</h1>
    <p class="form-description">
        Remplissez les informations de l'étudiant.
    </p>

    <form method="POST">

        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom"
                   placeholder="Nom de l'étudiant" required>
        </div>

        <div class="form-group">
            <label>Prénom</label>
            <input type="text" name="prenom"
                   placeholder="Prénom de l'étudiant" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email"
                   placeholder="exemple@gmail.com">
        </div>

        <div class="form-group">
            <label>Formation</label>
            <select name="id_formation" required>
                <option value="">Choisir une formation</option>

                <?php foreach ($formations as $formation): ?>
                    <option value="<?= $formation['id_formation'] ?>">
                        <?= htmlspecialchars($formation['nom_formation']) ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                Ajouter l'étudiant
            </button>

            <a href="index.php" class="btn-cancel">Annuler</a>
        </div>

    </form>

</div>

</body>
</html>

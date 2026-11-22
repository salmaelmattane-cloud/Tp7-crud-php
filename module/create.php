
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
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="form-container">

    <h1>Ajouter un module</h1>
    <p class="form-description">
        Remplissez les informations du nouveau module.
    </p>

    <form method="POST">

        <div class="form-group">
            <label>Nom du module</label>
            <input type="text" name="nom_module"
                   placeholder="Ex : HTML et CSS" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description"
                      placeholder="Décrivez le module..."></textarea>
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
                Ajouter le module
            </button>

            <a href="index.php" class="btn-cancel">Annuler</a>
        </div>

    </form>

</div>

</body>
</html>

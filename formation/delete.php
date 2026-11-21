
<?php
require_once "../database/connexion.php";

$message = "";

// a. Récupérer l'identifiant
if (isset($_GET["id"])) {

    $id = (int) $_GET["id"];

    if ($id > 0) {

        // Vérifier si la formation possède des étudiants
        $sql = "SELECT COUNT(*) FROM etudiant
                WHERE id_formation = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        $nbEtudiants = $stmt->fetchColumn();

        // Vérifier si la formation possède des modules
        $sql = "SELECT COUNT(*) FROM module
                WHERE id_formation = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        $nbModules = $stmt->fetchColumn();

        // Vérifier les relations avant la suppression
        if ($nbEtudiants > 0 || $nbModules > 0) {

            $message = "Impossible de supprimer cette formation :
                        elle contient encore des étudiants ou des modules.";

        } else {

            // b. Préparer la requête DELETE
            $sql = "DELETE FROM formation
                    WHERE id_formation = :id";
            $stmt = $pdo->prepare($sql);

            // c. Exécuter la requête
            $stmt->execute([":id" => $id]);

            // d. Rediriger vers la liste
            header("Location: index.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suppression d'une formation</title>
</head>
<body>

    <h1>Suppression d'une formation</h1>

    <p><?= htmlspecialchars($message) ?></p>

    <a href="index.php">Retour à la liste</a>

</body>
</html>

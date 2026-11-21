
<?php
require_once "../database/connexion.php";

// a. Récupérer l'identifiant
if (isset($_GET["id"])) {

    $id = (int) $_GET["id"];

    // b. Préparer la requête DELETE
    $sql = "DELETE FROM etudiant WHERE id_etudiant = :id";
    $stmt = $pdo->prepare($sql);

    // c. Exécuter la requête
    $stmt->execute([
        ":id" => $id
    ]);
}

// d. Rediriger vers la liste
header("Location: index.php");
exit;
?>

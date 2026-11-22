


<?php
require_once "../database/connexion.php";

$sql = "SELECT module.*, formation.nom_formation
        FROM module
        INNER JOIN formation
        ON module.id_formation = formation.id_formation";

$stmt = $pdo->query($sql);
$modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des modules</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<h1>Liste des modules</h1>

<a href="create.php">Ajouter un module</a>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nom du module</th>
        <th>Description</th>
        <th>Formation</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($modules as $module): ?>
    <tr>
        <td><?= htmlspecialchars($module["id_module"]) ?></td>
        <td><?= htmlspecialchars($module["nom_module"]) ?></td>
        <td><?= htmlspecialchars($module["description"] ?? "") ?></td>
        <td><?= htmlspecialchars($module["nom_formation"]) ?></td>

        <td>
            <a href="edit.php?id=<?= $module['id_module'] ?>">Modifier</a> |
            <a href="delete.php?id=<?= $module['id_module'] ?>">Supprimer</a>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

</body>
</html>

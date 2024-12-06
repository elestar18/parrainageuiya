<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['nom'])) {
    header('Location: login.php');
    exit;
}

$filieres = $_SESSION['filieres']; // Récupérer la filière du responsable
include('connect.php');


// Requête pour récupérer les données spécifiques à la filière
$sql = "SELECT * FROM associations WHERE filiere = :filieres";
$stmt = $pdo->prepare($sql);
$stmt->execute(['filieres' => $filieres]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord</title>
</head>
<body>
    <h1>Bienvenue, <?= htmlspecialchars($_SESSION['nom']); ?></h1>
    <h2>Filière : <?= htmlspecialchars($filieres); ?></h2>

    <h2>Liste des Associations</h2>
    <table border="1">
        <tr>
            <th>ID Association</th>
            <th>ID Étudiant Principal</th>
            <th>Nom Parrain</th>
            <th>Prénom Parrain</th>
            <th>Date Association</th>
        </tr>
        <?php foreach ($result as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']); ?></td>
            <td><?= htmlspecialchars($row['id_etudiant_principal']); ?></td>
            <td><?= htmlspecialchars($row['nom_parrain']); ?></td>
            <td><?= htmlspecialchars($row['prenom_parrain']); ?></td>
            <td><?= htmlspecialchars($row['date_association']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <a href="logout.php">Se déconnecter</a>
</body>
</html>

<?php
include('connect.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']); // Sécuriser l'entrée

    // Requête pour supprimer l'entrée
    $query = $pdo->prepare("DELETE FROM associations WHERE id = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);

    if ($query->execute()) {
        // Redirection après la suppression
        header("Location: afficherlisteparrainage.php");
        exit();
    } else {
        echo "Échec de la suppression.";
    }
} else {
    echo "ID manquant ou invalide.";
}
?>

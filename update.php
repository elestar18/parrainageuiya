<?php
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    // Récupérer les données envoyées par le formulaire
    $id = $_POST['id'];
    $id_etudiant_principal = $_POST['id_etudiant_principal'];
    $filiere = $_POST['filiere'];
    $nom_etudiant_principal = $_POST['nom_etudiant_principal'];
    $prenom_etudiant_principal = $_POST['prenom_etudiant_principal'];

    // Préparer la requête SQL de mise à jour
    $query = $pdo->prepare("UPDATE associations SET id_etudiant_principal = :id_etudiant_principal, filiere = :filiere, nom_etudiant_principal = :nom_etudiant_principal, prenom_etudiant_principal = :prenom_etudiant_principal WHERE id = :id");

    // Lier les paramètres
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->bindParam(':id_etudiant_principal', $id_etudiant_principal, PDO::PARAM_STR);
    $query->bindParam(':filiere', $filiere, PDO::PARAM_STR);
    $query->bindParam(':nom_etudiant_principal', $nom_etudiant_principal, PDO::PARAM_STR);
    $query->bindParam(':prenom_etudiant_principal', $prenom_etudiant_principal, PDO::PARAM_STR);

    // Exécuter la mise à jour
    if ($query->execute()) {
        // Redirection après la mise à jour
        header("Location: afficherlisteparrainage.php"); 
        exit();
    } else {
        echo "Erreur lors de la mise à jour.";
    }
} else {
    echo "Données invalides.";
}
?>

<?php
try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=localhost;dbname=test", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $message = "Connexion établie";
} catch (PDOException $e) {
    echo ("Erreur de connexion : " . $e->getMessage());
}

?>


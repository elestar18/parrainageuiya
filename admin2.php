<?php
session_start();
include('connect.php');

// Inscription d'un nouvel administrateur
if (isset($_POST['inscription'])) {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $motDePasse = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT);

    try {
        // Vérifier si l'email existe déjà
        $query = "SELECT COUNT(*) FROM administrateurs WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':email' => $email]);
        $emailExists = $stmt->fetchColumn();

        if ($emailExists) {
            $message = "Cet email est déjà utilisé. Veuillez en choisir un autre.";
        } else {
            // Insérer le nouvel administrateur
            $query = "INSERT INTO administrateurs (nom, email, mot_de_passe) VALUES (:nom, :email, :mot_de_passe)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':nom' => $nom,
                ':email' => $email,
                ':mot_de_passe' => $motDePasse
            ]);
            $message = "Inscription réussie. Vous pouvez maintenant vous connecter.";
        }
    } catch (PDOException $e) {
        $message = "Erreur lors de l'inscription : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Inscription</title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(135deg, #f0f8ff, #e6f3ff);
        color: #2c3e50;
        text-align: center;
        padding: 40px;
        min-height: 100vh;
        margin: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    form {
        background: #ffffff;
        padding: 30px 40px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 500px;
        margin: 20px auto;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    form:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    input[type="text"], 
    input[type="email"], 
    input[type="password"] {
        width: calc(100% - 24px);
        padding: 12px;
        margin: 12px 0;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    input[type="text"]:focus, 
    input[type="email"]:focus, 
    input[type="password"]:focus {
        border-color: #4a90e2;
        box-shadow: 0 0 8px rgba(74, 144, 226, 0.2);
        outline: none;
    }

    input[type="submit"] {
        width: 100%;
        padding: 14px;
        margin: 20px 0 10px;
        border: none;
        border-radius: 8px;
        background: linear-gradient(135deg, #4a90e2, #357abd);
        color: white;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    input[type="submit"]:hover {
        background: linear-gradient(135deg, #357abd, #2c5c8f);
        transform: translateY(-2px);
    }

    .message {
        margin: 20px 0;
        font-size: 1.2em;
        color: #2ecc71;
        animation: fadeIn 0.5s ease;
    }

    .error {
        color: #e74c3c;
        animation: shake 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }

    label {
        display: block;
        text-align: left;
        margin-top: 10px;
        color: #4a5568;
        font-weight: bold;
    }

    h2 {
        color: #2c5c8f;
        margin-bottom: 30px;
        font-size: 2.2em;
        animation: fadeIn 1s ease;
    }

    /* Style du bouton retour */
    .back-icon {
        position: fixed;
        top: 20px;
        left: 20px;
        color: #2c3e50;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        background: linear-gradient(135deg, #ffffff, #f5f5f5);
        border-radius: 25px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        font-weight: 500;
        font-size: 15px;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .back-icon:hover {
        transform: translateX(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        background: linear-gradient(135deg, #f5f5f5, #e8e8e8);
    }

    .back-icon i {
        font-size: 16px;
    }

    .back-icon:active {
        transform: translateX(-3px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
</style>

</head>
<body>
<a href="admin_traore.php" class="back-icon">
    <i class="fas fa-arrow-left"></i> Retour
</a>
    <h2>Inscription Administrateur</h2>
    <?php if (isset($message)): ?>
        <p class="<?php echo isset($emailExists) && $emailExists ? 'error' : 'message'; ?>">
            <?php echo $message; ?>
        </p>
    <?php endif; ?>
    <form method="POST">
        <label>Nom :</label>
        <input type="text" name="nom" required><br>
        <label>Email :</label>
        <input type="email" name="email" required><br>
        <label>Mot de passe :</label>
        <input type="password" name="mot_de_passe" required><br>
        <input type="submit" name="inscription" value="Inscrire">
    </form>
</body>
</html>

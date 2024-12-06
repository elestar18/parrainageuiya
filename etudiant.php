<?php
// Inclure le fichier de connexion à la base de données
include('connect.php');

// Démarrer une session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer et sécuriser les entrées utilisateur
    $matricule = htmlspecialchars(trim($_POST['matricule']));
    $filiere = htmlspecialchars(trim($_POST['filiere']));

    if (!empty($matricule) && !empty($filiere)) {
        try {
            // Préparer la requête SQL pour éviter les injections SQL
            $sql = "SELECT * FROM associations WHERE id_etudiant_principal = :matricule AND filiere = :filiere";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':matricule', $matricule, PDO::PARAM_STR);
            $stmt->bindParam(':filiere', $filiere, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // L'étudiant existe, démarrer une session et rediriger
                $_SESSION['matricule'] = $matricule;
                $_SESSION['filiere'] = $filiere;

                // Récupérer l'URL de redirection si définie, sinon utiliser une valeur par défaut
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                header("Location: espace_etudiant.php");
                exit();
            } else {
                $message = "Matricule ou filière incorrect";
            }
        } catch (PDOException $e) {
            $message = "Erreur lors de la connexion : " . $e->getMessage();
        }
    } else {
        $message = "Veuillez remplir tous les champs";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Étudiant</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 420px;
            backdrop-filter: blur(10px);
        }

        h2 {
            text-align: center;
            color: #2d3748;
            margin-bottom: 2rem;
            font-size: 1.8rem;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.6rem;
            color: #4a5568;
            font-weight: 500;
        }

        input, select {
            width: 100%;
            padding: 0.9rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #2193b0;
            box-shadow: 0 0 0 3px rgba(33, 147, 176, 0.1);
        }

        button {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: #4a5568;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #2d3748;
        }

        .error {
            color: #e53e3e;
            text-align: center;
            margin-bottom: 1.5rem;
            padding: 0.8rem;
            background-color: #fff5f5;
            border-radius: 8px;
            border: 1px solid #feb2b2;
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.9);
            color: #2193b0;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .back-button:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>
    <a href="index.php" class="back-button">Retour</a>
    <div class="login-container">
        <h2>Connexion Étudiant</h2>
        <?php if (!empty($message)) : ?>
            <p class="error"><?= $message; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="matricule">Matricule :</label>
                <input type="text" id="matricule" name="matricule" required>
            </div>
            <div class="form-group">
                <label for="filiere">Filière :</label>
                <select name="filiere" id="filiere" required>
                    <option value="IGL">IGL</option>
                    <option value="SE">SE</option>
                    <option value="DROIT">DROIT</option>
                    <option value="COM JTV">COM JTV</option>
                    <option value="COM RH">COM RH</option>
                    <option value="ANG">ANG</option>
                    <option value="GESTION">GESTION</option>
                </select>
            </div>
            <button type="submit">Se connecter</button>
        </form>
        <a href="index.php" class="back-link">Retour à l'accueil</a>
    </div>
</body>
</html>

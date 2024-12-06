<?php
session_start();
include('connect.php');

// Connexion d'un administrateur
if (isset($_POST['connexion'])) {
    $nom = trim(htmlspecialchars($_POST['nom']));
    $motDePasse = trim($_POST['mot_de_passe']);

    if (empty($nom) || empty($motDePasse)) {
        $message = "Veuillez remplir tous les champs.";
    } else {
        try {
            $query = "SELECT * FROM administrateurs WHERE nom = :nom LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->execute([':nom' => $nom]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin && password_verify($motDePasse, $admin['mot_de_passe'])) {
                // Régénérer l'ID de session pour prévenir la fixation de session
                session_regenerate_id(true);
                
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_nom'] = $admin['nom'];
                $_SESSION['last_activity'] = time();

                // Redirection basée sur le nom
                header("Location: " . (strtolower($nom) === 'traore' ? "admin_traore.php" : "admin_autres.php"));
                exit;
            } else {
                // Message générique pour ne pas révéler d'informations
                $message = "Identifiants incorrects.";
            }
        } catch (PDOException $e) {
            error_log("Erreur de connexion : " . $e->getMessage());
            $message = "Une erreur est survenue. Veuillez réessayer plus tard.";
        }
    }
}

// Déconnexion
if (isset($_GET['logout'])) {
    // Détruire toutes les variables de session
    $_SESSION = array();
    
    // Détruire le cookie de session si présent
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-3600, '/');
    }
    
    session_destroy();
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des Associations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<style>
/* Style global */
body {
    font-family: 'Roboto', Arial, sans-serif;
    background: linear-gradient(135deg, #1a2980, #26d0ce); /* Nouveau dégradé bleu */
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

/* Titre principal */
h2 {
    margin-top: 50px;
    font-size: 2.5rem; /* Taille légèrement augmentée */
    font-weight: 600; /* Texte plus épais */
    animation: fadeIn 1.5s ease-in-out;
    color: #ffffff; /* Contraste élevé pour la lisibilité */
}

/* Conteneur formulaire */
form {
    background: rgba(19, 198, 211, 0.95);
    backdrop-filter: blur(10px);
    padding: 40px;
    border-radius: 20px;
    width: 90%;
    max-width: 600px; /* Augmentation de la largeur maximale */
    margin: 30px auto;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    animation: formAppear 0.8s ease-out;
}

/* Style des labels */
form label {
    color: #333;
    display: block;
    font-size: 1.1rem;
    font-weight: bold;
    margin-bottom: 8px;
    text-align: left;
}

/* Champs de saisie */
form input[type="text"],
form input[type="password"] {
    width: calc(100% - 24px);
    padding: 15px;
    margin: 15px 0;
    background: rgba(255, 255, 255, 0.9);
    border: 2px solid transparent;
    border-radius: 8px;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

form input[type="text"]:focus,
form input[type="password"]:focus {
    border-color: #26d0ce;
    box-shadow: 0 0 15px rgba(38, 208, 206, 0.3);
    transform: translateY(-2px);
}

/* Bouton de soumission */
form input[type="submit"] {
    background: linear-gradient(45deg, #1a2980, #26d0ce);
    width: 100%;
    padding: 15px;
    margin-top: 20px;
    border-radius: 8px;
    font-size: 1.2rem;
    letter-spacing: 1px;
    transition: all 0.4s ease;
}

form input[type="submit"]:hover {
    background: linear-gradient(45deg, #26d0ce, #1a2980);
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

/* Nouvelle animation pour le formulaire */
@keyframes formAppear {
    0% {
        opacity: 0;
        transform: translateY(30px) scale(0.9);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Animation de pulsation pour les champs */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.02); }
    100% { transform: scale(1); }
}

form input:focus {
    animation: pulse 1.5s infinite;
}

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
/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-100px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Boutons standards */
button {
    background: linear-gradient(190deg, #4c74af, #5ce6e6);
    border: none;
    border-radius: 5px;
    color: white;
    font-size: 1rem;
    font-weight: bold;
    padding: 12px 25px;
    cursor: pointer;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease-in-out;
}

button:hover {
    background: linear-gradient(190deg, #2c0ce6, #07011d);
    transform: scale(1.1);
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.3);
}

button:active {
    transform: scale(0.95);
    box-shadow: 0 3px 5px rgba(0, 0, 0, 0.2);
}

/* Liens cliquables contenant des boutons */
a button {
    text-decoration: none;
    display: inline-block;
}

a {
    text-decoration: none;
    color: inherit; /* Hérite de la couleur pour s'intégrer naturellement */
}

/* Style des boutons et de la navigation */
.admin-actions {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-top: 30px;
    animation: fadeIn 0.8s ease-out;
}

.admin-actions button {
    background: linear-gradient(45deg, #1a2980, #26d0ce);
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.admin-actions button:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    background: linear-gradient(45deg, #26d0ce, #1a2980);
}

/* Style du titre de bienvenue */
h2 {
    color: white;
    font-size: 2.8rem;
    margin-bottom: 40px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    animation: welcomeAnimation 1s ease-out;
}

 
/* Nouvelles animations */
@keyframes welcomeAnimation {
    0% {
        opacity: 0;
        transform: translateY(-30px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Style du conteneur principal après connexion */
.admin-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 30px;
    padding: 20px;
    animation: fadeIn 0.8s ease-out;
}

/* Style des boutons et de la navigation */
.admin-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
}

.admin-buttons a {
    text-decoration: none;
}

.admin-buttons button {
    background: linear-gradient(45deg, #1a2980, #26d0ce);
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    text-transform: uppercase;
    letter-spacing: 1px;
    min-width: 250px;
}

.admin-buttons button:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    background: linear-gradient(45deg, #26d0ce, #1a2980);
}

/* Suppression du séparateur | et remplacement par un espacement */
.admin-buttons span {
    display: none;
}

/* Animation pour les boutons */
@keyframes buttonPop {
    0% {
        transform: scale(0.95);
        opacity: 0;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}
</style>
<body>
<a href="index.php" class="back-icon" style="position: absolute; top: 20px; left: 20px;">
        <i class="fas fa-arrow-left"></i> retour
    </a>
    <?php if (!isset($_SESSION['admin_id'])): ?>
        <!-- Formulaire de connexion -->
        <h2>Connexion Administrateur</h2>
        <?php if (isset($message)) echo "<p>$message</p>"; ?>
        <form method="POST">
            <label>NOM :</label>
            <input type="text" name="nom" required><br><br>
            <label>Mot de passe :</label>
            <input type="password" name="mot_de_passe" required><br><br>
            <input type="submit" name="connexion" value="Se connecter">
        </form>
    <?php else: ?>
        <!-- Interface après connexion -->
        <?php if (strtolower($_SESSION['admin_nom']) === 'traore'): ?>
            <div class="admin-container">
                <h2>Bienvenue, <?php echo $_SESSION['admin_nom']; ?> !</h2>
                <div class="admin-buttons">
                    <a href="admin_traore.php"><button>Aller à la gestion des associations</button></a>
                    <a href="?logout=true"><button>Se déconnecter</button></a>
                </div>
            </div>
        <?php else: ?>
            <div class="admin-container">
                <h2>Bienvenue, <?php echo $_SESSION['admin_nom']; ?> !</h2>
                <div class="admin-buttons">
                    <a href="admin_autres.php"><button>Gestion des associations</button></a>
                    <a href="?logout=true"><button>Se déconnecter</button></a>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</body>
    <script>
document.addEventListener("DOMContentLoaded", () => {
    // Ajouter une animation au focus des champs de saisie
    const inputs = document.querySelectorAll("form input[type='text'], form input[type='password']");

    inputs.forEach(input => {
        input.addEventListener("focus", () => {
            input.style.boxShadow = "0 0 10px #007BFF";
            input.style.transition = "box-shadow 0.3s ease-in-out";
        });

        input.addEventListener("blur", () => {
            input.style.boxShadow = "none";
        });
    });

    // Animation du bouton de soumission
    const submitButton = document.querySelector("form input[type='submit']");
    submitButton.addEventListener("mouseover", () => {
        submitButton.style.transform = "scale(1.1)";
    });

    submitButton.addEventListener("mouseout", () => {
        submitButton.style.transform = "scale(1)";
    });
});
</script>
</html>

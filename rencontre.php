<?php
include('connect.php');
?>
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $matricule_parrain = htmlspecialchars(trim($_POST['matricule_parrain']));
    $matricule_filleul = htmlspecialchars(trim($_POST['matricule_filleul']));
    $lieu = htmlspecialchars(trim($_POST['lieu']));
    $date_de_rencontre = htmlspecialchars(trim($_POST['date_de_rencontre']));
    $heur_debut = htmlspecialchars(trim($_POST['heur_debut']));
    $heur_fin = htmlspecialchars(trim($_POST['heur_fin']));
    $description = htmlspecialchars(trim($_POST['description']));
    $filiere = htmlspecialchars(trim($_POST['filiere']));

    if (!empty($matricule_parrain) && !empty($matricule_filleul) && !empty($lieu) && 
        !empty($date_de_rencontre) && !empty($heur_debut) && !empty($heur_fin) && 
        !empty($description) && !empty($filiere)) {
        try {
            $sql = "INSERT INTO rencontre (matricule_parrain, matricule_filleul, lieu, 
                    date_de_rencontre, heur_debut, Heur_fin, description, filiere) 
                    VALUES (:matricule_parrain, :matricule_filleul, :lieu, 
                    :date_de_rencontre, :heur_debut, :heur_fin, :description, :filiere)";
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':matricule_parrain', $matricule_parrain, PDO::PARAM_STR);
            $stmt->bindParam(':matricule_filleul', $matricule_filleul, PDO::PARAM_STR);
            $stmt->bindParam(':lieu', $lieu, PDO::PARAM_STR);
            $stmt->bindParam(':date_de_rencontre', $date_de_rencontre, PDO::PARAM_STR);
            $stmt->bindParam(':heur_debut', $heur_debut, PDO::PARAM_STR);
            $stmt->bindParam(':heur_fin', $heur_fin, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':filiere', $filiere, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $message = "Activité enregistrée avec succès!";
            } else {
                $message = "Erreur lors de l'enregistrement de l'activité.";
            }
        } catch (PDOException $e) {
            $message = "Erreur de base de données: " . $e->getMessage();
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENSEIGNER LA RENCONTRE</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        h1 {
            margin: 0 0 1rem 0;
            font-size: 2rem;
            text-align: center;
            color: #333;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .activity-form {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            width: 100%;
            max-width: 2000px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            border: 1px solid #eaeaea;
            margin: 0 auto;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 1.5rem;
            padding: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            margin-bottom: 0.6rem;
            display: block;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            margin-top: 0.4rem;
            padding: 10px 16px;
            width: 95%;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            background-color: #fff;
        }

        .activity-form button {
            padding: 1rem 3rem;
            font-size: 1.1rem;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(52, 152, 219, 0.2);
        }

        .activity-form button:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(52, 152, 219, 0.3);
        }

        .message, .error-message {
            text-align: center;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .message {
            color: green;
        }

        .error-message {
            color: red;
        }

        @media (max-width: 768px) {
            .activity-form {
                padding: 2rem;
                margin: 1rem;
            }
            
            .form-grid {
                gap: 1.5rem;
            }
        }

        .button-container {
            grid-column: 1 / -1;
            text-align: center;
            margin-top: 1rem;
        }

        .full-width {
            grid-column: 1 / -1;
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
    </style>
</head>
<body>  
<a href="espace_etudiant.php" class="back-icon">
    <i class="fas fa-arrow-left"></i> Retour
</a>        
    <main>
        <form class="activity-form" method="POST" action="">
        <h1>Renseigner la rencontre</h1>

            <?php if (isset($message)): ?>
                <p class="message <?= isset($message_type) ? $message_type : ''; ?>">
                    <?= $message; ?>
                </p>
            <?php endif; ?>
            <div class="form-grid">
                <div class="form-group">
                    <label for="matricule_parrain">Matricule Parrain :</label>
                    <input type="text" id="matricule_parrain" name="matricule_parrain" placeholder="Entrez le matricule du parrain" required>
                </div>

                <div class="form-group">
                    <label for="matricule_filleul">Matricule Filleul :</label>
                    <input type="text" id="matricule_filleul" name="matricule_filleul" placeholder="Entrez le matricule du filleul" required>
                </div>

                <div class="form-group">
                    <label for="date_de_rencontre">Date de la Rencontre :</label>
                    <input type="date" id="date_de_rencontre" name="date_de_rencontre" required>
                </div>

                <div class="form-group">
                    <label for="lieu">Lieu de la Rencontre :</label>
                    <input type="text" id="lieu" name="lieu" placeholder="Entrez le lieu" required>
                </div>

                <div class="form-group">
                    <label for="heur_debut">Heure de début :</label>
                    <input type="time" id="heur_debut" name="heur_debut" required>
                </div>

                <div class="form-group">
                    <label for="heur_fin">Heure de fin :</label>
                    <input type="time" id="heur_fin" name="heur_fin" required>
                </div>

                <div class="form-group">
                    <label for="filiere">Filière :</label>
                    <select id="filiere" name="filiere" required class="form-control">
                        <option value="">Sélectionnez une filière</option>
                        <option value="IGL">IGL</option>
                        <option value="SE">SE</option>
                        <option value="DROIT">DROIT</option>
                        <option value="COM JTV">COM JTV</option>
                        <option value="COM RH">COM RH</option>
                        <option value="ANG">ANG</option>
                        <option value="GESTION">GESTION</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label for="description">Description de l'Activité :</label>
                    <textarea id="description" name="description" rows="4" placeholder="Entrez une description" required></textarea>
                </div>
            </div>

            <div class="button-container">
                <button type="submit">Enregistrer</button>
            </div>
        </form>
    </main>
</body>
</html>

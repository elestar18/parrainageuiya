<?php
include('connect.php');
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $sql = "INSERT INTO activites (nom_parrain, filiere, date_rencontre, lieu, heure_debut, heure_fin, intitule, description) 
                VALUES (:nom_parrain, :filiere, :date, :lieu, :debut, :fin, :intitule, :description)";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            'nom_parrain' => $_POST['nom_parrain'],
            'filiere' => $_POST['filiere'], 
            'date' => $_POST['date'],
            'lieu' => $_POST['lieu'],
            'debut' => $_POST['debut'],
            'fin' => $_POST['fin'],
            'intitule' => $_POST['intitule'],
            'description' => $_POST['description']
        ]);

        echo "<script>alert('Activité enregistrée avec succès!');</script>";
    } catch(PDOException $e) {
        echo "<script>alert('Erreur lors de l\'enregistrement: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renseigner l'Activité</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e6f2ff;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .form-container {
            background: #ffffff;
            border-radius: 8px;
            padding: 3rem;
            width: 100%;
            max-width: 1200px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #b3d9ff;
        }

        h1 {
            margin: 0 0 1rem 0;
            font-size: 2rem;
            text-align: center;
            color: #0056b3;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        input,
        textarea,
        select {
            margin-top: 0.5rem;
            padding: 14px;
            width: 100%;
            max-width: 100%;
            border: 1px solid #99ccff;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #0056b3;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 86, 179, 0.2);
        }

        button {
            padding: 1rem 2rem;
            font-size: 1.1rem;
            margin: 1rem auto;
            display: block;
            background-color: #0056b3;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 4px;
            transition: background 0.3s, transform 0.2s;
            width: auto;
        }

        button:hover {
            background-color: #004080;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 2rem;
                margin: 1rem;
            }
        }

        form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .nav-buttons {
            text-align: left;
            margin-bottom: 2rem;
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
        <div class="form-container">
            <h1>Renseigner l'Activité</h1>
            <form method="POST" action="/test/activite.php">
                <div class="form-group">
                    <label for="nom_parrain">Nom du filleul :</label>
                    <input type="text" id="nom_parrain" name="nom_parrain" required>
                </div>
                <div class="form-group">
                    <label for="filiere">Filière :</label>
                    <select name="filiere" required>
                        <option value="IGL">IGL</option>
                        <option value="SE">SE</option>
                        <option value="DROIT">DROIT</option>
                        <option value="COM JTV">COM JTV</option>
                        <option value="COM RH">COM RH</option>
                        <option value="ANG">ANG</option>
                        <option value="GESTION">GESTION</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Date de la Rencontre :</label>
                    <input type="date" id="date" name="date">
                </div>
                <div class="form-group">
                    <label for="lieu">Lieu de la Rencontre :</label>
                    <input type="text" id="lieu" name="lieu" placeholder="Exemple : Salle 12">
                </div>
                <div class="form-group">
                    <label for="debut">Heure de début :</label>
                    <input type="time" id="debut" name="debut">
                </div>
                <div class="form-group">
                    <label for="fin">Heure de fin :</label>
                    <input type="time" id="fin" name="fin">
                </div>
                <div class="form-group full-width">
                    <label for="intitule">Intitulé de l'Activité :</label>
                    <input type="text" id="intitule" name="intitule" placeholder="Exemple : Atelier de programmation">
                </div>
                <div class="form-group full-width">
                    <label for="description">Description de l'Activité :</label>
                    <textarea id="description" name="description" placeholder="Décrivez brièvement l'activité"></textarea>
                </div>
                <div class="form-group full-width">
                    <button type="submit">Enregistrer l'Activité</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>

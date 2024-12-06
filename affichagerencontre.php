<?php
include('connect.php');
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage des Activités</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f2f5;
        }

        h1 {
            color: #1a73e8;
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 30px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        .filiere-section {
            margin: 20px 0;
            padding: 20px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .activites-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
            padding: 20px;
        }

        .activite-card {
            background: white;
            border: none;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .activite-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        .activite-card h3 {
            color: #1a73e8;
            margin-bottom: 15px;
            border-bottom: 2px solid #1a73e8;
            padding-bottom: 8px;
            font-size: 1.2em;
        }

        .activite-info {
            margin: 12px 0;
            line-height: 1.6;
        }

        .activite-info strong {
            color: #1a73e8;
            font-weight: 600;
            margin-right: 8px;
        }

        fieldset {
            border: 2px solid #1a73e8;
            border-radius: 12px;
            margin-bottom: 30px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
        }

        legend {
            color: #1a73e8;
            font-weight: bold;
            padding: 0 15px;
            font-size: 1.3em;
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <h1>Rencontres par Filière</h1>

    <?php
    $filieres = ['IGL', 'SE', 'DROIT', 'COM JTV', 'COM RH', 'ANG', 'GESTION'];

    foreach($filieres as $filiere) {
        try {
            $sql = "SELECT * FROM rencontre WHERE filiere = :filiere ORDER BY date_de_rencontre DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['filiere' => $filiere]);
            $activites = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(count($activites) > 0) {
                echo "<fieldset>";
                echo "<legend> $filiere</legend>";
                echo "<div class='activites-container'>";
                
                foreach($activites as $activite) {
                    echo "<div class='activite-card'>";
                    echo "<h3>Activité du " . htmlspecialchars($activite['date_de_rencontre']) . "</h3>";
                    echo "<div class='activite-info'><strong>Parrain:</strong> " . htmlspecialchars($activite['matricule_parrain']) . "</div>";
                    echo "<div class='activite-info'><strong>Filleul:</strong> " . htmlspecialchars($activite['matricule_filleul']) . "</div>";
                    echo "<div class='activite-info'><strong>Lieu:</strong> " . htmlspecialchars($activite['lieu']) . "</div>";
                    echo "<div class='activite-info'><strong>Horaire:</strong> " . htmlspecialchars($activite['heur_debut']) . " - " . htmlspecialchars($activite['Heur_fin']) . "</div>";
                    echo "<div class='activite-info'><strong>Description:</strong> " . htmlspecialchars($activite['description']) . "</div>";
                    echo "</div>";
                }
                
                echo "</div>";
                echo "</fieldset>";
            }
        } catch(PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
    ?>

</body>
</html>

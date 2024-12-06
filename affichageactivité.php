<?php
include('connect.php')
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Activités</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 15px;
        padding: 15px;
    }

    .activite-card {
        background: white;
        border: none;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        font-size: 0.95em;
    }

    .activite-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .activite-card h3 {
        color: #1a73e8;
        margin-bottom: 12px;
        border-bottom: 2px solid #1a73e8;
        padding-bottom: 8px;
        font-size: 1.1em;
    }

    .activite-info {
        margin: 8px 0;
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

    <h1>Activités par filières</h1>

    <?php
    try {
        $sql = "SELECT nom_parrain, filiere, date_rencontre, lieu, heure_debut, heure_fin, intitule, description 
                FROM activites 
                ORDER BY filiere, date_rencontre DESC";
        $stmt = $pdo->query($sql);
        
        if ($stmt->rowCount() > 0) {
            $currentFiliere = null;

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($currentFiliere !== $row['filiere']) {
                    if ($currentFiliere !== null) {
                        echo "</div></fieldset>"; // Close previous filiere section
                    }
                    $currentFiliere = $row['filiere'];
                    echo "<fieldset><legend>" . htmlspecialchars($currentFiliere) . "</legend><div class='activites-container'>";
                }

                echo "<div class='activite-card'>";
                echo "<h3>" . htmlspecialchars($row['intitule']) . "</h3>";
                echo "<div class='activite-info'><strong>Nom du Parrain:</strong> " . htmlspecialchars($row['nom_parrain']) . "</div>";
                echo "<div class='activite-info'><strong>Date:</strong> " . htmlspecialchars($row['date_rencontre']) . "</div>";
                echo "<div class='activite-info'><strong>Lieu:</strong> " . htmlspecialchars($row['lieu']) . "</div>";
                echo "<div class='activite-info'><strong>Début:</strong> " . htmlspecialchars($row['heure_debut']) . "</div>";
                echo "<div class='activite-info'><strong>Fin:</strong> " . htmlspecialchars($row['heure_fin']) . "</div>";
                echo "<div class='activite-info'><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</div>";
                echo "</div>";
            }
            echo "</div></fieldset>"; // Close last filiere section
        } else {
            echo "<p style='text-align: center; color: #666;'>Aucune activité n'a ��té enregistrée.</p>";
        }
    } catch(PDOException $e) {
        echo "<p style='text-align: center; color: red;'>Erreur : " . $e->getMessage() . "</p>";
    }
    ?>
</body>
</html>


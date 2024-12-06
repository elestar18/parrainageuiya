<?php include('connect.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche d'un Parrain</title>
    <style>

body {
            font-family: Arial, sans-serif;
            background-image: url('IMG-20241201-WA0396.jpg'); /* Remplacez par le chemin de votre image */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }

h1 {
    text-align: center;
    color:  #0056b3; /* Bleu foncé élégant */
    font-size: 2.5rem;
    margin-bottom: 20px;
}

form {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    max-width: 500px;
    margin: 0 auto;
    border: 2px solid #e6e6fa; /* Légère bordure bleutée */
}

label {
    font-weight: bold;
    color: #003366; /* Bleu foncé */
}

input[type="text"], select {
    width: 100%;
    padding: 10px;
    margin: 10px 0 20px;
    border-radius: 5px;
    border: 1px solid #ced4da;
    font-size: 1rem;
    color: #333;
    background-color: #f8f9ff; /* Fond légèrement bleuté */
    transition: border 0.3s ease, background-color 0.3s ease;
}

input[type="text"]:focus, select:focus {
    border-color: #0056b3; /* Bordure bleue à la mise au point */
    background-color: #eef3ff; /* Fond légèrement plus clair */
}

button {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #0f549e; /* Bleu principal */
    color: #ffffff;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #011830; /* Bleu foncé élégant */
}

fieldset {
    border: 1px solid #ced4da;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    background-color: #f8f9ff; /* Fond légèrement bleuté */
}

legend {
    font-size: 1.2rem;
    font-weight: bold;
    color: #003366;
}

.result-container {
    margin-top: 30px;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    max-width: 700px;
    margin: 20px auto;
    border: 2px solid #e6e6fa; /* Bordure douce */
}

.result-container p {
    margin: 10px 0;
    font-size: 1rem;
    color: #333333;
}

#resultsTable {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

#resultsTable th, #resultsTable td {
    border: 1px solid #dee2e6;
    padding: 10px;
    text-align: left;
}

#resultsTable th {
    background-color: #0056b3; /* Bleu principal */
    color: #ffffff;
    font-weight: bold;
}

#resultsTable tr:nth-child(even) {
    background-color: #f8f9ff; /* Bleu très clair */
}

#resultsTable tr:hover {
    background-color: #ffeeee; /* Rouge léger en survol */
}

.download-btn {
    display: block;
    padding: 10px 15px;
    background-color: #28a745; /* Vert */
    color: #ffffff;
    border: none;
    border-radius: 5px;
    text-align: center;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
    max-width: 200px;
    margin: 20px auto;
}

.download-btn:hover {
    background-color: #1e7a36;
}

a.back-icon {
    position: absolute;
    top: 20px;
    left: 20px;
    font-size: 1.2rem;
    color: #0056b3; /* Bleu principal */
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: color 0.3s ease;
}

a.back-icon:hover {
    color: #003366; /* Bleu foncé */
}

a.back-icon i {
    font-size: 1.5rem;
}
    </style>
</head>
<body>
    <a href="espace_etudiant.php" classe="back-icon">
        <i class="fas fa-arrow-left"></i> retour
    </a>
    
    <form method="POST" action="">
        <h1>Recherche d'un Parrain</h1>
        <label for="id_etudiant_principal">Entrez votre ID Étudiant Principal :</label>
        <input type="text" id="id_etudiant_principal" name="id_etudiant_principal" required>
        
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
        <br><br>
        
        <button type="submit">Rechercher</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            // Récupération et validation des entrées
            $id_etudiant_principal = filter_input(INPUT_POST, 'id_etudiant_principal', FILTER_SANITIZE_STRING);
            $filiere = filter_input(INPUT_POST, 'filiere', FILTER_SANITIZE_STRING);

            // Afficher les valeurs des variables pour le débogage
            echo "<div class='result-container'>";
            echo "<p>ID Étudiant Principal : $id_etudiant_principal</p>";
            echo "<p>Filière : $filiere</p>";

            if (!empty($id_etudiant_principal) && !empty($filiere)) {
                // Préparation de la requête
                $sql = "
                SELECT 
                    id,
                    id_etudiant_principal,
                    id_etudiant_associe,
                    filiere,
                    nom_etudiant_principal,
                    prenom_etudiant_principal,
                    nom_parrain,
                    prenom_parrain,
                    contact_parrain
                FROM 
                    associations
                WHERE 
                    id_etudiant_principal = :id_etudiant_principal 
                    AND filiere = :filiere";

                // Préparation et exécution avec PDO
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['id_etudiant_principal' => $id_etudiant_principal, 'filiere' => $filiere]);

                // Affichage du nombre de résultats pour le débogage
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo "<p>Nombre de résultats : " . count($result) . "</p>";

                if (count($result) > 0) {
                    echo "<h2>Informations de votre parrain :</h2>";
                    echo "<table id='resultsTable'  border=2>";
                    echo "<thead><tr><th>ID Étudiant Principal</th><th>ID Étudiant Associé</th><th>Filière</th><th>Nom Parrain</th><th>Prénom Parrain</th><th>Contact Parrain</th></tr></thead>";
                    echo "<tbody>";
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id_etudiant_principal']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['id_etudiant_associe']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['filiere']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nom_parrain']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['prenom_parrain']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['contact_parrain']) . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                    
                } else {
                    echo "<p>Aucune association trouvée pour cet ID Étudiant Principal et cette filière.</p>";
                }
            } else {
                echo "<p>Veuillez remplir tous les champs du formulaire.</p>";
            }
            echo "</div>";
        } catch (PDOException $e) {
            echo "<p>Erreur : " . $e->getMessage() . "</p>";
        }
    }
    ?>
  
</body>
</html>

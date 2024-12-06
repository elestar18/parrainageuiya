<?php
// Connexion à la base de données
include('connect.php');

if (isset($_POST['valider'])) {
    // Récupération des données du formulaire
    $matriculeEtudiant = $_POST['matricule_etudiant'];
    $filiere = $_POST['filiere'];
    $nomEtudiant = $_POST['nom_etudiant'];
    $prenomEtudiant = $_POST['prenom_etudiant'];

    // Validation de la filière
    $filieresValides = ['IGL', 'SE', 'DROIT', 'COM JTV', 'COM RH', 'ANG', 'GESTION'];
    if (!in_array($filiere, $filieresValides)) {
        $message = "La filière sélectionnée est invalide !";
    } else {
        try {
            // Association des filières à leurs tables
            $table = match ($filiere) {
                'IGL' => 'informatique_option_genie_logiciels',
                'SE' => 'sciences_economiques',
                'DROIT' => 'droit',
                'COM JTV' => 'com_jtv',
                'COM RH' => 'com_rh',
                'ANG' => 'ang',
                'GESTION' => 'gestion',
                default => null
            };

            if (!$table) {
                throw new Exception("Erreur dans la détermination de la table de la filière !");
            }

            // Recherche d'un étudiant non encore associé pour cette session
            $queryEtudiant = "SELECT * FROM $table 
                              WHERE Matricule != :matriculeEtudiant 
                              ORDER BY RAND() 
                              LIMIT 1"; 
            $stmtEtudiant = $pdo->prepare($queryEtudiant);
            $stmtEtudiant->execute([':matriculeEtudiant' => $matriculeEtudiant]);
            $etudiantAssocie = $stmtEtudiant->fetch(PDO::FETCH_ASSOC);

            if (!$etudiantAssocie) {
                $message = "Aucun étudiant trouvé dans la filière $filiere pour une nouvelle association !";
            } else {
                // Récupération des informations de l'étudiant associé
                $matriculeEtudiantAssocie = $etudiantAssocie['Matricule'];
                $nomParrain = $etudiantAssocie['Nom'];
                $prenomParrain = $etudiantAssocie['Prenoms'];
                $contactParrain = $etudiantAssocie['Contacts'];

                // Ajout d'une nouvelle association dans la table
                $queryAssocier = "INSERT INTO associations (id_etudiant_principal, id_etudiant_associe, filiere, nom_etudiant_principal, prenom_etudiant_principal, nom_parrain, prenom_parrain, contact_parrain) 
                                  VALUES (:matriculePrincipal, :matriculeAssocie, :filiere, :nomPrincipal, :prenomPrincipal, :nomParrain, :prenomParrain, :contactParrain)";
                $stmtAssocier = $pdo->prepare($queryAssocier);
                $stmtAssocier->execute([
                    ':matriculePrincipal' => $matriculeEtudiant,
                    ':matriculeAssocie' => $matriculeEtudiantAssocie,
                    ':filiere' => $filiere,
                    ':nomPrincipal' => $nomEtudiant,
                    ':prenomPrincipal' => $prenomEtudiant,
                    ':nomParrain' => $nomParrain,
                    ':prenomParrain' => $prenomParrain,
                    ':contactParrain' => $contactParrain
                ]);

                $message = "Nouvelle association réussie entre $nomEtudiant $prenomEtudiant et $nomParrain $prenomParrain (Contact : $contactParrain) dans la filière $filiere.";
            }
        } catch (PDOException $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Association d'Étudiants</title>
</head>
   <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #e0f7fa;
        margin: 0;
        padding: 20px;
        min-height: 100vh;
    }

    .container {
        max-width: 600px;
        margin: 0 auto;
    }

    h2 {
        margin-bottom: 20px;
        text-align: center;
        color: #00796b;
    }

    form {
        max-width: 600px;
        width: 100%;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #b2ebf2; /* Light blue border */
    }

    label {
        display: block;
        font-weight: bold;
        margin: 10px 0 5px;
        color: #004d40; /* Dark teal */
    }

    input[type="text"], select {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #b2ebf2; /* Light blue border */
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #2196F3; /* Bleu */
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #1565C0; /* Bleu foncé */
    }

    p {
        text-align: center;
        font-size: 16px;
        color: #d9534f;
    }
</style>

<body>
    <div class="container">
        <h2>Formulaire d'Association d'Étudiants</h2>
        <?php if (isset($message)) echo "<p>$message</p>"; ?>
        <form method="POST">
            <label>Matricule de l'étudiant principal :</label>
            <input type="text" name="matricule_etudiant" required><br><br>
            
            <label>Nom de l'étudiant :</label>
            <input type="text" name="nom_etudiant" required><br><br>

            <label>Prénom de l'étudiant :</label>
            <input type="text" name="prenom_etudiant" required><br><br>

            <label>Filière :</label>
            <select name="filiere" required>
                <option value="IGL">IGL</option>
                <option value="SE">SE</option>
                <option value="DROIT">DROIT</option>
                <option value="COM JTV">COM JTV</option>
                <option value="COM RH">COM RH</option>
                <option value="ANG">ANG</option>
                <option value="GESTION">GESTION</option>
            </select><br><br>
            
            <input type="submit" name="valider" value="Associer">
        </form>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Validation avant envoi
            const form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
                const matricule = document.querySelector('input[name="matricule_etudiant"]').value;
                const nom = document.querySelector('input[name="nom_etudiant"]').value;
                const prenom = document.querySelector('input[name="prenom_etudiant"]').value;
                const filiere = document.querySelector('select[name="filiere"]').value;

                // Vérification de la présence de champs obligatoires
                if (!matricule || !nom || !prenom || !filiere) {
                    alert("Tous les champs doivent être remplis avant de soumettre !");
                    event.preventDefault(); // Annuler l'envoi du formulaire
                }
            });

            // Animation pour le message
            const message = document.querySelector('p');
            if (message) {
                setTimeout(() => {
                    message.style.opacity = 0;
                    message.style.transition = 'opacity 2s ease-out';
                }, 5000);
            }
        });
    </script>

</body>
</html>
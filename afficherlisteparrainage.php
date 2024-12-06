<?php
include('connect.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTE DES CLASSES PAR FILIÈRE</title>
    <style>
        body {
    font-family: 'Arial', sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 30px;
    color: #333;
}

h1, h2 {
    text-align: center;
    color: #333;
    font-size: 2rem;
    margin-bottom: 20px;
}

button {
    background-color: #4ca8af;
    color: white;
    border: none;
    padding: 10px 20px;
    margin: 10px;
    cursor: pointer;
    border-radius: 8px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

button:hover:enabled {
    background-color: #4ab17d;
    transform: scale(1.05);
}

button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
    transform: none;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #80bbdd;
    color: white;
}

tr {
    cursor: pointer;
    transition: background-color 0.3s ease;
}

tr:hover {
    background-color: #f1f1f1;
}

tr.selected {
    background-color: #add8e6;
}

#edit-btn, #delete-btn {
    transition: background-color 0.3s ease, transform 0.2s ease;
}

#edit-btn:hover:enabled, #delete-btn:hover:enabled {
    background-color: #ea00ff;
    transform: scale(1.05);
}

#edit-btn:disabled, #delete-btn:disabled {
    background-color: #ccc;
}

a.button {
    background-color: #2196F3;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 8px;
    margin-top: 20px;
    display: inline-block;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

a.button:hover {
    background-color: #1976D2;
    transform: scale(1.05);
}

/* Animation pour les sections */
h1, h2 {
    animation: fadeIn 1s ease-in-out;
}

/* Animation de fadeIn pour les sections de titre */
@keyframes fadeIn {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

/* Animation pour la table et les lignes */
#data-table {
    animation: slideInUp 1s ease-out;
}

@keyframes slideInUp {
    0% {
        transform: translateY(20px);
        opacity: 0;
    }
    100% {
        transform: translateY(0);
        opacity: 1;
    }
}

    </style>
</head>
<body>
    <h1>Filières disponibles</h1>

    <?php
    // Récupérer la liste des filières distinctes
    $filiereQuery = $pdo->prepare("SELECT DISTINCT filiere FROM associations ORDER BY filiere");
    $filiereQuery->execute();
    $filiereList = $filiereQuery->fetchAll();

    // Afficher les boutons pour chaque filière
    foreach ($filiereList as $filiere) {
        $filiereName = htmlspecialchars($filiere['filiere']);
        echo "<button onclick=\"window.location.href='?filiere=$filiereName'\">$filiereName</button> ";
    }

    if (isset($_GET['filiere']) && !empty($_GET['filiere'])) {
        $selectedFiliere = $_GET['filiere'];

        // Récupérer les données de la filière sélectionnée
        $reqt = $pdo->prepare("SELECT * FROM associations WHERE filiere = :filiere");
        $reqt->bindParam(':filiere', $selectedFiliere);
        $reqt->execute();

        // Initialisation du compteur
        $cpt = 1;

        // Afficher les données de la filière sélectionnée
        echo "<h2>Filière : " . htmlspecialchars($selectedFiliere) . "</h2>";
        echo "<table id='data-table'>
                <tr>
                    <th>#</th>
                    <th>ID Étudiant Principal</th>
                    <th>ID Étudiant Associé</th>
                    <th>Filière</th>
                    <th>Date Association</th>
                    <th>Nom Étudiant Principal</th>
                    <th>Prénom Étudiant Principal</th>
                    <th>Nom Parrain</th>
                    <th>Prénom Parrain</th>
                    <th>Contact Parrain</th>
                </tr>";

        // Affichage des données avec le compteur
        while ($data = $reqt->fetch()) {
            echo "<tr data-id='" . htmlspecialchars($data['id']) . "'>
                    <td>" . $cpt++ . "</td>
                    <td>" . htmlspecialchars($data['id_etudiant_principal']) . "</td>
                    <td>" . htmlspecialchars($data['id_etudiant_associe']) . "</td>
                    <td>" . htmlspecialchars($data['filiere']) . "</td>
                    <td>" . htmlspecialchars($data['date_association']) . "</td>
                    <td>" . htmlspecialchars($data['nom_etudiant_principal']) . "</td>
                    <td>" . htmlspecialchars($data['prenom_etudiant_principal']) . "</td>
                    <td>" . htmlspecialchars($data['nom_parrain']) . "</td>
                    <td>" . htmlspecialchars($data['prenom_parrain']) . "</td>
                    <td>" . htmlspecialchars($data['contact_parrain']) . "</td>
                </tr>";
        }
        echo "</table>";
        echo "<button id='edit-btn' disabled>Modifier</button>";
        echo "<button id='delete-btn' disabled>Supprimer</button>";

        // Ajouter un bouton pour télécharger l'image
        echo "<br><br><a href='download_image.php?filiere=$selectedFiliere' class='button'>Télécharger l'image</a>";

    } else {
        echo "<p>Veuillez sélectionner une filière pour afficher la liste des étudiants.</p>";
    }
    ?>

    <script>
        const table = document.getElementById('data-table');
        const editBtn = document.getElementById('edit-btn');
        const deleteBtn = document.getElementById('delete-btn');
        let selectedRow = null;

        // Ajouter un événement click sur chaque ligne
        table.addEventListener('click', (e) => {
            const tr = e.target.closest('tr');
            if (tr) {
                // Désélectionner la ligne précédente
                if (selectedRow) {
                    selectedRow.classList.remove('selected');
                }
                // Sélectionner la nouvelle ligne
                tr.classList.add('selected');
                selectedRow = tr;

                // Activer les boutons Modifier/Supprimer
                editBtn.disabled = false;
                deleteBtn.disabled = false;
            }
        });

        editBtn.addEventListener('click', () => {
            if (selectedRow) {
                const id = selectedRow.getAttribute('data-id'); // L'ID unique de la ligne
                const url = `modifier.php?id=${id}`;
                window.location.href = url; // Redirige vers le formulaire de modification
            } else {
                alert("Veuillez sélectionner une ligne à modifier.");
            }
        });

        // Bouton Supprimer
        deleteBtn.addEventListener('click', () => {
            if (selectedRow) {
                const id = selectedRow.getAttribute('data-id');
                if (confirm('Voulez-vous vraiment supprimer cette ligne ?')) {
                    const url = `supprimer.php?id=${id}`;
                    window.location.href = url;
                }
            }
        });
    </script>
</body>
</html>

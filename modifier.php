<?php
include('connect.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']); // Sécurisation de l'entrée
    $query = $pdo->prepare("SELECT * FROM associations WHERE id = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $data = $query->fetch();

    if ($data) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Modifier une entrée</title>
            <style>
                body {
                    font-family: 'Segoe UI', Arial, sans-serif;
                    margin: 0;
                    padding: 20px;
                    background-color: #e6f2ff;
                }
                header {
                    background-color: #1a4b8c;
                    color: white;
                    padding: 15px 0;
                    text-align: center;
                    border-radius: 8px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    transition: background-color 0.3s ease;
                }
                header:hover {
                    background-color: #145a8d;
                }
                nav {
                    margin: 20px 0;
                    text-align: center;
                }
                nav a {
                    color: #1a4b8c;
                    text-decoration: none;
                    padding: 12px 25px;
                    margin: 0 8px;
                    background-color: #d9eaf7;
                    border-radius: 6px;
                    transition: all 0.3s ease;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                }
                nav a:hover {
                    background-color: #1a4b8c;
                    color: white;
                    transform: translateY(-2px);
                }
                form {
                    background-color: white;
                    padding: 30px;
                    border-radius: 8px;
                    box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
                    max-width: 800px;
                    margin: 0 auto;
                }
                label {
                    font-weight: 600;
                    color: #1a4b8c;
                    display: block;
                    margin-bottom: 5px;
                }
                input {
                    padding: 12px;
                    margin: 5px 0 20px;
                    width: 100%;
                    border: 2px solid #b3d1f2;
                    border-radius: 6px;
                    transition: border-color 0.3s ease;
                    box-sizing: border-box;
                }
                input:focus {
                    outline: none;
                    border-color: #1a4b8c;
                }
                button {
                    background-color: #1a4b8c;
                    color: white;
                    padding: 12px 30px;
                    border: none;
                    border-radius: 6px;
                    cursor: pointer;
                    font-weight: bold;
                    transition: all 0.3s ease;
                    width: 100%;
                }
                button:hover {
                    background-color: #2c5ea0;
                    transform: translateY(-2px);
                    box-shadow: 0 4px 10px rgba(26, 75, 140, 0.2);
                }
            </style>
        </head>
        <body>

            <!-- Header de la page -->
            <header>
                <h1>Modifier une entrée</h1>
            </header>

            <!-- Barre de navigation -->
           
            <form method="POST" action="update.php">
                <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']); ?>">
                
                <label>ID Étudiant Principal:</label>
                <input type="text" name="id_etudiant_principal" value="<?= htmlspecialchars($data['id_etudiant_principal']); ?>" required><br>
                
                <label>Filière:</label>
                <input type="text" name="filiere" value="<?= htmlspecialchars($data['filiere']); ?>" required><br>
                
                <label>Nom Étudiant Principal:</label>
                <input type="text" name="nom_etudiant_principal" value="<?= htmlspecialchars($data['nom_etudiant_principal']); ?>" required><br>
                
                <label>Prénom Étudiant Principal:</label>
                <input type="text" name="prenom_etudiant_principal" value="<?= htmlspecialchars($data['prenom_etudiant_principal']); ?>" required><br>
                
                <button type="submit">Enregistrer les modifications</button>
            </form>

        </body>
        </html>
        <?php
    } else {
        echo "Aucune donnée trouvée pour cet ID.";
    }
} else {
    echo "ID manquant ou invalide.";
}
?>

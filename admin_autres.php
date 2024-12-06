<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Associations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<style>
body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(135deg, #f3f6fc, #e6eeff);
    min-height: 100vh;
    margin: 0;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.title {
    font-size: 2.5rem;
    color: #2c3e50;
    margin: 40px 0;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 2px;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.button-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
    max-width: 1000px;
    width: 90%;
    margin: 0 auto;
    padding: 20px;
}

.action-btn {
    background: linear-gradient(145deg, #3498db, #2980b9);
    color: white;
    border: none;
    padding: 25px 40px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    border-radius: 12px;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
    width: 100%;
    height: 100%;
    min-height: 120px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.action-btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    background: linear-gradient(145deg, #2980b9, #3498db);
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
    background: white;
    border-radius: 25px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    font-weight: 500;
}

.back-icon:hover {
    transform: translateX(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
}

@media (max-width: 768px) {
    .button-grid {
        grid-template-columns: 1fr;
    }
    
    .action-btn {
        min-height: 100px;
        padding: 20px;
    }
    
    .title {
        font-size: 2rem;
        margin: 30px 0;
    }
}
</style>
<body>
    <a href="admin.php" class="back-icon">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
    
    <h1 class="title">Gestion des Associations</h1>
    
    <div class="button-grid">
        <a href="parrainage.php">
            <button class="action-btn">Ajouter étudiant au parrainage</button>
        </a>
        <a href="afficherlisteparrainage.php">
            <button class="action-btn">Liste des associations</button>
        </a>
        <a href="affichageactivité.php">
            <button class="action-btn">Liste des activités</button>
        </a>
        <a href="affichagerencontre.php">
            <button class="action-btn">Liste des rencontres</button>
        </a>
    </div>

    <script>
        const buttons = document.querySelectorAll('.action-btn');
        
        buttons.forEach(button => {
            button.addEventListener('click', () => {
                button.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    button.style.transform = 'scale(1)';
                }, 200);
            });
        });
    </script>
</body>
</html>

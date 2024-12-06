<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Responsable</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
    <style>
        /* Style général du body */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
    min-height: 100vh;
    margin: 0;
    padding: 2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Style du titre */
.title {
    font-size: 2.5rem;
    color: #1565C0;
    margin: 3rem 0;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 2px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

/* Nouveau style pour le conteneur principal */
.button-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(250px, 300px));
    gap: 2rem;
    width: 90%;
    max-width: 800px;
    margin: 2rem auto;
    padding: 2rem;
    place-content: center;
}

.grid-item {
    text-decoration: none;
    height: 100%;
}

/* Style amélioré des boutons */
.action-btn {
    width: 100%;
    height: 150px;
    background: linear-gradient(145deg, #2196F3, #1976D2);
    color: white;
    border: none;
    border-radius: 15px;
    padding: 1.5rem;
    font-size: 1.2rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    line-height: 1.4;
}

.action-btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(33, 150, 243, 0.3);
    background: linear-gradient(145deg, #1976D2, #2196F3);
}

/* Style du bouton retour */
.back-icon {
    position: fixed;
    top: 30px;
    left: 30px;
    color: #2c3e50;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 20px;
    background-color: white;
    border-radius: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.back-icon:hover {
    transform: translateX(-5px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.back-icon i {
    font-size: 1.2rem;
}

/* Media Queries améliorées */
@media (max-width: 768px) {
    .button-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
        padding: 1rem;
    }

    .action-btn {
        height: 120px;
        font-size: 1.1rem;
        padding: 1rem;
    }

    .title {
        font-size: 2rem;
        margin: 2rem 0;
    }
}

/* Ajout d'une classe spéciale pour le bouton central */
.center-item {
    grid-column: 1 / -1;
    max-width: 300px;
    margin: 0 auto;
}

    </style>
<body>
<a href="./admin.php" class="back-icon">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
    <h1 class="title">BIENVENUE RESPONSABLE</h1>
    <div class="button-grid">
        <a href="./parrainage.php" class="grid-item">
            <button type="button" class="action-btn">Ajouter étudiant au parrainage</button>
        </a>
        <a href="./affichageactivité.php" class="grid-item">
            <button type="button" class="action-btn">Liste des activités</button>
        </a>
        <a href="admin2.php" class="grid-item center-item">
            <button class="action-btn">Ajouter un responsable</button>
        </a>
        <a href="afficherlisteparrainage.php" class="grid-item">
            <button class="action-btn">Liste des associations</button>
        </a>
        <a href="affichagerencontre.php" class="grid-item">
            <button class="action-btn">Liste des rencontres</button>
        </a>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.action-btn');
    
    buttons.forEach(button => {
        button.addEventListener('click', (e) => {
            if (button.classList.contains('clicking')) return;
            
            button.classList.add('clicking');
            button.style.transform = 'scale(1.05)';
            
            setTimeout(() => {
                button.style.transform = 'scale(1)';
                button.classList.remove('clicking');
            }, 200);
        });
    });
});
    </script>
   
</body>
</html>

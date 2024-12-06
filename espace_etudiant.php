<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>espace etudiant</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
<style>
    /* Variables CSS pour une meilleure maintenabilité */
    :root {
        --primary-color: rgba(67, 83, 115, 0.3);
        --white-transparent: rgba(255, 255, 255, 0.1);
        --button-padding: 1.25rem 2.5rem;
        --border-radius: 15px;
    }

    /* Reset et styles de base */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #2C3E50, #3498db, #2C3E50);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
        min-height: 100vh;
        margin: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 1rem;
    }

    /* Container principal */
    .button-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1.5rem;
        padding: 2rem;
        background: var(--white-transparent);
        backdrop-filter: blur(15px);
        border-radius: var(--border-radius);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.2);
        width: 100%;
        max-width: 1200px;
    }

    /* Styles des boutons */
    a {
        text-decoration: none;
        flex: 1;
        min-width: 200px;
        max-width: 300px;
    }

    button {
        width: 100%;
        padding: var(--button-padding);
        background: var(--primary-color);
        border: 2px solid rgba(255, 255, 255, 0.4);
        border-radius: var(--border-radius);
        color: white;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        overflow: hidden;
        white-space: nowrap;
    }

    /* Bouton retour */
    .back-button {
        position: fixed;
        top: 1rem;
        left: 1rem;
        z-index: 100;
    }

    .back-button button {
        min-width: auto;
        padding: 0.8rem 1.5rem;
    }

    /* Effets hover */
    button:hover {
        background: rgba(67, 83, 115, 0.5);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    button:active {
        transform: translateY(1px);
    }

    /* Media Queries */
    @media screen and (max-width: 768px) {
        .button-container {
            padding: 1rem;
            gap: 1rem;
        }

        button {
            padding: 1rem 1.5rem;
            font-size: 0.9rem;
        }

        a {
            min-width: 150px;
        }
    }

    @media screen and (max-width: 480px) {
        .button-container {
            flex-direction: column;
            width: 90%;
        }

        a {
            width: 100%;
            max-width: none;
        }

        .back-button {
            position: relative;
            top: 0;
            left: 0;
            margin-bottom: 1rem;
            width: 90%;
        }
    }

    /* Animations */
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes containerFloat {
        /* Supprimer cette animation */
    }

    .position-number {
        /* Supprimer ce style */
    }

    .button-row {
        display: flex;
        gap: 1.5rem;
        width: 100%;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .button-wrapper {
        position: relative;
        flex: 1;
        max-width: 300px;
        min-width: 200px;
    }

    /* Mise à jour des media queries */
    @media screen and (max-width: 768px) {
        .button-row {
            gap: 1rem;
        }
        
        .button-wrapper {
            min-width: 150px;
        }
    }

    @media screen and (max-width: 480px) {
        .button-row {
            flex-direction: column;
            align-items: center;
        }
        
        .button-wrapper {
            width: 100%;
            max-width: none;
        }
    }
</style>

<div class="back-button">
    <a href="index.php" title="Retour à l'accueil">
        <button aria-label="Retour">Retour</button>
    </a>
</div>

<div class="button-container">
    <div class="button-row">
        <div class="button-wrapper">
            <a href="affichageunique.php">
                <button>Afficher mon parrain</button>
            </a>
        </div>
        <div class="button-wrapper">
            <a href="rencontre.php">
                <button>Rencontre</button>
            </a>
        </div>
    </div>
    <div class="button-row">
        <div class="button-wrapper">
            <a href="activite.php">
                <button>Activité</button>
            </a>
        </div>
    </div>
</div>
</body>
</html>

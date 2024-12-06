<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SYGES PROPUS</title>
    <style>
       /* Réinitialisation globale */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Style global du body */
body {
    font-family: 'Arial', sans-serif;
    height: 100vh;
    margin: 0;
    background: url('UIYA_COUR.jpg') no-repeat center center/cover;
    position: relative;
    overflow: hidden; /* Empêche les débordements visuels */
}

/* Effet de superposition sombre sur l'image de fond */
body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6); /* Assombrissement */
    z-index: 0;
}

/* Barre de navigation */
.navbar {
    position: relative;
    z-index: 1;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 30px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
}

.navbar .logo img {
    height: 50px;
    width: auto;
    border-radius: 50%;
}

.nav-links {
    display: flex;
    list-style: none;
}

.nav-links li {
    margin: 0 15px;
}

.nav-links a {
    text-decoration: none;
    color: #fff;
    font-size: 18px;
    padding: 10px 15px;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
}

.nav-links a::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: 0;
    left: 50%;
    background: #fff;
    transition: all 0.4s ease;
    transform: translateX(-50%);
}

.nav-links a:hover::after {
    width: 100%;
}

/* Conteneur des boutons au centre */
.button-container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    z-index: 1;
}

.button {
    padding: 15px 40px;
    font-size: 18px;
    font-weight: bold;
    color: #fff;
    background: linear-gradient(45deg, rgba(0, 0, 0, 0.8), rgba(40, 40, 40, 0.8));
    border: 2px solid transparent;
    border-radius: 8px;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.button:hover {
    transform: translateY(-5px) scale(1.05);
    background: linear-gradient(45deg, rgba(255, 255, 255, 0.9), rgba(220, 220, 220, 0.9));
    color: #000;
    border: 2px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
}

/* Menus contextuels */
.menus {
    position: absolute;
    top: calc(100% + 20px);
    left: 50%;
    transform: translateX(-50%) scale(0.8);
    display: flex;
    gap: 20px;
    opacity: 0;
    pointer-events: none;
    transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.menus.active {
    opacity: 1;
    pointer-events: auto;
    transform: translateX(-50%) scale(1);
}

.menu {
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(10px);
    color: #fff;
    padding: 20px 30px;
    border-radius: 15px;
    text-align: center;
    width: 180px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    transform: translateY(20px);
    transition: all 0.4s ease;
}

.menu:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
}

.menu button {
    background: #fff;
    color: #000;
    padding: 10px 15px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease, color 0.3s ease;
}

.menu button:hover {
    background: #000;
    color: #fff;
}

/* Animation pour le titre */
.title-container {
    position: absolute;
    top: 30%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    z-index: 1;
}

.title {
    font-size: 3.5rem;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 4px;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
    animation: fadeInUp 1.2s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
}

.subtitle {
    font-size: 1.6rem;
    color: #f0f0f0;
    margin-top: 15px;
    text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
    animation: fadeInUp 1.2s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards 0.3s;
}

/* Animation Fade In */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(10px);
    color: #fff;
    padding: 20px 0;
    z-index: 1;
    animation: slideUp 0.8s ease-out forwards;
}

.footer-content {
    display: flex;
    justify-content: space-around;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.footer-section {
    text-align: center;
    transition: transform 0.3s ease;
}

.footer-section:hover {
    transform: translateY(-5px);
}

.footer-section h3 {
    color: #fff;
    font-size: 1.2rem;
    margin-bottom: 10px;
    position: relative;
}

.footer-section h3::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 2px;
    background: #fff;
    transition: width 0.3s ease;
}

.footer-section:hover h3::after {
    width: 50%;
}

.footer-section p, .footer-section a {
    color: #ccc;
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.footer-section a:hover {
    color: #fff;
}

.social-links {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 10px;
}

.social-links a {
    color: #fff;
    font-size: 1.2rem;
    transition: transform 0.3s ease;
}

.social-links a:hover {
    transform: scale(1.2);
}

@keyframes slideUp {
    from {
        transform: translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

    <div class="background-container">
        <nav class="navbar">
            <div class="logo">
                <a href="#">
                    <img src="UIYA.jpeg" alt="Logo">
                </a>
            </div>
            <ul class="nav-links">
                <li><a href="#about">À propos</a></li>
                <li><a href="#features">Fonctionnalités</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>

        <!-- Titre et sous-titre animés -->
        <div class="title-container">
            <h1 class="title" id="mainTitle">Bienvenue à UIYA</h1>
            <p class="subtitle" id="subTitle">Votre solution de gestion simplifiée</p>
        </div>

        <div class="button-container">
            <button class="button" id="toggleMenus">Cliquez ici</button>
            <!-- Menus cachés -->
            <div class="menus" id="menus">
                <div class="menu">
                    <p><a href="etudiant.php"> <button>espace étudiant</button></a></p>
                   
                </div>
                <div class="menu">
                    <p><a href="admin.php"><button>espace <br> resposable</button></a></p>
                    
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('toggleMenus').addEventListener('click', () => {
            const menus = document.getElementById('menus');
            menus.classList.toggle('active');
            
            // Ajoute une animation au bouton lors du clic
            const button = document.getElementById('toggleMenus');
            button.style.transform = 'scale(0.95)';
            setTimeout(() => {
                button.style.transform = 'scale(1)';
            }, 200);
        });

        // Animation améliorée des titres
        window.onload = () => {
            const mainTitle = document.getElementById('mainTitle');
            const subTitle = document.getElementById('subTitle');
            const navLinks = document.querySelectorAll('.nav-links a');

            // Animation des liens de navigation
            navLinks.forEach((link, index) => {
                link.style.opacity = '0';
                link.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    link.style.opacity = '1';
                    link.style.transform = 'translateY(0)';
                }, 200 * index);
            });

            // Animation du logo
            const logo = document.querySelector('.logo');
            logo.style.opacity = '0';
            logo.style.transform = 'translateX(-20px)';
            setTimeout(() => {
                logo.style.opacity = '1';
                logo.style.transform = 'translateX(0)';
            }, 300);
        };
    </script>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>À propos de UIYA</h3>
                <p>Une institution d'excellence dédiée<br>à votre réussite académique</p>
            </div>
            
            <div class="footer-section">
                <h3>Contact</h3>
                <p>Email: contact@uiya.edu</p>
                <p>Tél: +225 00 00 00 00</p>
            </div>
            
            <div class="footer-section">
                <h3>Liens utiles</h3>
                <p><a href="#">Mentions légales</a></p>
                <p><a href="#">Politique de confidentialité</a></p>
            </div>
            
            <div class="footer-section">
                <h3>Suivez-nous</h3>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>

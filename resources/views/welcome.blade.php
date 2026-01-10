<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gest-Docs - Bienvenue</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Header CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
    
    <style>
        /* --- VARIABLES --- */
        :root {
            --blue-dark: #1a4a7a;
            --blue-medium: #2c5a8a;
            --blue-light: #f0f7ff;
            --orange: #f39c12;
            --orange-light: #fff6e8;
            --text-dark: #333;
            --white: #ffffff;
        }

        * { 
            box-sizing: border-box; 
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
            background-color: var(--white);
            min-height: 100vh;
        }

        /* --- HERO SECTION --- */
        .hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                        url('{{ asset('assets/images/image5.jpeg') }}') no-repeat center center/cover;
            background-size: cover;
            background-position: center;
            height: 500px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 0 20px;
        }

        .hero h1 { 
            font-size: 40px; 
            margin-bottom: 10px; 
        }
        .hero p { 
            max-width: 600px; 
            font-size: 18px; 
            margin-bottom: 30px; 
        }
        .hero-btns .btn {
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin: 0 10px;
            display: inline-block;
            transition: all 0.3s;
        }
        .btn-discover { 
            background-color: var(--orange); 
            color: white; 
        }
        .btn-discover:hover {
            background-color: #e67e22;
            transform: translateY(-2px);
        }
        .btn-signup { 
            border: 2px solid var(--orange); 
            color: white; 
            background: transparent;
        }
        .btn-signup:hover {
            background-color: var(--orange);
            transform: translateY(-2px);
        }

        /* --- SECTIONS --- */
        section { 
            padding: 60px 10%; 
            text-align: center; 
        }
        .section-title { 
            color: var(--blue-dark); 
            margin-bottom: 40px; 
            font-size: 28px; 
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background: var(--white);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            text-align: center;
        }
        .card:hover { 
            transform: translateY(-10px); 
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }
        .card i { 
            font-size: 40px; 
            color: var(--blue-dark); 
            margin-bottom: 20px; 
            display: block;
        }
        .card h3 { 
            margin-bottom: 15px; 
            font-size: 22px; 
            color: var(--blue-dark);
        }
        .card p { 
            font-size: 15px; 
            color: #666; 
            line-height: 1.7;
        }

        /* --- UNIFIED BACKGROUND FOR SECTIONS --- */
        .unified-bg-section {
            background-color: var(--blue-light);
        }

        /* --- FOOTER STYLES (EXACTEMENT COMME VOTRE CODE ORIGINAL) --- */
        footer {
            background-color: var(--blue-dark);
            color: white;
            padding: 50px 10% 20px;
            text-align: left;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 30px;
        }

        .footer-col h4 { 
            margin-bottom: 20px; 
            border-bottom: 2px solid var(--orange); 
            display: inline-block; 
            padding-bottom: 5px; 
        }
        .footer-col ul { 
            list-style: none; 
            padding: 0; 
        }
        .footer-col ul li { 
            margin-bottom: 10px; 
        }
        .footer-col a { 
            color: #ccc; 
            text-decoration: none; 
        }
        .social-icons i { 
            font-size: 20px; 
            margin-right: 15px; 
            cursor: pointer; 
        }

        .copyright { 
            text-align: center; 
            padding-top: 20px; 
            border-top: 1px solid rgba(255,255,255,0.1); 
            font-size: 14px; 
        }
    </style>
</head>
<body>
    <!-- Header commun -->
       <x-header/>
    <!-- HERO SECTION -->
    <div class="hero">
        <h1>Bienvenue sur notre plateforme</h1>
        <p>Optimisez votre gestion documentaire avec Gest-Docs. Elle vous aide à centraliser, classer et partager vos documents.</p>
        <div class="hero-btns">
            <a href="" class="btn btn-discover">Découvrir</a>
            <a href="{{ route('auth.register') }}" class="btn btn-signup">S'inscrire</a>
        </div>
    </div>

    <!-- Section unifiée avec même fond -->
    <div class="unified-bg-section">
        <!-- SECTION 1 : Fonctionnalités clés -->
        <section>
            <h2 class="section-title">Nos Fonctionnalités clés</h2>
            <div class="grid-container">
                <div class="card">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Sécurité Avancée</h3>
                    <p>Protégez vos documents avec un chiffrement de bout en bout et des contrôles d'accès granulaires.</p>
                </div>
                <div class="card">
                    <i class="fas fa-book"></i>
                    <h3>Gestion Centralisée</h3>
                    <p>Organisez et gérez tous vos documents depuis un espace unique et sécurisé.</p>
                </div>
                <div class="card">
                    <i class="fas fa-users"></i>
                    <h3>Collaboration Facilitée</h3>
                    <p>Partagez et travaillez en équipe sur des documents en temps réel avec un contrôle des versions.</p>
                </div>
                <div class="card">
                    <i class="fas fa-search"></i>
                    <h3>Recherche Intelligente</h3>
                    <p>Retrouvez vos documents instantanément grâce à notre moteur de recherche puissant.</p>
                </div>
                <div class="card">
                    <i class="fas fa-archive"></i>
                    <h3>Archivage Automatisé</h3>
                    <p>Conservez vos documents à long terme en toute conformité.</p>
                </div>
                <div class="card">
                    <i class="fas fa-mobile-alt"></i>
                    <h3>Accès Partout</h3>
                    <p>Consultez vos documents depuis n'importe quel appareil.</p>
                </div>
            </div>
        </section>

        <!-- SECTION 2 : Gest-Docs pour Chaque Secteur -->
        <section>
            <h2 class="section-title">Gest-Docs pour Chaque Secteur</h2>
            <div class="grid-container">
                <div class="card">
                    <i class="fas fa-university"></i>
                    <h3>Administrations Publiques</h3>
                    <p>Optimisez la gestion administrative avec une traçabilité irréprochable.</p>
                </div>
                <div class="card">
                    <i class="fas fa-building"></i>
                    <h3>Entreprises & PME</h3>
                    <p>Améliorez les processus de travail et la productivité de vos équipes.</p>
                </div>
                <div class="card">
                    <i class="fas fa-graduation-cap"></i>
                    <h3>Universités & Établissements</h3>
                    <p>Gérez efficacement les documents des étudiants et chercheurs.</p>
                </div>
            </div>
        </section>

        <!-- SECTION 3 : Pourquoi Choisir Gest-Docs -->
        <section>
            <h2 class="section-title">Pourquoi Choisir Gest-Docs ?</h2>
            <div class="grid-container">
                <div class="card">
                    <h3>Sécurité Renforcée</h3>
                    <p>Vos données sont protégées par les meilleures technologies de sécurité.</p>
                </div>
                <div class="card">
                    <h3>Accessibilité Optimisée</h3>
                    <p>Accédez à vos données en un clic sur n'importe quel support.</p>
                </div>
                <div class="card">
                    <h3>Gain de Temps Conséquent</h3>
                    <p>Réduisez le temps de recherche et de traitement documentaire.</p>
                </div>
            </div>
        </section>
    </div>

    <!-- FOOTER (exactement comme dans votre code original) -->
    <footer>
        <div class="footer-grid">
            <div class="footer-col">
                <h4>A propos</h4>
                <p>Votre plateforme de gestion et de centralisation des documents simple, rapide et sécurisée.</p>
            </div>
            <div class="footer-col">
                <h4>Liens rapides</h4>
                <ul>
                    <li><a href="">Accueil</a></li>
                    <li><a href="">Fonctionnalités</a></li>
                    <li><a href="">A propos</a></li>
                    <li><a href="">Contact</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Suivez-nous</h4>
                <div class="social-icons">
                    <i class="fab fa-facebook"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-linkedin"></i>
                </div>
            </div>
            <div class="footer-col">
                <h4>Contact</h4>
                <p><i class="fas fa-envelope"></i> gest.docs@gmail.com</p>
                <p><i class="fas fa-map-marker-alt"></i> Lomé-Togo</p>
                <p><i class="fas fa-phone"></i> (+228) 98 85 57 24</p>
            </div>
        </div>
        <div class="copyright">
            2025 Gest-Docs - Tous droits réservés.
        </div>
    </footer>

</body>
</html>
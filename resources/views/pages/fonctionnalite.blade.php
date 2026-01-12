<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fonctionnalités - Gest-Docs</title>
    
    <!-- 1. BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- 2. FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- 3. VOTRE CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">
    
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        
        .fonctionnalites-content {
            max-width: 1200px; 
            margin: auto; 
            padding: 40px;
        }
        
        .banner-section {
            display: flex; 
            flex-wrap: wrap; 
            align-items: center; 
            justify-content: space-between; 
            margin-bottom: 80px;
        }
        
        .banner-text { flex: 1; min-width: 300px; }
        .banner-image { flex: 1; min-width: 300px; text-align: center; }
        .banner-title { font-size: 36px; color: #2c3e50; }
        .banner-description { font-size: 18px; color: #555; }
        
        .btn-primary-custom {
            display: inline-block; 
            margin-top: 20px; 
            padding: 12px 24px; 
            background-color: #3498db; 
            color: white; 
            text-decoration: none; 
            border-radius: 4px;
        }
        
        .features-grid {
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); 
            gap: 40px; 
            margin-bottom: 80px;
        }
        
        .feature-card {
            background: #f9f9f9; 
            padding: 20px; 
            border-radius: 8px; 
            text-align: center;
        }
        
        .feature-card img {
            width: 100%; 
            height: auto; 
            border-radius: 4px;
        }
        
        .feature-card h3 { margin-top: 15px; }
        
        .security-section {
            display: flex; 
            flex-wrap: wrap; 
            align-items: center; 
            justify-content: space-between;
        }
        
        .security-text { flex: 1; min-width: 300px; }
        .security-image { flex: 1; min-width: 300px; text-align: center; }
        .security-title { font-size: 28px; color: #2c3e50; }
        
        .btn-success-custom {
            display: inline-block; 
            margin-top: 20px; 
            padding: 10px 20px; 
            background-color: #2ecc71; 
            color: white; 
            text-decoration: none; 
            border-radius: 4px;
        }
    </style>
</head>
<body>
    {{-- HEADER --}}
<x-header />
    <main class="fonctionnalites-content">
        <section class="banner-section">
            <div class="banner-text">
                <h1 class="banner-title">Simplifiez la Gestion de Vos Documents</h1>
                <p class="banner-description">Centralisez, organisez et sécurisez tous vos fichiers en un seul endroit.</p>
                <a href="{{ route('auth.register') }}" class="btn-primary-custom">Commencer Maintenant</a>
            </div>
            <div class="banner-image">
                <img src="{{ asset('assets/images/image8.jpg') }}" alt="Personne travaillant sur un ordinateur">
            </div>
        </section>

        <section style="text-align: center; margin-bottom: 40px;">
            <h2 style="font-size: 28px; color: #2c3e50;">Fonctionnalités clés de Gest-Docs</h2>
        </section>

        <section class="features-grid">
            <div class="feature-card">
                <img src="{{ asset('assets/images/dossier_tir.jpg') }}" alt="Personne scannant des documents">
                <h3>Ajout de document</h3>
                <p>Ajoutez facilement des fichiers depuis votre ordinateur ou appareil mobile.</p>
            </div>
            <div class="feature-card">
                <img src="{{ asset('assets/images/ranger.jpg') }}" alt="Personne téléchargeant des fichiers">
                <h3>Consultation et Téléchargement</h3>
                <p>Accédez à vos documents à tout moment et téléchargez-les en toute simplicité.</p>
            </div>
            <div class="feature-card">
                <img src="{{ asset('assets/images/image4.jpg') }}" alt="Réunion professionnelle">
                <h3>Gérez les utilisateurs</h3>
                <p>Attribuez des rôles et gérez les permissions pour une collaboration efficace.</p>
            </div>
        </section>

        <section class="security-section">
            <div class="security-text">
                <h2 class="security-title">Sécurité et Sauvegarde Robustes</h2>
                <p style="font-size: 16px; color: #555;">Vos données sont protégées grâce à un chiffrement avancé et des sauvegardes régulières.</p>
                <a href="{{ route('pages.Apropos') }}" class="btn-success-custom">En savoir plus</a>
            </div>
            <div class="security-image">
                <img src="{{ asset('assets/images/consulter.jpg') }}" alt="Illustration de stockage sécurisé">
            </div>
        </section>
    </main>
    
    {{-- FOOTER --}}
<x-footer />
</body>
</html>
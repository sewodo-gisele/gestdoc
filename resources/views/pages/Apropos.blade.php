<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qui sommes nous? - Gest-Docs</title>
    
    <!-- Bootstrap FIRST -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Votre CSS personnel LAST (sera prioritaire) -->
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">
    
</head>
<body>
    {{-- Header avec icônes --}}
         <x-header/>
    <div class="container py-5">
        <!-- Qui sommes-nous -->
        <div class="row align-items-center mb-5">
            <div class="col-lg-6">
                <h4 class="fw-bold mb-3">Qui sommes nous?</h4>
                <p>
                    Gest-Docs est une plateforme moderne dédiée à la gestion et à l’archivage
                    des documents administratifs. Elle permet aux utilisateurs d’organiser,
                    sécuriser et retrouver facilement tous leurs fichiers importants.
                </p>
            </div>

            <div class="col-lg-6 text-end">
                <img src="{{ asset('assets/images/image4.jpg') }}" class="img-fluid rounded" alt="À propos">
            </div>
        </div>

        <!-- Notre mission -->
        <div class="mb-5">
            <h4 class="fw-bold mb-3">Notre mission</h4>
            <p>
                Notre mission est de simplifier la gestion documentaire tout en garantissant
                un accès rapide, sécurisé et organisé à tous les documents essentiels.
            </p>
        </div>

        <!-- Nos valeurs -->
        <div class="mb-5">
            <h4 class="fw-bold mb-4 text-center">Nos valeurs</h4>

            <div class="row text-center">
                <div class="col-md-3 mb-4">
                    <i class="bi bi-shield-check fs-3 mb-2"></i>
                    <p class="fw-semibold">Sécurité</p>
                </div>

                <div class="col-md-3 mb-4">
                    <i class="bi bi-lightning-charge fs-3 mb-2"></i>
                    <p class="fw-semibold">Rapidité</p>
                </div>

                <div class="col-md-3 mb-4">
                    <i class="bi bi-check-circle fs-3 mb-2"></i>
                    <p class="fw-semibold">Fiabilité</p>
                </div>

                <div class="col-md-3 mb-4">
                    <i class="bi bi-folder fs-3 mb-2"></i>
                    <p class="fw-semibold">Organisation</p>
                </div>
            </div>
        </div>

        <!-- Pourquoi -->
        <div>
            <h4 class="fw-bold mb-3">Pourquoi nous avons créé Gest-Docs ?</h4>
            <p>
                Beaucoup de personnes perdent leurs documents ou ont du mal à les retrouver
                lorsque c'est nécessaire. Gest-Docs apporte une solution simple, sécurisée
                et moderne pour centraliser tous vos fichiers.
            </p>
        </div>
    </div>

    {{-- Footer --}}
         <x-footer/>

</body>
</html>
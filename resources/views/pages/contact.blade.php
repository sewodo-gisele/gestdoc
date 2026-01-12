<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-nous - Gest-Docs</title>
    
    <!-- MÊME ORDRE EXACT -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}">
</head>

<body>
    {{-- MÊME HEADER --}}
<x-header />

    <!-- VOTRE CONTENU CONTACT -->
    <div class="container py-5">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6">
                <h2 class="fw-bold title">Contactez-nous</h2>
                <p class="text-muted">
                    Si vous avez une question, n'hésitez pas à nous contacter en utilisant
                    le formulaire ci-dessous. Notre équipe est là pour vous aider à tout moment.
                </p>
            </div>

            <div class="col-lg-6 text-end">
                <img src="{{ asset('assets/images/image1.jpg') }}" class="img-fluid rounded" alt="Contact">
            </div>
        </div>

        <div class="row g-4">
            <!-- COPIER-COLLER TA NOUVELLE VERSION DU FORMULAIRE ICI -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold mb-4">Envoyez-nous un message</h5>

                    <form method="POST" action="{{ route('contact.send') }}">
                        @csrf

                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" class="form-control" name="nom" placeholder="Nom complet" required>
                            </div>
                            <div class="col">
                                <input type="email" class="form-control" name="email" placeholder="Email professionnel" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <input type="text" class="form-control" name="organisation" placeholder="Organisation">
                        </div>

                        <div class="mb-3">
                            <select class="form-select" name="sujet" required>
                                <option value="">Sujet</option>
                                <option value="Support">Support</option>
                                <option value="Information">Information</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <textarea class="form-control" rows="4" name="message" placeholder="Votre message" required></textarea>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                                <strong>Erreur :</strong>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-send me-2"></i>Envoyer la demande
                        </button>
                    </form>
                </div>
            </div>
            <!-- FIN DU FORMULAIRE MODIFIÉ -->

            <!-- Coordonnées (NE PAS MODIFIER) -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4 mb-4">
                    <h6 class="fw-bold">Nos coordonnées</h6>

                    <p class="mb-2">
                        <strong>Email :</strong><br>
                        contact@site.com
                    </p>

                    <p class="mb-2">
                        <strong>Adresse :</strong><br>
                        123 Rue de la Documentation,<br>
                        75001 Paris, France
                    </p>

                    <p class="mb-0">
                        <strong>Disponibilité :</strong><br>
                        Lun-Ven, 9h-18h CET
                    </p>
                </div>

                <div class="card border-0 shadow-sm p-4">
                    <h6 class="fw-bold">Suivez-nous</h6>
                    <div class="d-flex gap-3">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
<x-footer />

    <!-- AJOUTER CES SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>
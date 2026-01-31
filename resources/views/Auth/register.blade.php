<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Gest-Docs</title>
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .registration-container {
            width: 100%;
            max-width: 480px;
            background-color: #fff;
            padding: 40px 35px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(26, 74, 122, 0.12);
            border: 1px solid rgba(26, 74, 122, 0.08);
        }

        .logo-container {
            width: 100%;
            height: 90px;
            margin-bottom: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #1a4a7a;
            text-align: center;
        }

        .subtitle {
            font-size: 14px;
            color: #5a6c7d;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
            color: #2d3748;
        }

        .form-group input {
            width: 100%;
            padding: 14px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 15px;
            background: #f8fafc;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: #1a4a7a;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(26, 74, 122, 0.1);
        }

        .form-checkbox {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 25px;
            font-size: 13px;
            color: #4a5568;
        }

        .form-checkbox input {
            margin-top: 3px;
            cursor: pointer;
            accent-color: #1a4a7a;
            width: 18px;
            height: 18px;
        }

        .form-checkbox a {
            color: #f39c12;
            text-decoration: none;
            font-weight: 600;
        }

        .form-checkbox a:hover {
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #1a4a7a 0%, #2a5a9a 100%);
            color: white;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #14385d 0%, #1a4a7a 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 74, 122, 0.2);
        }

        .error-message {
            color: #e53e3e;
            font-size: 13px;
            margin-top: 5px;
            font-weight: 500;
        }

        @media (max-width: 480px) {
            .registration-container {
                padding: 30px 25px;
            }
            h1 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

    <div class="registration-container">
        <div class="logo-container">
            <img src="{{ asset('assets/images/log.png') }}" alt="Logo Gest-Docs">
        </div>
        
        <h1>Inscription à Gest-Docs</h1>
        <p class="subtitle">Remplissez le formulaire ci-dessous pour vous inscrire et commencer à gérer vos documents.</p>

        <form action="" method="POST" class="registration-form">
            @csrf

            <div class="form-group">
                <label for="name">Nom complet</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Votre nom complet" required>
                @error('name') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email professionnel</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Entrer votre email" required>
                @error('email') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="organisation">Organisation</label>
                <input type="text" id="organisation" name="organisation" value="{{ old('organisation') }}" placeholder="Nom de votre organisation">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="******" required>
                @error('password') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmer mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="******" required>
            </div>

            <div class="form-checkbox">
    <input type="checkbox" id="terms" name="terms" required>
    <label for="terms">
        J'accepte les <a href="{{ url('/terms') }}" target="_blank">Conditions d'utilisation</a> 
        et la <a href="{{ url('/privacy') }}" target="_blank">Politique de confidentialité</a>
    </label>
</div>

            <button type="submit" class="btn-submit">S'inscrire</button>
        </form>
    </div>

</body>
</html>

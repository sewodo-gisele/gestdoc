<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gest-Docs</title>
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

        .login-container {
            width: 100%;
            max-width: 450px;
            background-color: #fff;
            padding: 40px 35px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(26, 74, 122, 0.12);
            border: 1px solid rgba(26, 74, 122, 0.08);
        }

        h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #1a4a7a;
            text-align: center;
        }

        .alert-success {
            color: #2f855a;
            background: #f0fff4;
            border: 1px solid #9ae6b4;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error {
            color: #e53e3e;
            background: #fff5f5;
            border: 1px solid #feb2b2;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
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

        p {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        p a {
            color: #f39c12;
            text-decoration: none;
            font-weight: 600;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h1>Connexion</h1>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="">
            @csrf
            <div class="form-group">
                <label>Email :</label>
                <input type="email" name="email" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label>Mot de passe :</label>
                <input type="password" name="password">
            </div>

            <button type="submit" class="btn-submit">Se connecter</button>
        </form>

        <p>Pas encore inscrit ? <a href="{{ route('auth.register') }}">Créer un compte</a></p>
    </div>

</body>
</html>

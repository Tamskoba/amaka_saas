<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">

    <title>
        Votre compte a été créé
    </title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #FDF9F5;
    font-family: Arial, sans-serif;
    color: #4A2D21;
">

    <div style="
        max-width: 600px;
        margin: 40px auto;
        background: white;
        padding: 40px;
        border-radius: 20px;
    ">

        <h1 style="
            color: #C87A2A;
            margin-bottom: 30px;
        ">
            Bienvenue {{ $user->first_name }} !
        </h1>

        <p>
            Votre compte a été créé avec succès.
        </p>

        <p>
            Voici vos identifiants de connexion :
        </p>

        <div style="
            background: #FDF9F5;
            padding: 20px;
            border-radius: 12px;
            margin: 25px 0;
        ">

            <p>
                <strong>Email :</strong>
                {{ $user->email }}
            </p>

            <p>
                <strong>Mot de passe temporaire :</strong>
                {{ $temporaryPassword }}
            </p>

        </div>

        <p>
            Pour des raisons de sécurité, vous devrez
            modifier ce mot de passe lors de votre première connexion.
        </p>

        <div style="
            margin: 30px 0;
            text-align: center;
        ">

            <a
                href="{{ route('login') }}"
                style="
                    display: inline-block;
                    background: #C87A2A;
                    color: #000000;
                    padding: 14px 25px;
                    border-radius: 10px;
                    text-decoration: none;
                    font-weight: bold;
                "
            >
                Se connecter
            </a>

        </div>

        <p>
            Si vous n'êtes pas à l'origine de cette création de compte,
            veuillez contacter l'administrateur.
        </p>

    </div>

</body>

</html>
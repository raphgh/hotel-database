<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $res_client = pg_query_params($conn, "SELECT * FROM Client WHERE id_client = $1", [$id]);
    $res_employe = pg_query_params($conn, "SELECT * FROM Employe WHERE id_employe = $1", [$id]);

    if ($user = pg_fetch_assoc($res_client)) {
        if ($mot_de_passe === $user['mot_de_passe']) {
            $_SESSION['role'] = 'client';
            $_SESSION['user_id'] = $user['id_client'];
            header("Location: client/index.php");
            exit();
        } else {
            echo "Mot de passe incorrect.";
        }
    } elseif ($user = pg_fetch_assoc($res_employe)) {
        if ($mot_de_passe === $user['mot_de_passe']) {
            $_SESSION['role'] = 'employe';
            $_SESSION['user_id'] = $user['id_employe'];
            header("Location: employe/employee_vue.php");
            exit();
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Aucun compte trouvé avec cet id.";
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Connexion</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../style.css">
        <style>
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
 
            :root {
                --bg: #F7F5F0;
                --surface: #FFFFFF;
                --border: #E2DDD5;
                --text: #1A1714;
                --muted: #7A7267;
                --accent: #2C5F2E;
                --accent-light: #EBF2EB;
                --radius: 12px;
            }
 
            body {
                font-family: 'DM Sans', sans-serif;
                background: var(--bg);
                color: var(--text);
                font-size: 15px;
                line-height: 1.6;
                min-height: 100vh;
            }
 
            nav {
                background: var(--surface);
                border-bottom: 1px solid var(--border);
                padding: 0 2rem;
                height: 60px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                position: sticky;
                top: 0;
                z-index: 100;
            }
            nav h1 {
                font-family: 'DM Serif Display', serif;
                font-size: 22px;
                font-weight: 400;
                color: var(--accent);
            }
            nav a {
                font-size: 13px;
                font-weight: 500;
                color: var(--text);
                text-decoration: none;
                border: 1px solid var(--border);
                padding: 7px 18px;
                border-radius: 99px;
                transition: background 0.15s;
            }
            nav a:hover { background: var(--bg); border-color: #c5bfb5; }
 
            .login-wrapper {
                min-height: calc(100vh - 60px);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem;
            }
 
            .login-card {
                background: var(--surface);
                border: 1px solid var(--border);
                border-radius: var(--radius);
                padding: 2.5rem 2rem;
                width: 100%;
                max-width: 380px;
            }
 
            .login-card h2 {
                font-family: 'DM Serif Display', serif;
                font-size: 26px;
                font-weight: 400;
                color: var(--text);
                margin-bottom: 0.25rem;
            }
 
            .login-card p.subtitle {
                font-size: 13px;
                color: var(--muted);
                margin-bottom: 2rem;
            }
 
            .field {
                display: flex;
                flex-direction: column;
                gap: 5px;
                margin-bottom: 1rem;
            }
 
            .field label {
                font-size: 12px;
                font-weight: 500;
                color: var(--muted);
            }
 
            .field input {
                height: 42px;
                border: 1px solid var(--border);
                border-radius: 8px;
                background: var(--surface);
                color: var(--text);
                font-family: 'DM Sans', sans-serif;
                font-size: 14px;
                padding: 0 12px;
                transition: border-color 0.15s;
            }
            .field input:focus {
                outline: none;
                border-color: var(--accent);
            }
 
            .btn-submit {
                width: 100%;
                height: 44px;
                margin-top: 0.5rem;
                background: var(--accent);
                color: #fff;
                border: none;
                border-radius: 8px;
                font-family: 'DM Sans', sans-serif;
                font-size: 14px;
                font-weight: 500;
                cursor: pointer;
                transition: opacity 0.15s;
            }
            .btn-submit:hover { opacity: 0.88; }
 
            .error-msg {
                background: #fef2f2;
                border: 1px solid #fecaca;
                color: #991b1b;
                font-size: 13px;
                padding: 10px 12px;
                border-radius: 8px;
                margin-bottom: 1.25rem;
            }
        </style>
        <nav>
            <h1>auberge.com</h1>
            <a href="login.php">Connexion</a>
        </nav>
    </head>
    <body>
 
        <div class="login-wrapper">
            <div class="login-card">
                <h2>Connexion</h2>
                <p class="subtitle">Entrez vos identifiants pour accéder à votre compte.</p>
 
                <?php if (!empty($error)): ?>
                    <div class="error-msg"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
 
                <form method="POST" action="">
                    <div class="field">
                        <label for="id">ID</label>
                        <input type="text" id="id" name="id" required>
                    </div>
                    <div class="field">
                        <label for="mot_de_passe">Mot de passe</label>
                        <input type="password" id="mot_de_passe" name="mot_de_passe" required>
                    </div>
                    <button type="submit" class="btn-submit">Se connecter</button>
                </form>
            </div>
        </div>
 
    </body>
</html>

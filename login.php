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
            $_SESSION['id_hotel'] = $user['id_hotel'];
            header("Location: employe/liste_all_reservation.php");
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
        <link rel="stylesheet" type="text/css" href="style.css">
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

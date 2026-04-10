<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Succes</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../style.css">
        <nav>
            <h1>auberge.com</h1>
            <div style="display: flex; gap: 10px; align-items: center;">
                <a href="index.php">&#127968</a>
        
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="liste_reservations.php">Mes Réservations</a>
                    <a href="../logout.php">Déconnexion</a>
                <?php else: ?>
                    <a href="../login.php">Connexion</a>
                <?php endif; ?>
            </div>
        </nav>
    </head>
    <body>
        <h1>Succès!</h1>
        <a href="liste_reservations.php">Voir mes réservations</a>
    </body>
</html>
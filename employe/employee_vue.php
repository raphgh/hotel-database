<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Employee</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../style.css">
        <nav>
            <h1>auberge.com</h1>
            <div style="display: flex; gap: 10px; align-items: center;">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="../logout.php">Déconnexion</a>
                <?php else: ?>
                    <a href="../login.php">Connexion</a>
                <?php endif; ?>
            </div>
        </nav>
    </head>
    <body>
 
    <div class="main" style="display: block; max-width: 900px; margin: 40px auto;">

    <div class="employee-tabs">
        <?php $current = basename($_SERVER['PHP_SELF']); ?>
        <a href="liste_all_reservation.php" class="tab-btn <?php echo ($current_page == 'liste_all_reservation.php') ? 'active' : ''; ?>">Convertir Réservation</a>
        <a href="liste_archives.php" class="tab-btn <?php echo ($current == 'liste_archives.php') ? 'active' : ''; ?>">Archives</a>
        <a href="manage_location.php" class="tab-btn <?php echo ($current_page == 'manage_location.php') ? 'active' : ''; ?>">Gérer locations</a>
        <a href="modifie_chambre.php" class="tab-btn <?php echo ($current_page == 'modifie_chambre.php') ? 'active' : ''; ?>">Modifier une chambre</a>
        <a href="vues.php" class="tab-btn <?php echo ($current_page == 'vues.php') ? 'active' : ''; ?>">Capacité Totale</a>
    </div>

    <div class="tab-container">
        </div>
</div>
    </body>
</html>

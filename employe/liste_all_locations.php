<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db.php';

if (!isset($_SESSION['id_hotel'])) {
    header("Location: ../login.php");
    exit();
}

$id_hotel = $_SESSION['id_hotel'];

$query = "SELECT 
            l.id_location, 
            l.id_client, 
            l.num_chambre, 
            l.date_check_in, 
            l.date_check_out, 
            c.nom_complet 
          FROM Location l
          INNER JOIN Client c ON l.id_client = c.id_client
          WHERE l.id_hotel = $1 
          ORDER BY l.date_check_in ASC";

$res = pg_query_params($conn, $query, array($id_hotel));

if (!$res) {
    die("Erreur SQL : " . pg_last_error($conn));
}

$locations = pg_fetch_all($res) ?: [];
$current_page = basename($_SERVER['PHP_SELF']);
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
        <a href="liste_all_reservation.php" class="tab-btn <?php echo ($current_page == 'liste_all_reservation.php') ? 'active' : ''; ?>">Réservations</a>
        <a href="liste_all_locations.php" class="tab-btn <?php echo ($current_page == 'liste_all_locations.php') ? 'active' : ''; ?>">Locations</a>
        <a href="liste_archives.php" class="tab-btn <?php echo ($current_page == 'liste_archives.php') ? 'active' : ''; ?>">Archives</a>
        <a href="manage_location.php" class="tab-btn <?php echo ($current_page == 'manage_location.php') ? 'active' : ''; ?>">Ajouter locations</a>
        <a href="modifie_chambre.php" class="tab-btn <?php echo ($current_page == 'modifie_chambre.php') ? 'active' : ''; ?>">Modifier une chambre</a>
        <a href="vues.php" class="tab-btn <?php echo ($current_page == 'vues.php') ? 'active' : ''; ?>">Capacité Totale</a>
    </div>

    <div class="tab-container">
    <div class="main" style="display: block; max-width: 900px; margin: 40px auto;">

    <div class="tab-container">       
        <div class="results-list">
            <?php if (!empty($locations)): ?>
                <?php foreach ($locations as $res): ?>
                    <div class="horizontal-card">
                        <div class="card-content">
                            <div class="card-header">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                    <div>
                                        <h4><b><?php echo htmlspecialchars($res['nom_complet']); ?></b></h4>
                                        <p class="address">Client ID: #<?php echo $res['id_client']; ?></p>
                                    </div>
                                    <div style="text-align: right;">
                                        <span class="type-tag" style="background: var(--accent-light); color: var(--accent); padding: 4px 12px; border-radius: 4px; font-weight: 500;">
                                            Chambre #<?php echo $res['num_chambre']; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer" style="margin-top: 15px; border-top: 1px dashed var(--border); padding-top: 15px;">
                                <div>
                                    <p style="font-size: 12px; color: var(--muted); text-transform: uppercase;">Séjour</p>
                                    <p style="font-size: 14px; font-weight: 500;">
                                        Du <?php echo $res['date_check_in']; ?> au <?php echo $res['date_check_out']; ?>
                                    </p>
                                </div>
                                <form action="supprime_location.php" method="POST">
                                    <input type="hidden" name="id_location" value="<?php echo $res['id_location']; ?>">
                                    <button type="submit" class="btn-cancel">
                                        Annuler / Check-out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-results">Aucune location trouvée pour cet hôtel.</div>
            <?php endif; ?>
        </div>
    </div>
    </body>
</html>

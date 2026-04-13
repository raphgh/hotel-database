<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$id_hotel = $_SESSION['id_hotel'];

$query = "SELECT * FROM archive WHERE id_hotel = $1 ORDER BY id_archive DESC";
$result = pg_query_params($conn, $query, [$id_hotel]);
$archives = pg_fetch_all($result) ?: [];

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
    <html>
        <head>
            <title>Archives</title>
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
                <div class="archive-list">
                    <?php if (!empty($archives)): ?>
                        <?php foreach ($archives as $row): ?>
                            <div class="archive-card">
                                <div class="archive-header">
                                    <div class="id-badge">Archive #<?php echo htmlspecialchars($row['id_archive']); ?></div>
                                    <span class="type-tag <?php echo strtolower($row['type']); ?>">
                                        <?php echo htmlspecialchars($row['type']); ?>
                                    </span>
                                </div>
                                <div class="archive-body">
                                    <div class="info-group">
                                        <label>Client ID</label>
                                        <p><?php echo htmlspecialchars($row['id_client']); ?></p>
                                    </div>
                                    <div class="info-group">
                                        <label>Période</label>
                                        <p>Du <b><?php echo $row['date_debut']; ?></b> au <b><?php echo $row['date_fin']; ?></b></p>
                                    </div>
                                </div>
                                <div class="archive-footer">
                                    <small>Ref: #<?php echo htmlspecialchars($row['id_reservation'] ?? $row['id_location'] ?? 'N/A'); ?></small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="no-results">Aucun historique trouvé pour cet hôtel.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>
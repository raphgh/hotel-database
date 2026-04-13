<?php
session_start();
include '../db.php';

$id_hotel = $_SESSION['id_hotel'];

$summary_res = pg_query_params($conn, "SELECT * FROM vue_capacite_hotel_header WHERE id_hotel = $1", [$id_hotel]);
$stats = pg_fetch_assoc($summary_res);

$rooms_res = pg_query_params($conn, "SELECT * FROM vue_liste_chambres_complete WHERE id_hotel = $1 ORDER BY num_chambre ASC", [$id_hotel]);
$rooms = pg_fetch_all($rooms_res) ?: [];

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
        <div style="display: flex; gap: 20px; margin-bottom: 30px; background: var(--accent-light); padding: 20px; border-radius: var(--radius); border: 1px solid var(--border);">
            <div style="flex: 1; text-align: center; border-right: 1px solid var(--border);">
                <span style="font-size: 12px; color: var(--muted); text-transform: uppercase; font-weight: 500;">Chambres Totales</span>
                <p style="font-size: 24px; font-weight: 500; color: var(--text);"><?php echo $stats['nb_chambres_total'] ?? 0; ?></p>
            </div>
            <div style="flex: 1; text-align: center;">
                <span style="font-size: 12px; color: var(--muted); text-transform: uppercase; font-weight: 500;">Capacité</span>
                <p style="font-size: 24px; font-weight: 500; color: var(--accent);"><?php echo $stats['capacite_totale'] ?? 0; ?> Personnes</p>
            </div>
        </div>

        <h3>Inventaire:</h3>
            <div class="results-list">
                <?php foreach ($rooms as $room): ?>
                    <div class="horizontal-card">
                        <div class="card-image">
                            <img src="../media/hotel_room.png" alt="chambre">
                        </div>
                        <div class="card-content">
                            <div class="card-header">
                                <div style="display: flex; justify-content: space-between;">
                                    <h4><b>Chambre #<?php echo htmlspecialchars($room['num_chambre']); ?></b></h4>
                                    <span style="font-size: 13px; font-weight: 500; color: var(--accent); background: #fff; border: 1px solid var(--accent); padding: 2px 8px; border-radius: 4px;">
                                        <?php echo $room['capacite']; ?> pers.
                                    </span>
                                </div>
                                <p class="address">Vue: <?php echo htmlspecialchars($room['vue']); ?></p>
                            </div>

                            <div class="card-footer">
                                <h1 class="price" style="font-size: 22px;"><?php echo $room['prix']; ?>$</h1>
                                
                                <div style="font-size: 12px; color: var(--muted);">
                                    État: <span style="color: #27ae60;"><?php echo $room['etat']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </body>
</html>

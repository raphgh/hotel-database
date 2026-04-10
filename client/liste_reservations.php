<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id_client = $_SESSION['user_id'];

$query = "SELECT r.*, h.nom_hotel, h.adresse, h.categorie, c.prix 
          FROM Reservation r
          JOIN Hotel h ON r.id_hotel = h.id_hotel
          JOIN Chambre c ON r.num_chambre = c.num_chambre AND r.id_hotel = c.id_hotel
          WHERE r.id_client = $1
          ORDER BY r.date_debut DESC";

$result = pg_query_params($conn, $query, [$id_client]);
$my_bookings = pg_fetch_all($result) ?: [];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Mes Réservations</title>
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
        <div class="main" style="display: block; max-width: 800px;">
            <h2 style="margin-bottom: 20px; font-family: 'DM Serif Display', serif;">Mes Réservations</h2>

            <?php if (!empty($my_bookings)): ?>
                <div class="results-list">
                    <?php foreach ($my_bookings as $row): ?>
                        <div class="horizontal-card">

                            <div class="card-image">
                                <img src="../media/hotel_room.png" alt="chambre">
                            </div>

                            <div class="card-content">
                                <div class="card-header">
                                    <div style="display: flex; justify-content: space-between; align-items: start;">
                                        <div>
                                            <h4><b><?php echo htmlspecialchars($row['nom_hotel']); ?></b></h4>
                                            <p class="address"><?php echo htmlspecialchars($row['adresse']); ?></p>
                                        </div>
                                        <span style="font-size: 11px; text-transform: uppercase; background: var(--accent-light); color: var(--accent); padding: 4px 10px; border-radius: 20px; font-weight: 500;">
                                            <?php echo htmlspecialchars($row['status']); ?>
                                        </span>
                                    </div>
                                    <p style="font-size: 13px; margin-top: 10px; color: var(--muted);">
                                        <b>Séjour:</b> Du <?php echo $row['date_debut']; ?> au <?php echo $row['date_fin']; ?>
                                    </p>
                                </div>

                                <div class="card-footer">
                                    <h1 class="price"><?php echo $row['prix']; ?>$</h1>

                                    <form action="supprime_reservation.php" method="POST" onsubmit="return confirm('Voulez-vous vraiment annuler cette réservation ?');">
                                        <input type="hidden" name="id_res" value="<?php echo $row['id_reservation']; ?>">
                                        
                                        <button type="submit" class="btn-reserve" style="background: #a32a2a; border-color: #a32a2a;">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="no-results">Vous n'avez aucune réservation active.</p>
            <?php endif; ?>
        </div>
    </body>
</html>

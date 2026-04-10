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
                --star: #C4851A;
                --danger: #a32a2a;
                --danger-light: #fef2f2;
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
            .nav-links {
                display: flex;
                gap: 10px;
                align-items: center;
            }
            nav a {
                font-size: 13px;
                font-weight: 500;
                color: var(--text);
                text-decoration: none;
                border: 1px solid var(--border);
                padding: 7px 18px;
                border-radius: 99px;
                transition: background 0.15s, border-color 0.15s;
            }
            nav a:hover { background: var(--bg); border-color: #c5bfb5; }

            .main {
                max-width: 760px;
                margin: 2.5rem auto;
                padding: 0 1rem 3rem;
            }

            .page-title {
                font-family: 'DM Serif Display', serif;
                font-size: 28px;
                font-weight: 400;
                color: var(--text);
                margin-bottom: 1.5rem;
            }

            .results-list {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .horizontal-card {
                background: var(--surface);
                border: 1px solid var(--border);
                border-radius: var(--radius);
                display: grid;
                grid-template-columns: 150px 1fr;
                overflow: hidden;
                transition: border-color 0.2s, box-shadow 0.2s;
            }
            .horizontal-card:hover {
                border-color: #c5bfb5;
                box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            }

            .card-image img {
                width: 150px;
                height: 100%;
                min-height: 140px;
                object-fit: cover;
                display: block;
            }

            .card-content {
                padding: 1rem 1.25rem;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                gap: 0.75rem;
            }

            .card-header h4 {
                font-size: 15px;
                font-weight: 500;
                color: var(--text);
                margin-bottom: 2px;
            }
            .card-header h4 b { font-weight: 500; }

            .address {
                font-size: 12px;
                color: var(--muted);
            }

            .status-badge {
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: 0.04em;
                font-weight: 500;
                background: var(--accent-light);
                color: var(--accent);
                padding: 4px 10px;
                border-radius: 99px;
                white-space: nowrap;
            }

            .header-row {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 1rem;
            }

            .dates {
                font-size: 13px;
                color: var(--muted);
                margin-top: 8px;
            }
            .dates b { font-weight: 500; color: var(--text); }

            .card-footer {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .price {
                font-family: 'DM Serif Display', serif;
                font-size: 26px;
                font-weight: 400;
                color: var(--text);
            }

            .btn-cancel {
                height: 34px;
                padding: 0 16px;
                background: var(--danger-light);
                color: var(--danger);
                border: 1px solid #fecaca;
                border-radius: 8px;
                font-family: 'DM Sans', sans-serif;
                font-size: 13px;
                font-weight: 500;
                cursor: pointer;
                transition: background 0.15s;
            }
            .btn-cancel:hover { background: #fde8e8; }

            .no-results {
                background: var(--surface);
                border: 1px solid var(--border);
                border-radius: var(--radius);
                padding: 3rem;
                text-align: center;
                color: var(--muted);
                font-size: 14px;
            }
        </style>
        <nav>
            <h1>auberge.com</h1>
            <div class="nav-links">
                <a href="index.php">&#127968;</a>
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
        <div class="main">
            <h2 class="page-title">Mes Réservations</h2>

            <?php if (!empty($my_bookings)): ?>
                <div class="results-list">
                    <?php foreach ($my_bookings as $row): ?>
                        <div class="horizontal-card">
                            <div class="card-image">
                                <img src="../media/hotel_room.png" alt="chambre">
                            </div>
                            <div class="card-content">
                                <div class="card-header">
                                    <div class="header-row">
                                        <div>
                                            <h4><b><?php echo htmlspecialchars($row['nom_hotel']); ?></b></h4>
                                            <p class="address"><?php echo htmlspecialchars($row['adresse']); ?></p>
                                        </div>
                                        <span class="status-badge"><?php echo htmlspecialchars($row['status']); ?></span>
                                    </div>
                                    <p class="dates">
                                        <b>Séjour:</b> Du <?php echo $row['date_debut']; ?> au <?php echo $row['date_fin']; ?>
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <span class="price"><?php echo $row['prix']; ?>$</span>
                                    <form action="supprime_reservation.php" method="POST" onsubmit="return confirm('Voulez-vous vraiment annuler cette réservation ?');">
                                        <input type="hidden" name="id_res" value="<?php echo $row['id_reservation']; ?>">
                                        <button type="submit" class="btn-cancel">Annuler</button>
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

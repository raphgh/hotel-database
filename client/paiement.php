<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hotel = $_POST['hotel'];

    $res_hotel = pg_query_params($conn, "SELECT * FROM Hotel WHERE id_hotel = $1", [$hotel]);
    $row_h = pg_fetch_assoc($res_hotel);

    $res_client = pg_query_params($conn, "SELECT * FROM Client WHERE id_client = $1", [$_SESSION['user_id']]);
    $row_c = pg_fetch_assoc($res_client);
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Confirmation</title>
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

            .page-wrapper {
                max-width: 820px;
                margin: 2.5rem auto;
                padding: 0 1rem 3rem;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1.25rem;
                align-items: start;
            }

            .card {
                background: var(--surface);
                border: 1px solid var(--border);
                border-radius: var(--radius);
                padding: 1.75rem;
            }

            .card h2 {
                font-family: 'DM Serif Display', serif;
                font-size: 20px;
                font-weight: 400;
                color: var(--text);
                margin-bottom: 1.25rem;
                padding-bottom: 0.75rem;
                border-bottom: 1px solid var(--border);
            }

            .field {
                margin-bottom: 1rem;
            }
            .field:last-child { margin-bottom: 0; }

            .field label {
                display: block;
                font-size: 11px;
                font-weight: 500;
                letter-spacing: 0.05em;
                text-transform: uppercase;
                color: var(--muted);
                margin-bottom: 3px;
            }

            .field p {
                font-size: 14px;
                color: var(--text);
                font-weight: 500;
            }

            .field input {
                width: 100%;
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

            .divider { height: 1px; background: var(--border); margin: 1rem 0; }

            .total-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 1rem;
                padding-top: 1rem;
                border-top: 1px solid var(--border);
            }
            .total-label {
                font-size: 13px;
                color: var(--muted);
            }
            .total-amount {
                font-family: 'DM Serif Display', serif;
                font-size: 24px;
                font-weight: 400;
                color: var(--text);
            }

            .btn-submit {
                width: 100%;
                height: 44px;
                margin-top: 1.25rem;
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

            @media (max-width: 600px) {
                .page-wrapper { grid-template-columns: 1fr; }
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
        <div class="page-wrapper">

            <!-- Confirmation summary -->
            <div class="card">
                <h2>Confirmation</h2>

                <?php if (!empty($res_client)): ?>
                    <div class="field">
                        <label>Nom</label>
                        <p><?php echo htmlspecialchars($row_c['nom_complet']); ?></p>
                    </div>
                    <div class="field">
                        <label>Courriel</label>
                        <p><?php echo htmlspecialchars($row_c['email']); ?></p>
                    </div>
                    <div class="field">
                        <label>Téléphone</label>
                        <p><?php echo htmlspecialchars($row_c['telephone']); ?></p>
                    </div>
                    <div class="divider"></div>
                <?php endif; ?>

                <div class="field">
                    <label>Numéro de chambre</label>
                    <p><?php echo htmlspecialchars($_POST['num_chambre']); ?></p>
                </div>
                <div class="field">
                    <label>Date d'arrivée</label>
                    <p><?php echo htmlspecialchars($_POST['date_debut']); ?></p>
                </div>
                <div class="field">
                    <label>Date de départ</label>
                    <p><?php echo htmlspecialchars($_POST['date_fin']); ?></p>
                </div>

                <div class="total-row">
                    <span class="total-label">Montant total</span>
                    <span class="total-amount"><?php echo htmlspecialchars($_POST['prix']); ?>$</span>
                </div>
            </div>

            <!-- Payment form -->
            <div class="card">
                <h2>Paiement</h2>
                <form action="add_reservation.php" method="POST">
                    <input type="hidden" name="num_chambre" value="<?php echo htmlspecialchars($_POST['num_chambre']); ?>">
                    <input type="hidden" name="hotel" value="<?php echo htmlspecialchars($_POST['hotel']); ?>">
                    <input type="hidden" name="chaine" value="<?php echo htmlspecialchars($_POST['chaine']); ?>">
                    <input type="hidden" name="date_debut" value="<?php echo htmlspecialchars($_POST['date_debut']); ?>">
                    <input type="hidden" name="date_fin" value="<?php echo htmlspecialchars($_POST['date_fin']); ?>">

                    <div class="field">
                        <label>Titulaire de la carte</label>
                        <input type="text" name="card_name" required>
                    </div>
                    <div class="field">
                        <label>Numéro de carte</label>
                        <input type="text" name="card_num" placeholder="XXXX XXXX XXXX XXXX" required>
                    </div>

                    <button type="submit" class="btn-submit">Confirmer et payer</button>
                </form>
            </div>

        </div>
    </body>
</html>

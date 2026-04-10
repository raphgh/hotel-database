<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db.php';

$results = []; 
$searched = false;

if (isset($_GET['ville'])) {
    $searched = true;
    $ville = $_GET['ville'] ?? '';
    $capacite = $_GET['capacite'] ?? 0;
    $prix_max = $_GET['prix_max'] ?? '';
    $chaine = $_GET['chaine'] ?? '';
    $etoiles = $_GET['etoiles'] ?? '';
    $no_chambres = $_GET['no_chambres'] ?? '';
    $date_debut = $_GET['date_debut'] ?? '';
    $date_fin = $_GET['date_fin'] ?? '';

    $query = "SELECT * FROM Chambre c JOIN Hotel h USING(id_hotel) WHERE 1=1";
    $params = [];
    $count = 1;

    if (!empty($ville)) {
        $query .= " AND TRIM(SPLIT_PART(adresse, ',', 2)) = $" . $count++;
        $params[] = $ville;
    }

    if ($capacite !== '') {
        $query .= " AND c.capacite = $" . $count++; 
        $params[] = (int)$capacite;
    }

    if (!empty($prix_max)) {
        $query .= " AND c.prix <= $" . $count++;
        $params[] = (float)$prix_max;
    }

    if (!empty($chaine)) {
        $query .= " AND h.id_chaine = $" . $count++;
        $params[] = (int)$chaine;
    }

    if (!empty($etoiles)) {
        $query .= " AND h.categorie = $" . $count++;
        $params[] = (int)$etoiles;
    }

    if (!empty($no_chambres)) {
        $query .= " AND h.no_chambres >= $" . $count++;
        $params[] = (int)$nb_chambres;
    }

    $res = pg_query_params($conn, $query, $params);

    if ($res) {
        $results = pg_fetch_all($res) ?: []; 
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Index</title>
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

            /* NAV */
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
                color: var(--accent);
                letter-spacing: -0.3px;
                font-weight: 400;
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

            /* HERO SEARCH */
            .hero {
                background: var(--accent);
                padding: 3rem 2rem 3.5rem;
            }
            .hero-inner { max-width: 860px; margin: 0 auto; }
            .hero h2 {
                font-family: 'DM Serif Display', serif;
                font-size: 34px;
                color: #fff;
                margin-bottom: 1.5rem;
                font-weight: 400;
            }
            .search-grid {
                display: grid;
                grid-template-columns: 1.6fr 1fr 1fr 1fr;
                gap: 10px;
            }
            .field { display: flex; flex-direction: column; gap: 5px; }
            .field label {
                font-size: 11px;
                font-weight: 500;
                letter-spacing: 0.06em;
                text-transform: uppercase;
                color: rgba(255,255,255,0.7);
            }
            .field select,
            .field input[type="date"] {
                height: 44px;
                border: 1px solid rgba(255,255,255,0.25);
                border-radius: var(--radius);
                background: rgba(255,255,255,0.12);
                color: #fff;
                font-family: 'DM Sans', sans-serif;
                font-size: 14px;
                padding: 0 12px;
                appearance: none;
                -webkit-appearance: none;
                cursor: pointer;
                transition: border-color 0.15s, background 0.15s;
            }
            .field select option { background: #2C5F2E; color: #fff; }
            .field select:focus,
            .field input[type="date"]:focus {
                outline: none;
                border-color: rgba(255,255,255,0.6);
                background: rgba(255,255,255,0.2);
            }
            .field input[type="date"]::-webkit-calendar-picker-indicator { filter: invert(1); opacity: 0.7; }
            .btn-search {
                margin-top: 22px;
                height: 44px;
                padding: 0 24px;
                background: #fff;
                color: var(--accent);
                border: none;
                border-radius: var(--radius);
                font-family: 'DM Sans', sans-serif;
                font-size: 14px;
                font-weight: 500;
                cursor: pointer;
                transition: opacity 0.15s;
                white-space: nowrap;
            }
            .btn-search:hover { opacity: 0.9; }

            /* MAIN LAYOUT */
            .main {
                max-width: 860px;
                margin: 0 auto;
                padding: 2rem 1rem 3rem;
                display: grid;
                grid-template-columns: 210px 1fr;
                gap: 1.5rem;
                align-items: start;
            }

            /* FILTERS */
            .filters {
                background: var(--surface);
                border: 1px solid var(--border);
                border-radius: var(--radius);
                padding: 1.25rem;
            }
            .filters h3 {
                font-size: 13px;
                font-weight: 500;
                letter-spacing: 0.07em;
                text-transform: uppercase;
                color: var(--muted);
                margin-bottom: 1.1rem;
            }
            .filter-group { margin-bottom: 1rem; }
            .filter-group label {
                display: block;
                font-size: 12px;
                font-weight: 500;
                color: var(--muted);
                margin-bottom: 5px;
            }
            .filter-group select,
            .filter-group input[type="number"] {
                width: 100%;
                height: 36px;
                border: 1px solid var(--border);
                border-radius: 8px;
                background: var(--surface);
                color: var(--text);
                font-family: 'DM Sans', sans-serif;
                font-size: 13px;
                padding: 0 10px;
                appearance: none;
                -webkit-appearance: none;
                transition: border-color 0.15s;
            }
            .filter-group select:focus,
            .filter-group input[type="number"]:focus {
                outline: none;
                border-color: var(--accent);
            }
            .btn-filter {
                width: 100%;
                height: 36px;
                border: 1px solid var(--accent);
                border-radius: 8px;
                background: var(--accent-light);
                color: var(--accent);
                font-family: 'DM Sans', sans-serif;
                font-size: 13px;
                font-weight: 500;
                cursor: pointer;
                transition: background 0.15s;
            }
            .btn-filter:hover { background: #d9ebd9; }
            .divider { height: 1px; background: var(--border); margin: 1rem 0; }

            /* RESULTS */
            .results-title {
                font-size: 16px;
                font-weight: 500;
                color: var(--text);
                margin-bottom: 1rem;
            }
            .results-title span { color: var(--muted); font-weight: 400; font-size: 14px; }

            .no-results {
                background: var(--surface);
                border: 1px solid var(--border);
                border-radius: var(--radius);
                padding: 2.5rem;
                text-align: center;
                color: var(--muted);
                font-size: 14px;
            }

            /* HOTEL CARD */
            .horizontal-card {
                background: var(--surface);
                border: 1px solid var(--border);
                border-radius: var(--radius);
                display: grid;
                grid-template-columns: 150px 1fr;
                overflow: hidden;
                margin-bottom: 12px;
                transition: border-color 0.2s, box-shadow 0.2s;
            }
            .horizontal-card:hover {
                border-color: #c5bfb5;
                box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            }
            .card-image img {
                width: 150px;
                height: 130px;
                object-fit: cover;
                display: block;
            }
            .card-content {
                padding: 1rem 1.25rem;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
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
                margin-bottom: 5px;
            }
            .stars { font-size: 12px; color: var(--star); letter-spacing: 1px; }
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
            .btn-reserve {
                height: 34px;
                padding: 0 16px;
                background: var(--accent);
                color: #fff;
                border: none;
                border-radius: 8px;
                font-family: 'DM Sans', sans-serif;
                font-size: 13px;
                font-weight: 500;
                cursor: pointer;
                transition: opacity 0.15s;
            }
            .btn-reserve:hover { opacity: 0.85; }

            @media (max-width: 640px) {
                .search-grid { grid-template-columns: 1fr 1fr; }
                .main { grid-template-columns: 1fr; }
                .horizontal-card { grid-template-columns: 110px 1fr; }
                .card-image img { width: 110px; height: 110px; }
            }
        </style>
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

        <div class="hero">
            <div class="hero-inner">
                <h2>Où souhaitez-vous aller?</h2>
                <form method="GET" action="index.php" id="searchForm">
                    <div class="search-grid">
                        <div class="field">
                            <label>Ville</label>
                            <select name="ville">
                                <option value="" disabled selected hidden>Ville</option>
                                <option value="Ottawa">Ottawa</option>
                                <option value="Québec">Québec</option>
                                <option value="Halifax">Halifax</option>
                                <option value="Calgary">Calgary</option>
                                <option value="Montréal">Montréal</option>
                                <option value="Edmonton">Edmonton</option>
                                <option value="Vancouver">Vancouver</option>
                                <option value="Toronto">Toronto</option>
                                <option value="Hamilton">Hamilton</option>
                                <option value="Regina">Regina</option>
                                <option value="Winnipeg">Winnipeg</option>
                            </select>
                        </div>
                        <div class="field">
                            <label>Date d'arrivée</label>
                            <input type="date" id="start" name="date_debut" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="field">
                            <label>Date de sortie</label>
                            <input type="date" id="end" name="date_fin" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                        </div>
                        <div class="field">
                            <label>Capacité</label>
                            <select name="capacite">
                                <option value="" disabled selected hidden># personnes</option>
                                <option type="number" value="1">1 personne</option>
                                <option type="number" value="2">2 personnes</option>
                                <option type="number" value="3">3 personnes</option>
                                <option type="number" value="4">4 personnes</option>
                                <option type="number" value="5">5 personnes</option>
                                <option type="number" value="6">6 personnes</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn-search">Rechercher →</button>
                </form>
            </div>
        </div>

        <div class="main">

            <aside>
                <div class="filters">
                    <form action="index.php" method="GET">
                        <input type="hidden" name="ville" value="<?php echo htmlspecialchars($_GET['ville'] ?? ''); ?>">
                        <input type="hidden" name="capacite" value="<?php echo htmlspecialchars($_GET['capacite'] ?? ''); ?>">
                        <input type="hidden" name="date_debut" value="<?php echo htmlspecialchars($_GET['date_debut'] ?? ''); ?>">
                        <input type="hidden" name="date_fin" value="<?php echo htmlspecialchars($_GET['date_fin'] ?? ''); ?>">

                        <h3>Filtres</h3>

                        <div class="filter-group">
                            <label>Prix Max:</label>
                            <input type="number" name="prix_max" value="<?php echo $_GET['prix_max'] ?? ''; ?>" placeholder="200">
                        </div>

                        <div class="divider"></div>

                        <div class="filter-group">
                            <label>Chaîne Hôtelière:</label>
                            <select name="chaine">
                                <option value="">Toutes</option>
                                <option value="1">Marriott</option>
                                <option value="2">Hilton</option>
                                <option value="3">Best Western</option>
                                <option value="4">Hyatt</option>
                                <option value="5">Wyndham</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Étoiles (Min):</label>
                            <select name="etoiles">
                                <option value="">Toutes</option>
                                <option value="1">★</option>
                                <option value="2">★★</option>
                                <option value="3">★★★</option>
                                <option value="4">★★★★</option>
                                <option value="5">★★★★★</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Nombre total de chambres dans l'hôtel (Min):</label>
                            <input type="number" name="no_chambres" placeholder="7">
                        </div>

                        <button type="submit" class="btn-filter">Appliquer les filtres</button>
                    </form>
                </div>
            </aside>

            <section>
                <?php if ($searched): ?>
                    <p class="results-title">Chambres disponibles
                        <?php if (!empty($results)): ?>
                            <span>— <?php echo count($results); ?> résultat<?php echo count($results) > 1 ? 's' : ''; ?></span>
                        <?php endif; ?>
                    </p>

                    <?php if (!empty($results)): ?>
                        <div class="results-list">
                            <?php foreach ($results as $row): ?>
                                <div class="horizontal-card">

                                    <div class="card-image">
                                        <img src="../media/hotel_room.png" alt="chambre">
                                    </div>

                                    <div class="card-content">
                                        <div class="card-header">
                                            <h4><b><?php echo $row['nom_hotel']; ?></b></h4>
                                            <p class="address"><?php echo $row['adresse']; ?></p>
                                            <div class="stars">
                                                <?php echo str_repeat('★', (int)$row['categorie']); ?>
                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            <h1 class="price"><?php echo $row['prix']; ?>$</h1>

                                            <form action="paiement.php" method="POST">
                                                <input type="hidden" name="num_chambre" value="<?php echo $row['num_chambre']; ?>">
                                                <input type="hidden" name="hotel" value="<?php echo $row['id_hotel']; ?>">
                                                <input type="hidden" name="chaine" value="<?php echo $row['id_chaine']; ?>">
                                                <input type="hidden" name="prix" value="<?php echo $row['prix']; ?>">
                                                
                                                <input type="hidden" name="date_debut" value="<?php echo htmlspecialchars($_GET['date_debut'] ?? ''); ?>">
                                                <input type="hidden" name="date_fin" value="<?php echo htmlspecialchars($_GET['date_fin'] ?? ''); ?>">

                                                <button type="submit" class="btn-reserve">
                                                    Réserver maintenant
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="no-results">Aucune chambre trouvée.</p>
                    <?php endif; ?>
                <?php endif; ?>
            </section>

        </div>

    </body>
</html>

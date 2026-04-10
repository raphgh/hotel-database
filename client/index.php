<?php
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
            <link rel="stylesheet" type="text/css" href="../style.css">
            <nav>
                <h1>auberge.com</h1>
                <a href="../login.php">Connexion</a>
            </nav>
        </head>
        <body>
            <form method="GET" action="index.php" id="searchForm">
        
                <label>Où vas-tu?</label>
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

                <label for="start">Date d'arrivée</label>
                <input type="date" id="start" name="stay-start" value="2026-04-11" min="2024-04-11" required>

                <label for="end">Date de sortie</label>
                <input type="date" id="end" name="stay-end" value="2026-04-12" min="2024-04-12" required>

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

                <button type="submit">Rechercher</button>
            </form>

            <div class="filters">
                <form action="index.php" method="GET">
                    <input type="hidden" name="ville" value="<?php echo htmlspecialchars($_GET['ville'] ?? ''); ?>">
                    <input type="hidden" name="capacite" value="<?php echo htmlspecialchars($_GET['capacite'] ?? ''); ?>">
                    
                    <h3>Filtres</h3>

                    <label>Prix Max:</label>
                    <input type="number" name="prix_max" value="<?php echo $_GET['prix_max'] ?? ''; ?>" placeholder="200">

                    <label>Chaîne Hôtelière:</label>
                    <select name="chaine">
                        <option value="">Toutes</option>
                        <option value="1">Marriott</option>
                        <option value="2">Hilton</option>
                        <option value="3">Best Western</option>
                        <option value="4">Hyatt</option>
                        <option value="5">Wyndham</option>
                        </select>

                    <label>Étoiles (Min):</label>
                    <select name="etoiles">
                        <option value="">Toutes</option>
                        <option value="1">★</option>
                        <option value="2">★★</option>
                        <option value="3">★★★</option>
                        <option value="4">★★★★</option>
                        <option value="5">★★★★★</option>
                    </select>

                    <label>Nombre de chambres total dans l'hôtel (Min):</label>
                    <input type="number" name="no_chambres" placeholder="7">

                    <button type="submit">Appliquer les filtres</button>
                </form>
            </div>

            <?php if ($searched): ?>
                <h2>Chambres disponibles</h1>

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
                                        
                                        <form action="add_reservation.php" method="POST">
                                            <input type="hidden" name="id_chambre" value="<?php echo $row['num_chambre']; ?>">
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
        </body>
    </html> 

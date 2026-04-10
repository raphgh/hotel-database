<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['id_hotel'])) {
    header("Location: ../login.php");
    exit();
}

$id_hotel = $_SESSION['id_hotel'];
$results = [];

$capacite = $_GET['capacite'] ?? '';
$query = "SELECT * FROM Chambre WHERE id_hotel = $1";
$params = [$id_hotel];

if (!empty($capacite)) {
    $query .= " AND capacite = $2";
    $params[] = (int)$capacite;
}

$res = pg_query_params($conn, $query, $params);
$results = pg_fetch_all($res) ?: [];
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
                <a href="index.php">&#127968</a>
        
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
                <a href="liste_all_reservation.php" class="tab-btn <?php echo ($current_page == 'liste_all_reservation.php') ? 'active' : ''; ?>">Convertir Réservation</a>
                <a href="liste_archives.php" class="tab-btn <?php echo ($current_page == 'liste_archives.php') ? 'active' : ''; ?>">Archives</a>
                <a href="manage_location.php" class="tab-btn <?php echo ($current_page == 'manage_location.php') ? 'active' : ''; ?>">Gérer locations</a>
                <a href="modifie_chambre.php" class="tab-btn <?php echo ($current_page == 'modifie_chambre.php') ? 'active' : ''; ?>">Modifier une chambre</a>
                <a href="vues.php" class="tab-btn <?php echo ($current_page == 'vues.php') ? 'active' : ''; ?>">Capacité Totale</a>
            </div>

            <div class="tab-container">
                <section>
                    <div class="hero" style="padding: 2rem 2rem;">
                        <div class="hero-inner">
                            <form method="GET" action="manage_location.php">
                                <div class="search-grid" style="grid-template-columns: 1fr 1fr;">
                                    <div class="field">
                                        <label>Capacité Requise</label>
                                        <select name="capacite" onchange="this.form.submit()">
                                            <option value="">Toutes les capacités</option>
                                            <?php for($i=1; $i<=6; $i++): ?>
                                                <option value="<?php echo $i; ?>" <?php echo ($capacite == $i) ? 'selected' : ''; ?>>
                                                    <?php echo $i; ?> personne<?php echo $i>1?'s':''; ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="results-list">
                        <?php foreach ($results as $row): ?>
                            <div class="horizontal-card">
                                <div class="card-image">
                                    <img src="../media/hotel_room.png" alt="chambre">
                                </div>
                                <div class="card-content">
                                    <div class="card-header">
                                        <h4><b>Chambre #<?php echo $row['num_chambre']; ?></b></h4>
                                        <p class="address">Capacité: <?php echo $row['capacite']; ?> personnes</p>
                                    </div>

                                    <div class="card-footer">
                                        <h1 class="price"><?php echo $row['prix']; ?>$</h1>

                                        <form action="process_walkin.php" method="POST" style="display: flex; gap: 8px;">
                                            <input type="hidden" name="num_chambre" value="<?php echo $row['num_chambre']; ?>">
                                            <input type="number" name="id_client" placeholder="ID Client" required 
                                                style="width: 100px; height: 34px; padding: 0 10px; border-radius: 8px; border: 1px solid var(--border);">
                                            <button type="submit" class="btn-reserve">Louer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            </div>
        </div>
    </body>
</html>
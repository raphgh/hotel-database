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

                                    <div class="card-footer" style="padding: 16px 20px; background: #fff; border-top: 1px solid var(--border);">
                                        <form action="add_location.php" method="POST" style="display: flex; align-items: flex-end; gap: 12px; width: 100%;">
                                            <input type="hidden" name="num_chambre" value="<?php echo $row['num_chambre']; ?>">
                                            <input type="hidden" name="date_check_in" value="<?php echo date('Y-m-d'); ?>">
                                            
                                            <div style="flex-grow: 1; padding-bottom: 4px;">
                                                <h1 class="price"><?php echo $row['prix']; ?>$</h1>
                                            </div>

                                            <div class="input-container">
                                                <label style="display: block; font-size: 10px; font-weight: 700; color: var(--text-light); text-transform: uppercase; margin-bottom: 4px; letter-spacing: 0.5px;">
                                                    Client ID
                                                </label>
                                                <input type="number" name="id_client" placeholder="0000" required 
                                                    style="width: 100px; height: 38px; padding: 0 12px; border-radius: 8px; border: 1px solid var(--border); font-size: 14px; background: #fafafa;">
                                            </div>

                                            <div class="input-container">
                                                <label style="display: block; font-size: 10px; font-weight: 700; color: var(--text-light); text-transform: uppercase; margin-bottom: 4px; letter-spacing: 0.5px;">
                                                    Date de Sortie
                                                </label>
                                                <input type="date" name="date_check_out" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required 
                                                    style="width: 155px; height: 38px; padding: 0 12px; border-radius: 8px; border: 1px solid var(--border); font-size: 14px; background: #fafafa; color: #444;">
                                            </div>

                                            <button type="submit" class="btn-reserve" 
                                                style="height: 38px; padding: 0 24px; border-radius: 8px; background: var(--accent); color: white; border: none; font-weight: 600; cursor: pointer; margin-bottom: 0;">
                                                Louer
                                            </button>
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
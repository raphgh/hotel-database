<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db.php';

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_changes'])) {
    $num = $_POST['num_chambre'];
    $hotel = $_SESSION['id_hotel'];
    $commodites = $_POST['commodites'];
    $etat = $_POST['etat'];
    $prix = $_POST['prix'];
    $capacite = $_POST['capacite'];

    $updateQuery = "UPDATE chambre 
                    SET commodites = $1, etat = $2, prix = $3, capacite = $4 
                    WHERE num_chambre = $5 AND id_hotel = $6";

    $res = pg_query_params($conn, $updateQuery, [$commodites, $etat, $prix, $capacite, $num, $hotel]);

    if ($res) {
        $message = "Chambre $num mise à jour avec succès!";
    } else {
        $message = "Erreur: " . pg_last_error($conn);
    }
}

$hotel_id = $_SESSION['id_hotel'];
$target_room_id = $_GET['target_room'] ?? ($_POST['num_chambre'] ?? '');
$room_data = null; 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Employee - Modifier Chambre</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../style.css">
    </head>
    <body class="room-manager">
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
 
    <div class="main" style="display: block; max-width: 900px; margin: 40px auto;">

        <div class="employee-tabs">
            <a href="liste_all_reservation.php" class="tab-btn">Réservations</a>
            <a href="liste_all_locations.php" class="tab-btn">Locations</a>
            <a href="liste_archives.php" class="tab-btn">Archives</a>
            <a href="manage_location.php" class="tab-btn">Ajouter locations</a>
            <a href="modifie_chambre.php" class="tab-btn active">Modifier une chambre</a>
            <a href="vues.php" class="tab-btn">Capacité Totale</a>
        </div>
        
        <div class="manage-container">
            <?php if ($message): ?>
                <div class="mgr-alert">
                    <span style="font-size: 18px;">✓</span>
                    <div><?php echo $message; ?></div>
                </div>
            <?php endif; ?>

            <div class="edit-card">
                <form method="GET" style="margin-bottom: 30px; border-bottom: 1px solid var(--border); padding-bottom: 20px;">
                    <div class="field-group">
                        <label class="input-label">Choisir une chambre</label>
                        <select name="target_room" onchange="this.form.submit()" class="mgr-input">
                            <option value="">-- Sélectionner --</option>
                            <?php
                            $rooms_list = pg_query_params($conn, "SELECT num_chambre FROM chambre WHERE id_hotel = $1 ORDER BY num_chambre", [$hotel_id]);
                            while ($option = pg_fetch_assoc($rooms_list)) {
                                $selected = ($target_room_id == $option['num_chambre']) ? 'selected' : '';
                                echo "<option value='{$option['num_chambre']}' $selected>Chambre {$option['num_chambre']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </form>

                <?php if (!empty($target_room_id)): 
                    $q = "SELECT * FROM chambre WHERE num_chambre = $1 AND id_hotel = $2";
                    $res = pg_query_params($conn, $q, [$target_room_id, $hotel_id]);
                    $room_data = pg_fetch_assoc($res);

                    if ($room_data): ?>
                        <form action="modifie_chambre.php" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
                            <input type="hidden" name="num_chambre" value="<?php echo $room_data['num_chambre']; ?>">
                            <input type="hidden" name="save_changes" value="1">
                            

                            <div>
                                <label class="input-label">Prix la nuit ($)</label>
                                <input type="number" name="prix" value="<?php echo $room_data['prix']; ?>" class="mgr-input">
                            </div>

                            <div>
                                <label class="input-label">Capacité</label>
                                <input type="number" name="capacite" value="<?php echo $room_data['capacite']; ?>" class="mgr-input">
                            </div>

                            <div>
                                <label class="input-label">Commodités</label>
                                <textarea name="commodites" class="mgr-input"><?php echo htmlspecialchars($room_data['commodites']); ?></textarea>
                            </div>

                            <div>
                                <label class="input-label">État Physique</label>
                                <input type="text" name="etat" value="<?php echo htmlspecialchars($room_data['etat']); ?>" class="mgr-input">
                            </div>

                            <div class="btn-container">
                                <button type="submit" class="btn-management">Sauvegarder les modifications</button>
                            </div>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div> </body>
</html>
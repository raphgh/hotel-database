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
        <div class="login-card">
            <h2>Confirmation</h2>
                <div class="field">
                    <label>Nom</label>
                    <p>
                        <?php if (!empty($res_client)): ?>
                            <?php echo $row_c['nom_complet']; ?>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="field">
                    <label>Courriel</label>
                    <p>
                        <?php if (!empty($res_client)): ?>
                            <?php echo $row_c['email']; ?>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="field">
                    <label>Telephone</label>
                    <p>
                        <?php if (!empty($res_client)): ?>
                            <?php echo $row_c['telephone']; ?>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="field">
                    <label>Numero de chambre</label>
                    <p><?php echo $_POST['num_chambre']; ?></p>
                </div>
                <div class="field">
                    <label>Date de debut</label>
                    <p><?php echo $_POST['date_debut']; ?></p>
                </div>
                <div class="field">
                    <label>Date de fin</label>
                    <p><?php echo $_POST['date_fin']; ?></p>
                </div>
                <div class="field">
                    <label>Montant</label>
                    <p><?php echo $_POST['prix'] . '$'; ?></p>
                </div>
        </div>
        <div class="login-card">
            <h2>Paiement</h2>

            <form action="add_reservation.php" method="POST">
                <input type="hidden" name="num_chambre" value="<?php echo $_POST['num_chambre']; ?>">
                <input type="hidden" name="hotel" value="<?php echo $_POST['hotel']; ?>">
                <input type="hidden" name="chaine" value="<?php echo $_POST['chaine']; ?>">
                <input type="hidden" name="date_debut" value="<?php echo $_POST['date_debut']; ?>">
                <input type="hidden" name="date_fin" value="<?php echo $_POST['date_fin']; ?>">


                <div class="field">
                    <label>Titulaire de la carte</label>
                    <input type="text" name="card_name" required>
                </div>
                <div class="field">
                    <label>Numéro de carte</label>
                    <input type="text" name="card_num" placeholder="XXXX XXXX XXXX XXXX" required>
                </div>
                
                <button type="submit" class="btn-submit">Confirmer et Payer</button>
            </form>
        </div>
    </body>
</html>
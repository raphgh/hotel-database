<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    die("Erreur : Session expirée. Veuillez vous reconnecter.");
}

$id_reservation = $_POST['id_reservation'];
$id_hotel = $_SESSION['id_hotel'];
$id_employe = $_SESSION['user_id']; 

$results = pg_query_params($conn, "SELECT * FROM reservation WHERE id_reservation = $1", [$id_reservation]);
$res = pg_fetch_assoc($results);

if ($res) {
    pg_query($conn, "BEGIN");

    $query = "INSERT INTO location (
                date_check_in, 
                date_check_out, 
                status, 
                num_chambre, 
                id_reservation, 
                id_client, 
                id_hotel, 
                id_chaine,
                id_employe
              ) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9)";

    $params = [
        $res['date_debut'], 
        $res['date_fin'], 
        'active', 
        $res['num_chambre'], 
        $res['id_reservation'], 
        $res['id_client'], 
        $res['id_hotel'], 
        $res['id_chaine'],
        $id_employe 
    ];

    $res_ins = pg_query_params($conn, $query, $params);

    $res_del = pg_query_params($conn, "DELETE FROM reservation WHERE id_reservation = $1", [$id_reservation]);

    if ($res_ins && $res_del) {
        pg_query($conn, "COMMIT");
        header("Location: liste_all_locations.php");
    } else {
        pg_query($conn, "ROLLBACK");
        echo "Conversion failed: " . pg_last_error($conn);
    }
}
?>
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_res'])) {
    $id_res = $_POST['id_res'];

    pg_query($conn, "BEGIN");

    $archiveQuery = "INSERT INTO archive (type, id_client, date_debut, date_fin, id_reservation)
                    SELECT 
                        'reservation', 
                        r.id_client,
                        r.date_debut, 
                        r.date_fin, 
                        r.id_reservation
                    FROM reservation r
                    WHERE r.id_reservation = $1";

    $res1 = pg_query_params($conn, $archiveQuery, [$id_res]);

    $deleteQuery = "DELETE FROM reservation WHERE id_reservation = $1";
    $res2 = pg_query_params($conn, $deleteQuery, [$id_res]);

    if ($res1 && $res2) {
        pg_query($conn, "COMMIT");
        header("Location: liste_reservations.php");
        exit();
    } else {
        pg_query($conn, "ROLLBACK");
        die("Erreur SQL: " . pg_last_error($conn));
    }
} else {
    header("Location: liste_reservations.php");
    exit();
}
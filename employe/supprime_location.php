<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_location'])) {
    $id_location = $_POST['id_location'];

    pg_query($conn, "BEGIN");

    $archiveQuery = "INSERT INTO archive (type, id_client, date_debut, date_fin, id_location, id_hotel)
                    SELECT 
                        'location', 
                        id_client,
                        date_check_in, 
                        date_check_out, 
                        id_location,
                        id_hotel
                    FROM location
                    WHERE id_location = $1";

    $res1 = pg_query_params($conn, $archiveQuery, [$id_location]);

    $deleteQuery = "DELETE FROM location WHERE id_location = $1";
    $res2 = pg_query_params($conn, $deleteQuery, [$id_location]);

    if ($res1 && $res2) {
        pg_query($conn, "COMMIT");
        header("Location: liste_archives.php");
        exit();
    } else {
        pg_query($conn, "ROLLBACK");
        die("Erreur SQL: " . pg_last_error($conn));
    }
} else {
    header("Location: liste_all_locations.php");
    exit();
}
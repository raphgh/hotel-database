<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_client = $_SESSION['user_id'];
    $num_chambre = $_POST['num_chambre'];
    $hotel = $_POST['hotel'];
    $chaine = $_POST['chaine'];
    $date_debut = $_POST['date_debut']; 
    $date_fin = $_POST['date_fin']; 
    $status = 'processed';

    $query = "INSERT INTO Reservation (id_client, num_chambre, date_debut, date_fin, id_hotel, id_chaine, status) VALUES ($1, $2, $3, $4, $5, $6, $7)";
    $result = pg_query_params($conn, $query, [$id_client, $num_chambre, $date_debut, $date_fin, $hotel, $chaine, $status]);

    if ($result) {
        header("Location: succes.php");
        exit();
    } else {
        echo "Erreur lors de la réservation : " . pg_last_error($conn);
    }
}
?>


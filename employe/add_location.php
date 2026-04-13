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
    $id_client = $_POST['id_client'];
    $num_chambre = $_POST['num_chambre'];
    $hotel = $_SESSION['id_hotel'];
    $chaine = $_SESSION['id_chaine'];
    $id_employe = $_SESSION['user_id'];
    $date_check_in = $_POST['date_check_in']; 
    $date_check_out = $_POST['date_check_out']; 
    $status = 'active';

    $query = "INSERT INTO location (
        date_check_in, 
        date_check_out, 
        status, 
        num_chambre, 
        id_client, 
        id_hotel, 
        id_chaine,
        id_employe
      ) VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";

    $params = [
        $date_check_in, 
        $date_check_out, 
        $status,
        $num_chambre, 
        $id_client, 
        $hotel, 
        $chaine,
        $id_employe 
    ];
    
    $result = pg_query_params($conn, $query, $params);

    if ($result) {
        header("Location: liste_all_locations.php");
        exit();
    } else {
        echo "Erreur lors de la location : " . pg_last_error($conn);
    }
}
?>


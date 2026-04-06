<?php
$conn = pg_connect("host=localhost dbname=hotel_db user=postgres password=YOURPASS");

$capacite = $_POST['capacite'];
$prix = $_POST['prix'];

$query = "SELECT * FROM Chambre WHERE 1=1";

if ($capacite) {
    $query .= " AND capacite >= $capacite";
}

if ($prix) {
    $query .= " AND prix <= $prix";
}

$result = pg_query($conn, $query);

while ($row = pg_fetch_assoc($result)) {
    echo "Chambre ID: " . $row['id_chambre'] . 
         " | Prix: " . $row['prix'] . 
         " | Capacité: " . $row['capacite'] . "<br>";
}
?>

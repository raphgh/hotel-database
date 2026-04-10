<?php
$host = '127.0.0.1';
$port = "5432";
$dbname = "hotel_db";
$user = 'postgres';
$password = '1234';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Database connection failed.");
}
?>

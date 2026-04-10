<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Succès</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../style.css">
        <style>
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
 
            :root {
                --bg: #F7F5F0;
                --surface: #FFFFFF;
                --border: #E2DDD5;
                --text: #1A1714;
                --muted: #7A7267;
                --accent: #2C5F2E;
                --accent-light: #EBF2EB;
                --radius: 12px;
            }
 
            body {
                font-family: 'DM Sans', sans-serif;
                background: var(--bg);
                color: var(--text);
                font-size: 15px;
                line-height: 1.6;
                min-height: 100vh;
            }
 
            nav {
                background: var(--surface);
                border-bottom: 1px solid var(--border);
                padding: 0 2rem;
                height: 60px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                position: sticky;
                top: 0;
                z-index: 100;
            }
            nav h1 {
                font-family: 'DM Serif Display', serif;
                font-size: 22px;
                font-weight: 400;
                color: var(--accent);
            }
            .nav-links {
                display: flex;
                gap: 10px;
                align-items: center;
            }
            nav a {
                font-size: 13px;
                font-weight: 500;
                color: var(--text);
                text-decoration: none;
                border: 1px solid var(--border);
                padding: 7px 18px;
                border-radius: 99px;
                transition: background 0.15s, border-color 0.15s;
            }
            nav a:hover { background: var(--bg); border-color: #c5bfb5; }
 
            .page-wrapper {
                min-height: calc(100vh - 60px);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem;
            }
 
            .success-card {
                background: var(--surface);
                border: 1px solid var(--border);
                border-radius: var(--radius);
                padding: 3rem 2.5rem;
                width: 100%;
                max-width: 420px;
                text-align: center;
            }
 
            .checkmark {
                width: 52px;
                height: 52px;
                background: var(--accent-light);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1.5rem;
            }
            .checkmark svg {
                width: 24px;
                height: 24px;
                stroke: var(--accent);
                fill: none;
                stroke-width: 2.5;
                stroke-linecap: round;
                stroke-linejoin: round;
            }
 
            .success-card h1 {
                font-family: 'DM Serif Display', serif;
                font-size: 28px;
                font-weight: 400;
                color: var(--text);
                margin-bottom: 0.5rem;
            }
 
            .success-card p {
                font-size: 14px;
                color: var(--muted);
                margin-bottom: 2rem;
            }
 
            .btn-primary {
                display: inline-block;
                height: 44px;
                line-height: 44px;
                padding: 0 24px;
                background: var(--accent);
                color: #fff;
                text-decoration: none;
                border-radius: 8px;
                font-size: 14px;
                font-weight: 500;
                transition: opacity 0.15s;
            }
            .btn-primary:hover { opacity: 0.88; }
        </style>
        <nav>
            <h1>auberge.com</h1>
            <div class="nav-links">
                <a href="index.php">&#127968;</a>
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
 
        <div class="page-wrapper">
            <div class="success-card">
                <div class="checkmark">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <h1>Réservation confirmée!</h1>
                <p>Votre réservation a été effectuée avec succès.</p>
                <a href="liste_reservations.php" class="btn-primary">Voir mes réservations</a>
            </div>
        </div>
 
    </body>
</html>

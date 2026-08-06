<?php

try {
    $pdo = new PDO(
        "pgsql:host=localhost;port=5432;dbname=candiapp",
        "candiapp_user",
        "Surlex74"
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur de connexion PostgreSQL : " . $e->getMessage());
}
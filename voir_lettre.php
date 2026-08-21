<?php

session_start();

if (!isset($_SESSION["id_utilisateur"])) {
    header("Location: Connexion.php");
    exit;
}

require_once __DIR__ . "/database.php";

if (!isset($_GET["id"]) || !ctype_digit($_GET["id"])) {
    http_response_code(400);
    die("Identifiant invalide.");
}

$stmt = $pdo->prepare("
    SELECT nom_lettre_motivation, lettre_entreprise_pdf
    FROM entreprise
    WHERE id_entreprise = :id
      AND utilisateur_id = :utilisateur_id
");

$stmt->execute([
    ":id" => (int) $_GET["id"],
    ":utilisateur_id" => $_SESSION["id_utilisateur"]
]);

$lettre = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$lettre || empty($lettre["lettre_entreprise_pdf"])) {
    http_response_code(404);
    die("Aucune lettre de motivation trouvée.");
}

$nom = $lettre["nom_lettre_motivation"] ?: "lettre_motivation.pdf";
$nom = preg_replace('/[^A-Za-z0-9._-]/', '_', $nom);

header("Content-Type: application/pdf");
header('Content-Disposition: inline; filename="' . $nom . '"');

$pdf = $lettre["lettre_entreprise_pdf"];

if (is_resource($pdf)) {
    fpassthru($pdf);
} else {
    echo $pdf;
}

exit;

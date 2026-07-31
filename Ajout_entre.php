<?php
session_start();

$message = "";

try {
    $pdo = new PDO("sqlite:" . __DIR__ . "/Candiapp.db");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_SESSION["id_utilisateur"])) {
        $message = "Erreur : tu dois être connecté.";
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["id_utilisateur"])) {

        if (
            !empty($_POST["nom"]) &&
            !empty($_POST["contact"]) &&
            !empty($_POST["date"]) &&
            !empty($_POST["statut"]) &&
            !empty($_POST["note"])
        ) {
            $nom = $_POST["nom"];
            $contact = $_POST["contact"];
            $date = $_POST["date"];
            $statut = $_POST["statut"];
            $note = $_POST["note"];

            $id_utilisateur = $_SESSION["id_utilisateur"];

            $sql = "
                INSERT INTO entreprise (
                    nom_entreprise,
                    adresse,
                    date_envoie,
                    statut_candidature,
                    commentaire_candidature,
                    utilisateur_id
                )
                VALUES (
                    :nom,
                    :contact,
                    :date,
                    :statut,
                    :note,
                    :utilisateur_id
                )
            ";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ":nom" => $nom,
                ":contact" => $contact,
                ":date" => $date,
                ":statut" => $statut,
                ":note" => $note,
                ":utilisateur_id" => $id_utilisateur
            ]);

            $message = "Entreprise ajoutée avec succès !";

        } else {
            $message = "Erreur : formulaire incomplet.";
        }
    }

} catch (PDOException $e) {
    $message = "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une entreprise</title>
</head>

<style>
    .form-container{
        display: flex;
        flex-direction: column;
        gap: 20px;
        align-items: center;
        margin-top: 220px;
    }

    h1{
        text-align: center;
    }

    input {
        padding: 16px;
        border: 1px solid gray;
        border-radius: 10px;
        font-size: 16px;
        width: 300px;
    }

    .message {
        text-align: center;
        margin-top: 20px;
        font-weight: bold;
    }
</style>

<body>

    <form method="post" class="form-container">
        <h1>Ajouter une entreprise</h1>

        <input type="text" name="nom" placeholder="Nom de l'entreprise">
        <input type="text" name="contact" placeholder="Contact">
        <input type="date" name="date">
        <input type="text" name="statut" placeholder="Statut de la candidature">
        <input type="text" name="note" placeholder="Note de la candidature">

        <input type="submit" value="Ajouter une entreprise">

        <a href="Acceuil.php">Retour à l'accueil</a>
    </form>

    <?php if (!empty($message)) : ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

</body>
</html>
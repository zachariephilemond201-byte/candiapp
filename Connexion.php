<?php
session_start();

require_once __DIR__ . "/database.php";

if (isset($_POST["utilisateur"]) && isset($_POST["mot_de_passe"])) {

    $nom_utilisateur = $_POST["utilisateur"];
    $mot_de_passe = $_POST["mot_de_passe"];

    $sql = "SELECT * FROM utilisateur WHERE nom_utilisateur = :nom_utilisateur";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":nom_utilisateur" => $nom_utilisateur
    ]);

    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($utilisateur && $mot_de_passe == $utilisateur["motdepasse"]) {

        $_SESSION["id_utilisateur"] = $utilisateur["id_utilisateur"];
        $_SESSION["nom_utilisateur"] = $utilisateur["nom_utilisateur"];

        header("Location: ./acceuil.php");
        exit();

    } else {
        $erreur = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

<form action="" method="POST" class="cont">
    <input type="text" name="utilisateur" placeholder="Nom d'utilisateur">
    <input type="password" name="mot_de_passe" placeholder="Mot de passe">
    <input type="submit" value="entrer">

    <a href="inscription.php" class="btn">Créer un profil</a>
</form>

<?php
if (isset($erreur)) {
    echo $erreur;
}
?>

</body>
</html>
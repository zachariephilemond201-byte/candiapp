<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
    input{
    padding: 16px;
  border: 1px solid gray;
  border-radius: 10px;
  font-size: 16px;
  width: 300px;
    }
    .cont{
        display: flex;
        flex-direction: column;
        gap: 20px;
        align-items: center;
        margin-top: 220px;
    }

    .btn{
        display: inline-block;
    padding: 10px 20px;
    background-color: grey;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;

    }

</style>



<body>
    <form action="" method="POST" class="cont">
    <input type="text" name ="utilisateur" placeholder="Nom d'utilisateur">
    <input type="password" name="mot_de_passe" placeholder="Mot de passe">
    <input type="submit" value="entrer">

    <a href="inscription.php" class="btn">Créer un profil</a>
    </form>

   <?php
session_start();

$pdo = new PDO("sqlite:" . __DIR__ . "/Candiapp.db");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

</body>
</html>
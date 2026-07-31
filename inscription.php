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
</style>
<body>
    <form action="" method="POST" class="cont">
    <input type="text" name ="utilisateur" placeholder="Nom d'utilisateur">
    <input type="password" name="mot_de_passe" placeholder="Mot de passe">
    <input type="submit" value="Créer un profil">
    </form>

    <?php
    $pdo = new PDO("sqlite:Candiapp.db");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_POST["utilisateur"]) && isset($_POST["mot_de_passe"])){
        $utilisateur = $_POST["utilisateur"];
        $mot_de_passe = $_POST["mot_de_passe"];

        $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);


        $sql = "INSERT INTO utilisateur(nom_utilisateur, motdepasse) VALUES (:nom_utilisateur, :motdepasse)";

        

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom_utilisateur' => $utilisateur,
            ':motdepasse' => $mot_de_passe
        ]);

        echo "Utilisateur créé avec succès!";
        echo ".<a href='connexion.php'style='text-center'>Se connecter</a>.";
    }
    
    
    
    ?>
</body>
</html>
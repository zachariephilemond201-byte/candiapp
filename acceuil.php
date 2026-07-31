<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

    <style>
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

    h1{
         text-align: center;
    }



    </style>


<body>
    <h1>Bienvenue sur notre application, <?php session_start(); echo $_SESSION['nom_utilisateur']; ?></h1>
    <div class="cont" method="post">
        <a href="Ajout_entre.php" class="btn">Ajouter une entreprise</a>
        <a href="liste_entre.php" class="btn">Voir vos entreprises</a>
        <form method="post" style="display: inline;">
            <input type="submit" class="btn" name="deconnexion" value="Se déconnecter">
        </form>
    </div>

    <?php
    if(isset($_POST["deconnexion"])) {
        session_destroy();
        header("Location: ./Connexion.php");
        exit();
    }
    ?>
</body>
</html>
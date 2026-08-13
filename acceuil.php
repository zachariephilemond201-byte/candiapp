<?php
session_start();

if (!isset($_SESSION["id_utilisateur"])) {
    header("Location: ./Connexion.php");
    exit();
}

if (isset($_POST["deconnexion"])) {
    session_unset();
    session_destroy();

    header("Location: ./Connexion.php");
    exit();
}
?>


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
</body>
</html>
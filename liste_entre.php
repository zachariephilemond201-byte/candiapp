<?php

session_start();

if (!isset($_SESSION["id_utilisateur"])) {
    header("Location: connexion.php");
    exit();
}

try {
    $pdo = new PDO(
        "sqlite:" . __DIR__ . "/Candiapp.db"
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

   
    $sql = "
        SELECT *
        FROM entreprise
        WHERE utilisateur_id = :utilisateur_id
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":utilisateur_id" => $_SESSION["id_utilisateur"]
    ]);

    
    $entreprises = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Liste des entreprises</title>

    <style>
        h1 {
            text-align: center;
        }

        .conteneur {
            width: 350px;
            margin: 30px auto;
        }

        .entreprise {
            border: 1px solid black;
            margin-bottom: 20px;
            padding: 10px;
        }

        .entreprise h2 {
            margin-top: 0;
            padding: 8px;
            background-color: #ddd;
        }

        .ligne {
            margin-bottom: 8px;
        }

        .titre {
            font-weight: bold;
        }

        .message {
            text-align: center;
        }

    a{
        display: flex;
        flex-direction: column;
        gap: 20px;
        align-items: center;
        margin-top: 220px;
    }

    </style>
</head>

<body>

<h1>Liste des entreprises</h1>

<a type="button" href="acceuil.php">Retour à l'accueil</a>

<div class="conteneur">

    <?php if (count($entreprises) === 0) : ?>

        <p class="message">
            Vous n'avez encore ajouté aucune entreprise.
        </p>

    <?php else : ?>

        <?php foreach ($entreprises as $entreprise) : ?>

            <div class="entreprise">

                <h2>
                    <?= htmlspecialchars(
                        $entreprise["nom_entreprise"]
                    ) ?>
                </h2>

                <div class="ligne">
                    <span class="titre">Adresse :</span>

                    <?= htmlspecialchars(
                        $entreprise["adresse"]
                    ) ?>
                </div>

                <div class="ligne">
                    <span class="titre">Date :</span>

                    <?= htmlspecialchars(
                        $entreprise["date_envoie"]
                    ) ?>
                </div>

                <div class="ligne">
                    <span class="titre">Statut :</span>

                    <?= htmlspecialchars(
                        $entreprise["statut_candidature"]
                    ) ?>
                </div>

                <div class="ligne">
                    <span class="titre">Commentaire :</span>

                    <?= htmlspecialchars(
                        $entreprise["commentaire_candidature"]
                    ) ?>
                </div>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

    <?php if (!empty($entreprise['lettre_motivation_pdf'])): ?>

    <a
        href="<?= htmlspecialchars(
            $entreprise['lettre_motivation_pdf']
        ) ?>"
        target="_blank"
    >
        Voir la lettre de motivation
    </a>

<?php else: ?>

    <span>Aucune lettre de motivation</span>

<?php endif; ?>

</div>

</body>
</html>
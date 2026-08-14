<?php

session_start();

$message = "";

try {
require_once __DIR__ . "/database.php";

    if (!isset($_SESSION["id_utilisateur"])) {
        $message = "Erreur : tu dois être connecté.";
    }

    if (
        $_SERVER["REQUEST_METHOD"] === "POST" &&
        isset($_SESSION["id_utilisateur"])
    ) {
        if (
            !empty($_POST["nom"]) &&
            !empty($_POST["contact"]) &&
            !empty($_POST["date"]) &&
            !empty($_POST["statut"]) &&
            !empty($_POST["note"])
        ) {
            $nom = trim($_POST["nom"]);
            $contact = trim($_POST["contact"]);
            $date = $_POST["date"];
            $statut = trim($_POST["statut"]);
            $note = trim($_POST["note"]);

            $id_utilisateur = $_SESSION["id_utilisateur"];

            
            if (
                !isset($_FILES["lettre_motivation"]) ||
                $_FILES["lettre_motivation"]["error"] !== UPLOAD_ERR_OK
            ) {
                throw new Exception(
                    "Tu dois sélectionner une lettre de motivation au format PDF."
                );
            }

            $fichier = $_FILES["lettre_motivation"];

            
            $tailleMaximale = 5 * 1024 * 1024;

            if ($fichier["size"] > $tailleMaximale) {
                throw new Exception(
                    "Le fichier PDF ne doit pas dépasser 5 Mo."
                );
            }

            
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $typeMime = $finfo->file($fichier["tmp_name"]);

            if ($typeMime !== "application/pdf") {
                throw new Exception(
                    "Le fichier sélectionné doit être un véritable PDF."
                );
            }

        
            $nomPdf = basename($fichier["name"]);

            
            $contenuPdf = file_get_contents($fichier["tmp_name"]);

            if ($contenuPdf === false) {
                throw new Exception(
                    "Impossible de lire le fichier PDF."
                );
            }

            $sql = "
                INSERT INTO entreprise (
                    nom_entreprise,
                    adresse,
                    date_envoi,
                    statut_canditature,
                    commentaire_candidature,
                    nom_lettre_motivation,
                    lettre_entreprise_pdf,
                    utilisateur_id
                )
                VALUES (
                    :nom,
                    :contact,
                    :date,
                    :statut,
                    :note,
                    :nom_pdf,
                    :contenu_pdf,
                    :utilisateur_id
                )
            ";

            $stmt = $pdo->prepare($sql);

            $stmt->bindValue(
                ":nom",
                $nom,
                PDO::PARAM_STR
            );

            $stmt->bindValue(
                ":contact",
                $contact,
                PDO::PARAM_STR
            );

            $stmt->bindValue(
                ":date",
                $date,
                PDO::PARAM_STR
            );

            $stmt->bindValue(
                ":statut",
                $statut,
                PDO::PARAM_STR
            );

            $stmt->bindValue(
                ":note",
                $note,
                PDO::PARAM_STR
            );

            $stmt->bindValue(
                ":nom_pdf",
                $nomPdf,
                PDO::PARAM_STR
            );

           
            $stmt->bindValue(
                ":contenu_pdf",
                $contenuPdf,
                PDO::PARAM_LOB
            );

            $stmt->bindValue(
                ":utilisateur_id",
                $id_utilisateur,
                PDO::PARAM_INT
            );

            $stmt->execute();

            $message = "Entreprise et lettre de motivation ajoutées avec succès !";

        } else {
            $message = "Erreur : formulaire incomplet.";
        }
    }

} catch (PDOException $e) {
    $message = "Erreur de base de données : " . $e->getMessage();

} catch (Exception $e) {
    $message = "Erreur : " . $e->getMessage();
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

    <title>Ajouter une entreprise</title>

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: center;
            margin-top: 100px;
        }

        h1 {
            text-align: center;
        }

        input {
            padding: 16px;
            border: 1px solid gray;
            border-radius: 10px;
            font-size: 16px;
            width: 300px;
            box-sizing: border-box;
        }

        .zone-depot {
            width: 300px;
            min-height: 130px;
            padding: 20px;
            border: 2px dashed gray;
            border-radius: 10px;
            box-sizing: border-box;
            text-align: center;
            cursor: pointer;
            background-color: #f5f5f5;
            transition: 0.2s;
        }

        .zone-depot:hover,
        .zone-depot.survol {
            background-color: #e5e5e5;
            border-color: black;
        }

        .zone-depot p {
            margin: 8px 0;
        }

        #nomFichier {
            font-weight: bold;
            overflow-wrap: anywhere;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    
    <form
        method="post"
        enctype="multipart/form-data"
        class="form-container"
    >
        <h1>Ajouter une entreprise</h1>

        <input
            type="text"
            name="nom"
            placeholder="Nom de l'entreprise"
            required
        >

        <input
            type="text"
            name="contact"
            placeholder="Contact"
            required
        >

        <input
            type="date"
            name="date"
            required
        >

        <input
            type="text"
            name="statut"
            placeholder="Statut de la candidature"
            required
        >

        <input
            type="text"
            name="note"
            placeholder="Note de la candidature"
            required
        >

        <div
            class="zone-depot"
            id="zoneDepot"
            tabindex="0"
        >
            <p>Glisse ta lettre de motivation ici</p>
            <p>ou clique pour choisir un PDF</p>

            <input
                type="file"
                id="lettreMotivation"
                name="lettre_motivation"
                accept="application/pdf,.pdf"
                hidden
                required
            >

            <p id="nomFichier">
                Aucun fichier sélectionné
            </p>
        </div>

        <input
            type="submit"
            value="Ajouter une entreprise"
        >

        <a href="acceuil.php">
            Retour à l'accueil
        </a>
    </form>

    <?php if (!empty($message)) : ?>

        <p class="message">
            <?= htmlspecialchars(
                $message,
                ENT_QUOTES,
                "UTF-8"
            ) ?>
        </p>

    <?php endif; ?>

    <script>
        const zoneDepot = document.getElementById("zoneDepot");

        const inputFichier = document.getElementById(
            "lettreMotivation"
        );

        const nomFichier = document.getElementById(
            "nomFichier"
        );

        
        zoneDepot.addEventListener("click", function () {
            inputFichier.click();
        });

        
        zoneDepot.addEventListener("keydown", function (event) {
            if (
                event.key === "Enter" ||
                event.key === " "
            ) {
                event.preventDefault();
                inputFichier.click();
            }
        });

        zoneDepot.addEventListener("dragover", function (event) {
            event.preventDefault();
            zoneDepot.classList.add("survol");
        });

        zoneDepot.addEventListener("dragleave", function () {
            zoneDepot.classList.remove("survol");
        });

        zoneDepot.addEventListener("drop", function (event) {
            event.preventDefault();

            zoneDepot.classList.remove("survol");

            const fichiers = event.dataTransfer.files;

            if (fichiers.length === 0) {
                return;
            }

            const fichier = fichiers[0];

            
            if (
                fichier.type !== "application/pdf" &&
                !fichier.name.toLowerCase().endsWith(".pdf")
            ) {
                alert("Tu dois sélectionner un fichier PDF.");
                return;
            }

            
            const transfert = new DataTransfer();
            transfert.items.add(fichier);

            inputFichier.files = transfert.files;

            afficherNomFichier(fichier);
        });

        inputFichier.addEventListener("change", function () {
            if (inputFichier.files.length > 0) {
                afficherNomFichier(
                    inputFichier.files[0]
                );
            }
        });

        function afficherNomFichier(fichier) {
            const tailleMo = (
                fichier.size /
                1024 /
                1024
            ).toFixed(2);

            nomFichier.textContent =
                fichier.name + " — " + tailleMo + " Mo";
        }
    </script>

</body>
</html>
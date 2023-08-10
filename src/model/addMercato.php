<?php
if (isset($_POST['submit'])) {
    // Fonction pour valider, échapper et décoder les entités HTML des données
    function validateEscapeAndDecode($data) {
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = html_entity_decode($data); // Ajout de html_entity_decode
        // Vous pouvez ajouter d'autres validations spécifiques ici si nécessaire
        return $data;
    }
    // Récupération des images
    $image_entete = $_FILES['image_entete']['name'];

    // Emplacement temporaire des images
    $tmp_image_entete = $_FILES['image_entete']['tmp_name'];

    // Générer un nom de fichier aléatoire
    function generateRandomFileName($originalName) {
        $randomString = uniqid();
        $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
        return $randomString . '.' . $fileExtension;
    }

    $random_image_entete = generateRandomFileName($image_entete);

    // Déplacer l'image vers le dossier "upload" avec le nom aléatoire
    move_uploaded_file($tmp_image_entete, "assets/upload/" . $random_image_entete);

    $servername = "localhost";
    $username = "jerem";
    $password = "jerem";
    $dbname = "gamerush";

    $connect = new mysqli($servername, $username, $password, $dbname);

    if ($connect->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Valider et échapper les données avant insertion
    $titre = validateEscapeAndDecode($_POST['titre']);
    $titre1 = validateEscapeAndDecode($_POST['titre1']);
    $text1 = validateEscapeAndDecode($_POST['text1']);
    $tweet1 = validateEscapeAndDecode($_POST['tweet1']);
    $text2 = validateEscapeAndDecode($_POST['text2']);
    $tweet2 = validateEscapeAndDecode($_POST['tweet2']);
    $text3 = validateEscapeAndDecode($_POST['text3']);
    $titre2 = validateEscapeAndDecode($_POST['titre2']);
    $text4 = validateEscapeAndDecode($_POST['text4']);
    $tweet3 = validateEscapeAndDecode($_POST['tweet3']);
    $conclusion = validateEscapeAndDecode($_POST['conclusion']);
    $description = validateEscapeAndDecode($_POST['description']);
    $date_mercato = validateEscapeAndDecode($_POST['date_mercato']);
    $category = validateEscapeAndDecode($_POST['category']);
    
    // Utilisation de requêtes préparées pour sécuriser les données
    $sql = "INSERT INTO mercato (image_entete, titre, titre1, text1, tweet1, text2, tweet2, text3, titre2, text4, tweet3, conclusion, description, date_mercato, id_category) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connect->prepare($sql);

    if ($stmt) {
        // Assurez-vous de lier les valeurs correctement avec le type de données attendu dans la base de données
        $stmt->bind_param("sssssssssssssss", $random_image_entete, $titre, $titre1, $text1, $tweet1, $text2, $tweet2, $text3, $titre2, $text4, $tweet3, $conclusion, $description, $date_mercato, $category);
    
        // Exécutez la requête
        if ($stmt->execute()) {
            // La requête a été exécutée avec succès, vous pouvez afficher un message ou rediriger l'utilisateur vers une autre page si nécessaire.
            sleep(2);
            header("Location: index.php?admin=ajoutMercato");
        } else {
            // Si la requête échoue, vous pouvez afficher un message d'erreur ou faire un traitement supplémentaire.
            echo "Erreur lors de l'enregistrement des données : " . $stmt->error;
        }

        // Fermez la connexion à la base de données après avoir terminé les opérations.
        $stmt->close();
    } else {
        echo "Erreur de préparation de la requête : " . $connect->error;
    }

    $connect->close();
}

?>

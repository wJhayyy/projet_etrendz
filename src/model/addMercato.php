<?php 

if (isset($_POST['submit'])) {
    // Récupération des images
    $image_entete = $_FILES['image_entete']['name'];


    // Emplacement temporaire des images
    $tmp_image_entete = $_FILES['image_entete']['tmp_name'];


    // Déplacer les images vers le dossier "upload"
    move_uploaded_file($tmp_image_entete, "assets/upload/" . $image_entete);

    $servername = "localhost";
    $username = "jerem";
    $password = "jerem";
    $dbname = "gamerush";

    $connect = new mysqli($servername, $username, $password, $dbname);

    if ($connect->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $titre = $_POST['titre'];
    $titre1 = $_POST['titre1'];
    $text1 = $_POST['text1'];
    $tweet1 = $_POST['tweet1'];
    $text2 = $_POST['text2'];
    $tweet2 = $_POST['tweet2'];
    $text3 = $_POST['text3'];
    $titre2 = $_POST['titre2'];
    $text4 = $_POST['text4'];
    $tweet3 = $_POST['tweet3'];
    $conclusion = $_POST['conclusion'];
    $description = $_POST['description'];
    $date_mercato = $_POST['date_mercato'];
    $category = $_POST['category'];
    
    // Utilisation de requêtes préparées pour sécuriser les données
    $sql = "INSERT INTO mercato (image_entete, titre, titre1, text1, tweet1, text2, tweet2, text3, titre2, text4, tweet3, conclusion, description, date_mercato, id_category) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connect->prepare($sql);
    
    // Assurez-vous de lier les valeurs correctement avec le type de données attendu dans la base de données
    $stmt->bind_param("sssssssssssssss", $image_entete, $titre, $titre1, $text1, $tweet1, $text2, $tweet2, $text3, $titre2, $text4, $tweet3, $conclusion, $description, $date_mercato, $category);
    
    // Exécutez la requête
    if ($stmt->execute()) {
        // La requête a été exécutée avec succès, vous pouvez afficher un message ou rediriger l'utilisateur vers une autre page si nécessaire.
        echo "Les données ont été enregistrées avec succès.";
    } else {
        // Si la requête échoue, vous pouvez afficher un message d'erreur ou faire un traitement supplémentaire.
        echo "Erreur lors de l'enregistrement des données : " . $connect->error;
    }

    // Fermez la connexion à la base de données après avoir terminé les opérations.
    $stmt->close();
    $connect->close();
}

?>
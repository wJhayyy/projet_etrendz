<?php 

if (isset($_POST['submit'])) {
    // Récupération des images
    $image_entete = $_FILES['image_entete']['name'];
    $image1 = $_FILES['image1']['name'];
    $image2 = $_FILES['image2']['name'];
    $imagegain = $_FILES['imagegain']['name'];

    var_dump($image_entete, $image1, $image2, $imagegain);

    // Emplacement temporaire des images
    $tmp_image_entete = $_FILES['image_entete']['tmp_name'];
    $tmp_image1 = $_FILES['image1']['tmp_name'];
    $tmp_image2 = $_FILES['image2']['tmp_name'];
    $tmp_imagegain = $_FILES['imagegain']['tmp_name'];

        // Vérifier la taille des images (limite de 10 Mo)
        $maxFileSize = 10 * 1024 * 1024; // 10 Mo en octets
        if ($_FILES['image_entete']['size'] > $maxFileSize || $_FILES['image1']['size'] > $maxFileSize || $_FILES['image2']['size'] > $maxFileSize || $_FILES['imagegain']['size'] > $maxFileSize) {
            echo "La taille d'une ou plusieurs images dépasse la limite autorisée (10 Mo).";
            exit;
        }

    var_dump($tmp_image_entete, $tmp_image1, $tmp_image2, $tmp_imagegain);

    // Déplacer les images vers le dossier "upload"
    move_uploaded_file($tmp_image_entete, "assets/upload/" . $image_entete);
    move_uploaded_file($tmp_image1, "assets/upload/" . $image1);
    move_uploaded_file($tmp_image2, "assets/upload/" . $image2);
    move_uploaded_file($tmp_imagegain, "assets/upload/" . $imagegain);

    $servername = "localhost";
    $username = "jerem";
    $password = "jerem";
    $dbname = "gamerush";

    $connect = new mysqli($servername, $username, $password, $dbname);

    if ($connect->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $titre_actualite = $_POST['titre_actualite'];
    $introduction = $_POST['introduction'];
    $video = $_POST['video'];
    $text1 = $_POST['text1'];
    $text2 = $_POST['text2'];
    $titre2 = $_POST['titre2'];
    $introduction2 = $_POST['introduction2'];
    $text3 = $_POST['text3'];
    $conclusion = $_POST['conclusion'];
    $description = $_POST['description'];
    $date_actualite = $_POST['date'];
    $category = $_POST['category'];
    
    // Utilisation de requêtes préparées pour sécuriser les données
    $sql = "INSERT INTO actualite (image_entete, image1, image2, imagegain, titre_actualite, introduction, video, text1, text2, titre2, introduction2, text3, conclusion, description, date_actualite, id_category) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connect->prepare($sql);
    
    // Assurez-vous de lier les valeurs correctement avec le type de données attendu dans la base de données
    $stmt->bind_param("ssssssssssssssss", $image_entete, $image1, $image2, $imagegain, $titre_actualite, $introduction, $video, $text1, $text2, $titre2, $introduction2, $text3, $conclusion, $description, $date_actualite, $category);
    
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
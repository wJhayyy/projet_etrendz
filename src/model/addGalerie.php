<?php 

if (isset($_POST['submit'])) {
    // Récupération des images
    $img_photo = $_FILES['img_photo']['name'];


    // Emplacement temporaire des images
    $tmp_img_photo = $_FILES['img_photo']['tmp_name'];


    // Déplacer les images vers le dossier "upload"
    move_uploaded_file($tmp_img_photo, "assets/upload/" . $img_photo);

    $servername = "localhost";
    $username = "jerem";
    $password = "jerem";
    $dbname = "gamerush";

    $connect = new mysqli($servername, $username, $password, $dbname);

    if ($connect->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $nom_photo = $_POST['nom_photo'];
    $mot_clé = $_POST['mot_clé'];
    
    // Utilisation de requêtes préparées pour sécuriser les données
    $sql = "INSERT INTO galerie (img_photo, nom_photo, mot_clé) VALUES (?, ?, ?)";
    $stmt = $connect->prepare($sql);
    
    // Assurez-vous de lier les valeurs correctement avec le type de données attendu dans la base de données
    $stmt->bind_param("sss", $img_photo, $nom_photo, $mot_clé);
    
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
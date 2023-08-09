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
    $img_photo = $_FILES['img_photo']['name'];
    $tmp_img_photo = $_FILES['img_photo']['tmp_name'];
    
    // Génération d'un nom de fichier aléatoire
    $random_string = uniqid(); // Génère un identifiant unique basé sur l'heure actuelle
    $file_extension = pathinfo($img_photo, PATHINFO_EXTENSION); // Obtenir l'extension du fichier
    $random_filename = $random_string . '.' . $file_extension;
    
    // Déplacer l'image vers le dossier "upload" avec le nom aléatoire
    move_uploaded_file($tmp_img_photo, "assets/upload/" . $random_filename);
    
    $servername = "localhost";
    $username = "jerem";
    $password = "jerem";
    $dbname = "gamerush";

    $connect = new mysqli($servername, $username, $password, $dbname);

    if ($connect->connect_error) {
        die("La connexion à la base de données a échoué : " . $connect->connect_error);
    }

    // Valider et échapper les données avant insertion
    $nom_photo = validateEscapeAndDecode($_POST['nom_photo']);
    $mot_clé = validateEscapeAndDecode
    
    ($_POST['mot_clé']);
    
    // Utilisation de requêtes préparées pour sécuriser les données
    $sql = "INSERT INTO galerie (img_photo, nom_photo, mot_clé) VALUES (?, ?, ?)";
    $stmt = $connect->prepare($sql);

    if ($stmt) {
        // Assurez-vous de lier les valeurs correctement avec le type de données attendu dans la base de données
        $stmt->bind_param("sss", $random_filename, $nom_photo, $mot_clé);
    
        // Exécutez la requête
        if ($stmt->execute()) {
            // La requête a été exécutée avec succès, vous pouvez afficher un message ou rediriger l'utilisateur vers une autre page si nécessaire.
            echo "Les données ont été enregistrées avec succès.";
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

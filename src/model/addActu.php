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
    
    // Vérifier que les images ont été téléchargées avec succès
    if (
        isset($_FILES['image_entete'], $_FILES['image1'], $_FILES['image2'], $_FILES['imagegain']) &&
        $_FILES['image_entete']['error'] === UPLOAD_ERR_OK &&
        $_FILES['image1']['error'] === UPLOAD_ERR_OK &&
        $_FILES['image2']['error'] === UPLOAD_ERR_OK &&
        $_FILES['imagegain']['error'] === UPLOAD_ERR_OK
    ) {
        // Récupération des images
        $image_entete = $_FILES['image_entete']['name'];
        $image1 = $_FILES['image1']['name'];
        $image2 = $_FILES['image2']['name'];
        $imagegain = $_FILES['imagegain']['name'];

        // Emplacement temporaire des images
        $tmp_image_entete = $_FILES['image_entete']['tmp_name'];
        $tmp_image1 = $_FILES['image1']['tmp_name'];
        $tmp_image2 = $_FILES['image2']['tmp_name'];
        $tmp_imagegain = $_FILES['imagegain']['tmp_name'];

        // Générer des noms de fichiers aléatoires
        function generateRandomFileName($originalName) {
            $randomString = uniqid();
            $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
            return $randomString . '.' . $fileExtension;
        }

        $random_image_entete = generateRandomFileName($image_entete);
        $random_image1 = generateRandomFileName($image1);
        $random_image2 = generateRandomFileName($image2);
        $random_imagegain = generateRandomFileName($imagegain);

        // Vérifier les types de fichiers autorisés
        $allowedExtensions = array('jpg', 'jpeg', 'png');
        if (
            in_array(strtolower(pathinfo($random_image_entete, PATHINFO_EXTENSION)), $allowedExtensions) &&
            in_array(strtolower(pathinfo($random_image1, PATHINFO_EXTENSION)), $allowedExtensions) &&
            in_array(strtolower(pathinfo($random_image2, PATHINFO_EXTENSION)), $allowedExtensions) &&
            in_array(strtolower(pathinfo($random_imagegain, PATHINFO_EXTENSION)), $allowedExtensions)
        ) {
            // Déplacer les images vers le dossier "upload" avec les noms aléatoires
            move_uploaded_file($tmp_image_entete, "assets/upload/" . $random_image_entete);
            move_uploaded_file($tmp_image1, "assets/upload/" . $random_image1);
            move_uploaded_file($tmp_image2, "assets/upload/" . $random_image2);
            move_uploaded_file($tmp_imagegain, "assets/upload/" . $random_imagegain);

            $servername = "localhost";
            $username = "jerem";
            $password = "jerem";
            $dbname = "gamerush";

            $connect = new mysqli($servername, $username, $password, $dbname);

            if ($connect->connect_error) {
                die("La connexion à la base de données a échoué : " . $connect->connect_error);
            }

            // Valider et échapper les données avant insertion
            $titre_actualite = validateEscapeAndDecode($_POST['titre_actualite']);
            $introduction = validateEscapeAndDecode($_POST['introduction']);
            $video = validateEscapeAndDecode($_POST['video']);
            $text1 = validateEscapeAndDecode($_POST['text1']);
            $text2 = validateEscapeAndDecode($_POST['text2']);
            $titre2 = validateEscapeAndDecode($_POST['titre2']);
            $introduction2 = validateEscapeAndDecode($_POST['introduction2']);
            $text3 = validateEscapeAndDecode($_POST['text3']);
            $conclusion = validateEscapeAndDecode($_POST['conclusion']);
            $description = validateEscapeAndDecode($_POST['description']);
            $date_actualite = validateEscapeAndDecode($_POST['date']);
            $category = validateEscapeAndDecode($_POST['category']);

            // Utilisation de requêtes préparées pour sécuriser les données
            $sql = "INSERT INTO actualite (image_entete, image1, image2, imagegain, titre_actualite, introduction, video, text1, text2, titre2, introduction2, text3, conclusion, description, date_actualite, id_category) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connect->prepare($sql);

            if ($stmt) {
                // Assurez-vous de lier les valeurs correctement avec le type de données attendu dans la base de données
                $stmt->bind_param("ssssssssssssssss", $random_image_entete, $random_image1, $random_image2, $random_imagegain, $titre_actualite, $introduction, $video, $text1, $text2, $titre2, $introduction2, $text3, $conclusion, $description, $date_actualite, $category);

                // Exécutez la requête
                if ($stmt->execute()) {
                    // La requête a été exécutée avec succès, vous pouvez afficher un message ou rediriger l'utilisateur vers une autre page si nécessaire.
                    header("Location: index.php?admin=ajoutActu");
                    exit();
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
        } else {
            echo "Les types de fichiers téléchargés ne sont pas autorisés.";
        }
    } else {
        echo "Une erreur est survenue lors du téléchargement des images.";
    }
}

?>

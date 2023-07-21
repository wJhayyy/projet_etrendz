<!DOCTYPE html>
<html>
<head>
    <title>Formulaire d'upload d'image</title>
</head>
<body>
    <?php
    // Configuration de la base de données
    $servername = "localhost";
    $username = "jerem";
    $password = "jerem";
    $dbname = "gamerush";

    try {
        // Connexion à la base de données via PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
            // Récupération du nom temporaire et du nom original de l'image
            $tmp_name = $_FILES['image_upload']['tmp_name'];
            $image_name = $_FILES['image_upload']['name'];

            // Vérifier si le fichier est une image (extension autorisée)
            $allowed_extensions = array('jpg', 'jpeg', 'png');
            $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

            if (in_array($file_extension, $allowed_extensions)) {
                // Déplacement du fichier téléversé vers le dossier "upload"
                $target_dir = "assets/upload/";
                $target_file = $target_dir . basename($image_name);

                if (move_uploaded_file($tmp_name, $target_file)) {
                    // Si le téléversement a réussi, récupérer les valeurs des champs supplémentaires
                    $titre = $_POST['titre'];
                    $entete = $_POST['entete'];
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
                    $date = date("Y-m-d"); // Format: 'YYYY-MM-DD'

                    // Préparer la requête d'insertion avec des paramètres
                    $stmt = $conn->prepare("INSERT INTO mercato (image_entete, titre, entete, titre1, text1, tweet1, text2, tweet2, text3, titre2, text4, tweet3, conclusion, description, date_mercato) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$image_name, $titre, $entete, $titre1, $text1, $tweet1, $text2, $tweet2, $text3, $titre2, $text4, $tweet3, $conclusion, $description, $date]);
                
                    
                    echo "L'image a été téléversée avec succès et les informations ont été enregistrées dans la base de données.";
                } else {
                    echo "Une erreur s'est produite lors du téléversement de l'image.";
                }
            } else {
                echo "Le fichier téléversé n'est pas une image valide (extensions autorisées : jpg, jpeg, png).";
            }
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
    ?>
    <h2>Formulaire d'upload d'image</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="image_upload">Choisir une image :</label>
        <input type="file" name="image_upload" id="image_upload" accept=".jpg, .jpeg, .png" required>
        <br>
        
        <label for="titre">Titre :</label>
        <input type="text" name="titre" id="titre" required>
        <br>

        <label for="entete">Entête :</label>
        <input type="text" name="entete" id="entete" required>
        <br>

        <label for="titre1">Titre 1 :</label>
        <input type="text" name="titre1" id="titre1" required>
        <br>

        <label for="text1">Texte 1 :</label>
        <input type="text" name="text1" id="text1" required>
        <br>

        <label for="tweet1">Tweet 1 :</label>
        <input type="text" name="tweet1" id="tweet1" required>
        <br>

        <label for="tweet1">Text 2 :</label>
        <input type="text" name="text2" id="text2" required>
        <br>

        <label for="tweet1">Tweet 1 :</label>
        <input type="text" name="tweet1" id="tweet1" required>
        <br>

        <label for="tweet1">Tweet 2 :</label>
        <input type="text" name="tweet2" id="tweet2" required>
        <br>

        <label for="tweet1">Text 3 :</label>
        <input type="text" name="text3" id="text3" required>
        <br>

        <label for="tweet1">Titre 2 :</label>
        <input type="text" name="titre2" id="titre2" required>
        <br>

        <label for="tweet1">Text 4 :</label>
        <input type="text" name="text4" id="text4" required>
        <br>

        <label for="tweet1">Tweet 3 :</label>
        <input type="text" name="tweet3" id="tweet3" required>
        <br>

        <label for="tweet1">Conclusion :</label>
        <input type="text" name="conclusion" id="conclusion" required>
        <br>

        <label for="tweet1">Description :</label>
        <input type="text" name="description" id="description" required>
        <br>

        <label for="tweet1">Date :</label>
        <input type="date" name="date_mercato" id="date_mercato" required>
        <br>


        <!-- Ajoutez ici les autres champs nécessaires selon le même modèle -->
        
        <input type="submit" value="Téléverser l'image">
    </form>
</body>
</html>

<?php

include_once('connectBdd.php');

function checkEmailDomain($email, $allowedDomains) {
    // Récupérer le domaine de l'adresse e-mail
    $domain = substr(strrchr($email, "@"), 1);

    // Vérifier si le domaine fait partie des domaines autorisés
    return in_array($domain, $allowedDomains);
}

// Fonction pour valider, échapper et décoder les entités HTML des données
    function validateEscapeAndDecode($data) {
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = html_entity_decode($data); // Ajout de html_entity_decode
        // Vous pouvez ajouter d'autres validations spécifiques ici si nécessaire
        return $data;
    }

// Liste des domaines autorisés
$allowedDomains = array("gmail.com", "laposte.com", "example.com"); // Ajoutez d'autres domaines si nécessaire

if (isset($_POST['submit'])) {
    // Vérifier si un fichier a été téléchargé

    if (isset($_FILES['img_profil']) && $_FILES['img_profil']['error'] === UPLOAD_ERR_OK) {
        $allowedExtensions = array("jpg", "jpeg", "png", "gif"); // Liste des extensions autorisées
    
        $img_profil = $_FILES['img_profil']['name'];
        $tmp_img_profil = $_FILES['img_profil']['tmp_name'];
        $fileExtension = strtolower(pathinfo($img_profil, PATHINFO_EXTENSION));
    
        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "Type de fichier non autorisé. Seules les images JPG, JPEG, PNG et GIF sont autorisées.";
            exit;
        }

        // Générer un nom de fichier aléatoire
        function generateRandomFileName($originalName) {
            $randomString = uniqid();
            $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
            return $randomString . '.' . $fileExtension;
        }

        $random_img_profil = generateRandomFileName($img_profil);

        // Déplacer l'image vers le dossier "upload" avec le nom aléatoire
        $destination = "assets/upload/" . $random_img_profil;
        if (move_uploaded_file($tmp_img_profil, $destination)) {
            // Le téléchargement du fichier a réussi
        } else {
            echo "Erreur lors du téléchargement de l'image.";
            exit;
        }
    } else {
        echo "Aucun fichier n'a été téléchargé ou une erreur s'est produite.";
        exit;
    }

    try {
        $email = validateEscapeAndDecode($_POST['email']);
        $password = validateEscapeAndDecode($_POST['password']);
        $name = validateEscapeAndDecode($_POST['name']);
        $firstname = validateEscapeAndDecode($_POST['firstname']);
        $adresse = validateEscapeAndDecode($_POST['adresse']);
        $role = validateEscapeAndDecode($_POST['role']);

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        if (!checkEmailDomain($email, $allowedDomains)) {
            echo "L'adresse e-mail n'est pas autorisée.";
            exit; // Arrêter l'exécution du code si l'e-mail n'est pas autorisé.
        }

        // Utilisation de requêtes préparées pour sécuriser les données
        $sql = "INSERT INTO users (img_profil, email, password, name, firstname, adresse, id_role) VALUES (:img_profil, :email, :password, :name, :firstname, :adresse, :role)";
        $stmt = $connect->prepare($sql);

        // Lier les valeurs aux marqueurs de position
        $stmt->bindParam(":img_profil", $random_img_profil);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":firstname", $firstname);
        $stmt->bindParam(":adresse", $adresse);
        $stmt->bindParam(":role", $role);

        // Exécutez la requête
        if ($stmt->execute()) {
            // La requête a été exécutée avec succès, vous pouvez afficher un message ou rediriger l'utilisateur vers une autre page si nécessaire.
            sleep(2);
            header("Location: index.php?admin=ajoutUser");
        } else {
            // Si la requête échoue, vous pouvez afficher un message d'erreur ou faire un traitement supplémentaire.
            echo "Erreur lors de l'enregistrement des données : " . $stmt->errorInfo()[2];
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    } finally {
        // Fermez la connexion à la base de données après avoir terminé les opérations.
        $connect = null;
    }
}

?>

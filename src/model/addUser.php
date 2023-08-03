<?php 

include_once('connectBdd.php');

function checkEmailDomain($email, $allowedDomains) {
    // Récupérer le domaine de l'adresse e-mail
    $domain = substr(strrchr($email, "@"), 1);

    // Vérifier si le domaine fait partie des domaines autorisés
    return in_array($domain, $allowedDomains);
}

// Liste des domaines autorisés
$allowedDomains = array("gmail.com", "laposte.com", "example.com"); // Ajoutez d'autres domaines si nécessaire


if (isset($_POST['submit'])) {
    // Récupération des images
    $img_profil = $_FILES['img_profil']['name'];
    $tmp_img_profil = $_FILES['img_profil']['tmp_name'];
    move_uploaded_file($tmp_img_profil, "assets/upload/" . $img_profil);

    try {

        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $firstname = $_POST['firstname'];
        $adresse = $_POST['adresse'];
        $role = $_POST['role'];

        if (!checkEmailDomain($email, $allowedDomains)) {
            echo "L'adresse e-mail n'est pas autorisée.";
            exit; // Arrêter l'exécution du code si l'e-mail n'est pas autorisé.
        }

        // Utilisation de requêtes préparées pour sécuriser les données
        $sql = "INSERT INTO users (img_profil, email, password, name, firstname, adresse, id_role) VALUES (:img_profil, :email, :password, :name, :firstname, :adresse, :role)";
        $stmt = $connect->prepare($sql);

        // Lier les valeurs aux marqueurs de position
        $stmt->bindParam(":img_profil", $img_profil);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":firstname", $firstname);
        $stmt->bindParam(":adresse", $adresse);
        $stmt->bindParam(":role", $role);

        // Exécutez la requête
        if ($stmt->execute()) {
            // La requête a été exécutée avec succès, vous pouvez afficher un message ou rediriger l'utilisateur vers une autre page si nécessaire.
            echo "Les données ont été enregistrées avec succès.";
        } else {
            // Si la requête échoue, vous pouvez afficher un message d'erreur ou faire un traitement supplémentaire.
            echo "Erreur lors de l'enregistrement des données : " . $stmt->errorInfo()[2];
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }

    // Fermez la connexion à la base de données après avoir terminé les opérations.
    $connect = null;
}

?>
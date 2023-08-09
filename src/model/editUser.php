<?php

include_once('connectBdd.php');

$id_user = $_POST['id_user'];

$stmt_select = $connect->prepare("SELECT * FROM users WHERE id_user = :id_user");
$stmt_select->bindParam(':id_user', $id_user, PDO::PARAM_INT);
$stmt_select->execute();
$all_user = $stmt_select->fetchAll(PDO::FETCH_ASSOC);

function checkEmailDomain($email, $allowedDomains) {
    // Récupérer le domaine de l'adresse e-mail
    $domain = substr(strrchr($email, "@"), 1);

    // Vérifier si le domaine fait partie des domaines autorisés
    return in_array($domain, $allowedDomains);
}

// Validation et nettoyage des entrées POST
function sanitizeInput($input) {
    return html_entity_decode(htmlspecialchars(trim($input)), ENT_QUOTES, 'UTF-8');
}

// Liste des domaines autorisés
$allowedDomains = array("gmail.com", "laposte.com", "example.com"); // Ajoutez d'autres domaines si nécessaire


// Vérifiez si le formulaire a été soumis et que les données ont été envoyées via POST
if (isset($_POST['submit'])) {
    // Récupérez les nouvelles valeurs du formulaire
    $email = sanitizeInput($_POST['email']);
    $name = sanitizeInput($_POST['name']);
    $firstname = sanitizeInput($_POST['firstname']);
    $adresse = sanitizeInput($_POST['adresse']);
    $role = sanitizeInput($_POST['role']);

    if (!checkEmailDomain($email, $allowedDomains)) {
        echo "L'adresse e-mail n'est pas autorisée.";
        exit; // Arrêter l'exécution du code si l'e-mail n'est pas autorisé.
    }

    // Vérifiez si une nouvelle image d'entête a été envoyée
    if (isset($_FILES['img_profil']) && $_FILES['img_profil']['error'] === UPLOAD_ERR_OK) {
        // Traitez l'upload de l'image d'entête et mettez à jour le champ image_entete dans la base de données
        $img_profil = $_FILES['img_profil']['name'];
        move_uploaded_file($_FILES['img_profil']['tmp_name'], 'assets/upload/' . $img_profil);
        // Mettez à jour la valeur de $image_entete dans la base de données
    } else {
        // Gardez la même valeur d'image_entete dans la base de données si aucune nouvelle image n'a été envoyée
        $img_profil = $all_user[0]['img_profil'];
    }

    // Effectuez la requête SQL pour mettre à jour les données
    try {
        $stmt_update = $connect->prepare("UPDATE users
        SET img_profil = :img_profil,
            email = :email,
            name = :name,
            firstname = :firstname,
            adresse = :adresse,
            id_role = :id_role
            WHERE id_user = :id_user
        ");
    
        $stmt_update->bindParam(':img_profil', $img_profil, PDO::PARAM_STR);
        $stmt_update->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_update->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt_update->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt_update->bindParam(':adresse', $adresse, PDO::PARAM_STR);
        $stmt_update->bindParam(':id_role', $role, PDO::PARAM_STR);
        $stmt_update->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt_update->execute();


            // Redirigez vers une page de confirmation ou une autre page appropriée après la mise à jour
            header('Location: index.php?admin=crud');
            exit;

    } catch (PDOException $e) {
        // Gérer les exceptions ici
        echo "Erreur : " . $e->getMessage();
    }
}
?>

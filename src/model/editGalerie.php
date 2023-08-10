<?php

include_once('connectBdd.php');

function sanitizeInput($input) {
    return html_entity_decode(htmlspecialchars(trim($input)), ENT_QUOTES, 'UTF-8');
}

$id_galerie = $_POST['id_galerieimg'];

$stmt_select = $connect->prepare("SELECT * FROM galerie WHERE id_galerieimg = :id_galerieimg");
$stmt_select->bindParam(':id_galerieimg', $id_galerie, PDO::PARAM_INT);
$stmt_select->execute();
$all_galerie = $stmt_select->fetchAll(PDO::FETCH_ASSOC);

// Vérifiez si le formulaire a été soumis et que les données ont été envoyées via POST
if (isset($_POST['submit'])) {
    // Récupérez les nouvelles valeurs du formulaire
    $nom_photo = sanitizeInput($_POST['nom_photo']);
    $mot_clé = sanitizeInput($_POST['mot_clé']);

    // Vérifiez si une nouvelle image d'entête a été envoyée
    if (isset($_FILES['img_photo']) && $_FILES['img_photo']['error'] === UPLOAD_ERR_OK) {
        // Traitez l'upload de l'image d'entête et mettez à jour le champ image_entete dans la base de données
        $img_photo = $_FILES['img_photo']['name'];
        move_uploaded_file($_FILES['img_photo']['tmp_name'], 'assets/upload/' . $img_photo);
        // Mettez à jour la valeur de $image_entete dans la base de données
    } else {
        // Gardez la même valeur d'image_entete dans la base de données si aucune nouvelle image n'a été envoyée
        $img_photo = $all_galerie[0]['img_photo'];
    } 

    // Effectuez la requête SQL pour mettre à jour les données
    try {
        $stmt_update = $connect->prepare("UPDATE galerie
        SET nom_photo = :nom_photo,
            img_photo = :img_photo,
            mot_clé = :mot_cle
            WHERE id_galerieimg = :id_galerieimg
        ");

        $stmt_update->bindParam(':nom_photo', $nom_photo, PDO::PARAM_STR);
        $stmt_update->bindParam(':img_photo', $img_photo, PDO::PARAM_STR);
        $stmt_update->bindParam(':mot_cle', $mot_clé, PDO::PARAM_STR);
        $stmt_update->bindParam(':id_galerieimg', $id_galerie, PDO::PARAM_INT);
        $stmt_update->execute();

        // Redirigez vers une page de confirmation ou une autre page appropriée après la mise à jour
        sleep(2);
        header('Location: index.php?admin=crud');
        exit;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

?>

<?php

include_once('connectBdd.php');

// Validation et nettoyage des entrées POST
function sanitizeInput($input) {
    return html_entity_decode(htmlspecialchars(trim($input)), ENT_QUOTES, 'UTF-8');
}


$id_actualite = isset($_POST['id_actualite']) ? intval($_POST['id_actualite']) : 0;

$stmt_select = $connect->prepare("SELECT * FROM actualite WHERE id_actualite = :id_actualite");
$stmt_select->bindParam(':id_actualite', $id_actualite, PDO::PARAM_INT);
$stmt_select->execute();
$all_actualite = $stmt_select->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    // Valider et nettoyer les entrées du formulaire
    $titre_actualite = sanitizeInput($_POST['titre_actualite']);
    $introduction = sanitizeInput($_POST['introduction']);
    $video = sanitizeInput($_POST['video']);
    $text1 = sanitizeInput($_POST['text1']);
    $text2 = sanitizeInput($_POST['text2']);
    $titre2 = sanitizeInput($_POST['titre2']);
    $introduction2 = sanitizeInput($_POST['introduction2']);
    $text3 = sanitizeInput($_POST['text3']);
    $conclusion = sanitizeInput($_POST['conclusion']);
    $description = sanitizeInput($_POST['description']);
    $date = sanitizeInput($_POST['date']);
    $category = sanitizeInput($_POST['category']);

    // Valider l'URL de la vidéo
    $video = sanitizeInput($_POST['video']);
    if (strpos($video, 'https://www.youtube.com/embed/') !== 0) {
        header('Location: index.php?admin=modifyActu?error=invalid_video');
        exit;
    }

    // Mettez à jour la date dans le format attendu pour la base de données
    $date = date('Y-m-d', strtotime($_POST['date']));

    // Vérifiez si une nouvelle image d'entête a été envoyée
    if (isset($_FILES['image_entete']) && $_FILES['image_entete']['error'] === UPLOAD_ERR_OK) {
        // Traitez l'upload de l'image d'entête et mettez à jour le champ image_entete dans la base de données
        $image_entete = $_FILES['image_entete']['name'];
        move_uploaded_file($_FILES['image_entete']['tmp_name'], 'assets/upload/' . $image_entete);
        // Mettez à jour la valeur de $image_entete dans la base de données
    } else {
        // Gardez la même valeur d'image_entete dans la base de données si aucune nouvelle image n'a été envoyée
        $image_entete = $all_actualite[0]['image_entete'];
    }

    if (isset($_FILES['image1']) && $_FILES['image1']['error'] === UPLOAD_ERR_OK) {

        $image1 = $_FILES['image1']['name'];
        move_uploaded_file($_FILES['image1']['tmp_name'], 'assets/upload/' . $image1);

    } else {
        $image1 = $all_actualite[0]['image1'];
    }

    if (isset($_FILES['image2']) && $_FILES['image2']['error'] === UPLOAD_ERR_OK) {

        $image2 = $_FILES['image2']['name'];
        move_uploaded_file($_FILES['image2']['tmp_name'], 'assets/upload/' . $image2);

    } else {
        $image2 = $all_actualite[0]['image2'];
    }

    if (isset($_FILES['imagegain']) && $_FILES['imagegain']['error'] === UPLOAD_ERR_OK) {

        $imagegain = $_FILES['imagegain']['name'];
        move_uploaded_file($_FILES['imagegain']['tmp_name'], 'assets/upload/' . $imagegain);

    } else {
        $imagegain = $all_actualite[0]['imagegain'];
    }

    // Effectuez la requête SQL pour mettre à jour les données
    try {
        $stmt_update = $connect->prepare("UPDATE actualite
        SET titre_actualite = :titre_actualite,
            image_entete = :image_entete,
            introduction = :introduction,
            video = :video,
            text1 = :text1,
            image1 = :image1,
            text2 = :text2,
            titre2 = :titre2,
            introduction2 = :introduction2,
            image2 = :image2,
            text3 = :text3,
            conclusion = :conclusion,
            imagegain = :imagegain,
            description = :description,
            date_actualite = :date_actualite,
            id_category = :id_category
            WHERE id_actualite = :id_actualite
        ");


        $stmt_update->bindParam(':titre_actualite', $titre_actualite, PDO::PARAM_STR);
        $stmt_update->bindParam(':image_entete', $image_entete, PDO::PARAM_STR);
        $stmt_update->bindParam(':introduction', $introduction, PDO::PARAM_STR);
        $stmt_update->bindParam(':video', $video, PDO::PARAM_STR);
        $stmt_update->bindParam(':text1', $text1, PDO::PARAM_STR);
        $stmt_update->bindParam(':image1', $image1, PDO::PARAM_STR);
        $stmt_update->bindParam(':text2', $text2, PDO::PARAM_STR);
        $stmt_update->bindParam(':titre2', $titre2, PDO::PARAM_STR);
        $stmt_update->bindParam(':introduction2', $introduction2, PDO::PARAM_STR);
        $stmt_update->bindParam(':image2', $image2, PDO::PARAM_STR);
        $stmt_update->bindParam(':text3', $text3, PDO::PARAM_STR);
        $stmt_update->bindParam(':conclusion', $conclusion, PDO::PARAM_STR);
        $stmt_update->bindParam(':imagegain', $imagegain, PDO::PARAM_STR);
        $stmt_update->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt_update->bindParam(':date_actualite', $date, PDO::PARAM_STR);
        $stmt_update->bindParam(':id_category', $category, PDO::PARAM_INT);
        $stmt_update->bindParam(':id_actualite', $id_actualite, PDO::PARAM_INT);
        $stmt_update->execute();

        // Redirigez vers une page de confirmation ou une autre page appropriée après la mise à jour
        header('Location: index.php?admin=crud');
        exit;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

?>

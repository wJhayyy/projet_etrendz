<?php

include_once('connectBdd.php');

// Validation et nettoyage des entrées POST
function sanitizeInput($input) {
    return html_entity_decode(htmlspecialchars(trim($input)), ENT_QUOTES, 'UTF-8');
}


$id_mercato = isset($_POST['id_mercato']) ? intval($_POST['id_mercato']) : 0;

$stmt_select = $connect->prepare("SELECT * FROM mercato WHERE id_mercato = :id_mercato");
$stmt_select->bindParam(':id_mercato', $id_mercato, PDO::PARAM_INT);
$stmt_select->execute();
$all_mercato = $stmt_select->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    // Valider et nettoyer les entrées du formulaire
    $titre = sanitizeInput($_POST['titre']);
    $titre1 = sanitizeInput($_POST['titre1']);
    $text1 = sanitizeInput($_POST['text1']);
    $tweet1 = sanitizeInput($_POST['tweet1']);
    $text2 = sanitizeInput($_POST['text2']);
    $tweet2 = sanitizeInput($_POST['tweet2']);
    $text3 = sanitizeInput($_POST['text3']);
    $titre2 = sanitizeInput($_POST['titre2']);
    $text4 = sanitizeInput($_POST['text4']);
    $tweet3 = sanitizeInput($_POST['tweet3']);
    $conclusion = sanitizeInput($_POST['conclusion']);
    $description = sanitizeInput($_POST['description']);
    $date_mercato = sanitizeInput($_POST['date_mercato']);
    $category = isset($_POST['category']) ? intval($_POST['category']) : 0;

    // Mettez à jour la date dans le format attendu pour la base de données
    $date_mercato = date('Y-m-d', strtotime($date_mercato));

    // Vérifiez si une nouvelle image d'entête a été envoyée
    if (isset($_FILES['image_entete']) && $_FILES['image_entete']['error'] === UPLOAD_ERR_OK) {
        // Traitez l'upload de l'image d'entête et mettez à jour le champ image_entete dans la base de données
        $image_entete = $_FILES['image_entete']['name'];
        move_uploaded_file($_FILES['image_entete']['tmp_name'], 'assets/upload/' . $image_entete);
        // Mettez à jour la valeur de $image_entete dans la base de données
    } else {
        // Gardez la même valeur d'image_entete dans la base de données si aucune nouvelle image n'a été envoyée
        $image_entete = $all_mercato[0]['image_entete'];
    }

    // Effectuez la requête SQL pour mettre à jour les données
    try {
        $stmt_update = $connect->prepare("UPDATE mercato
        SET titre = :titre,
            image_entete = :image_entete,
            titre1 = :titre1,
            text1 = :text1,
            tweet1 = :tweet1,
            text2 = :text2,
            tweet2 = :tweet2,
            text3 = :text3,
            titre2 = :titre2,
            text4 = :text4,
            tweet3 = :tweet3,
            conclusion = :conclusion,
            description = :description,
            date_mercato = :date_mercato,
            id_category = :id_category
            WHERE id_mercato = :id_mercato
        ");
    
        $stmt_update->bindParam(':titre', $titre, PDO::PARAM_STR);
        $stmt_update->bindParam(':image_entete', $image_entete, PDO::PARAM_STR);
        $stmt_update->bindParam(':titre1', $titre1, PDO::PARAM_STR);
        $stmt_update->bindParam(':text1', $text1, PDO::PARAM_STR);
        $stmt_update->bindParam(':tweet1', $tweet1, PDO::PARAM_STR);
        $stmt_update->bindParam(':text2', $text2, PDO::PARAM_STR);
        $stmt_update->bindParam(':tweet2', $tweet2, PDO::PARAM_STR);
        $stmt_update->bindParam(':text3', $text3, PDO::PARAM_STR);
        $stmt_update->bindParam(':titre2', $titre2, PDO::PARAM_STR);
        $stmt_update->bindParam(':text4', $text4, PDO::PARAM_STR);
        $stmt_update->bindParam(':tweet3', $tweet3, PDO::PARAM_STR);
        $stmt_update->bindParam(':conclusion', $conclusion, PDO::PARAM_STR);
        $stmt_update->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt_update->bindParam(':date_mercato', $date_mercato, PDO::PARAM_STR);
        $stmt_update->bindParam(':id_category', $category, PDO::PARAM_INT);
        $stmt_update->bindParam(':id_mercato', $id_mercato, PDO::PARAM_INT);
        $stmt_update->execute();


            // Redirigez vers une page de confirmation ou une autre page appropriée après la mise à jour
            sleep(2);
            header('Location: index.php?admin=crud');
            exit;

    } catch (PDOException $e) {
        // Gérer les exceptions ici
        echo "Erreur : " . $e->getMessage();
    }
}
?>

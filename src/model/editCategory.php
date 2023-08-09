<?php

include_once('connectBdd.php');

// Validation et nettoyage des entrées POST
function sanitizeInput($input) {
    return html_entity_decode(htmlspecialchars(trim($input)), ENT_QUOTES, 'UTF-8');
}

$id_category = isset($_POST['id_category']) ? intval($_POST['id_category']) : 0;

$stmt_select = $connect->prepare("SELECT * FROM category WHERE id_category = :id_category");
$stmt_select->bindParam(':id_category', $id_category, PDO::PARAM_INT);
$stmt_select->execute();
$all_category = $stmt_select->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    // Valider et nettoyer les entrées du formulaire
    $name_category = sanitizeInput($_POST['name_category']);
    $type = sanitizeInput($_POST['type']); 

    // Préparation des requêtes SQL pour toutes les opérations
    try {
        $stmt_update = $connect->prepare("UPDATE category SET
            name_category = :name_category,
            type = :type
            WHERE id_category = :id_category
        ");

        // Paramètres liés à la mise à jour
        $stmt_update->bindParam(':name_category', $name_category, PDO::PARAM_STR);
        $stmt_update->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt_update->bindParam(':id_category', $id_category, PDO::PARAM_INT);
        $stmt_update->execute();
        

        // Redirection après la mise à jour
        header('Location: index.php?admin=crud');
        exit;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

?>

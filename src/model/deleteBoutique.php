<?php

include_once('connectBdd.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérifiez si l'ID de l'article est présent dans la requête POST et est un nombre entier positif
    if (isset($_POST["deleteId"]) && filter_var($_POST["deleteId"], FILTER_VALIDATE_INT, array("options" => array("min_range" => 1)))) {
        // Récupérez et validez l'ID de l'article à supprimer depuis la requête POST
        $deleteId = $_POST["deleteId"];

        try {
            // Préparez la requête de suppression
            $query = "DELETE * FROM boutique WHERE id_article = :deleteId";

            // Exécutez la requête en utilisant un paramètre nommé pour éviter les injections SQL
            $stmt = $connect->prepare($query);
            $stmt->bindParam(":deleteId", $id_article, PDO::PARAM_INT);

            // Exécutez la requête
            $stmt->execute();

            $connect = null;
            
            // Redirigez l'utilisateur vers la page d'origine après la suppression
            header("Location: index.php?admin=crud");
            exit;
        } catch (PDOException $e) {
            // Utilisation des exceptions PDO pour afficher l'erreur
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        echo "ID de l'article invalide ou manquant.";
    }
}

// Fermez la connexion à la base de données après avoir terminé les opérations.
$connect = null;
?>

<?php

include_once('connectBdd.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérifiez si l'ID de l'actualité est présent dans la requête POST
    if (isset($_POST["id_article"])) {
        // Récupérez l'ID de l'actualité à supprimer depuis la requête POST
        $id_article = $_POST["id_article"];

        try {

            // Préparez la requête de suppression
            $query = "DELETE FROM boutique WHERE id_article = :id_article";

            // Exécutez la requête en utilisant un paramètre nommé pour éviter les injections SQL
            $stmt = $connect->prepare($query);
            $stmt->bindParam(":id_article", $id_article, PDO::PARAM_INT);

            // Exécutez la requête
            $stmt->execute();

            // Redirigez l'utilisateur vers la page d'origine après la suppression
            header("Location: index.php?admin=crud");
            exit;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        echo "ID de l'actualité manquant.";
    }
}
?>

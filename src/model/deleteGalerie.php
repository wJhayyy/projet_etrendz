<?php

include_once('connectBdd.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérifiez si l'ID de l'actualité est présent dans la requête POST
    if (isset($_POST["deleteId"])) {
        // Récupérez l'ID de l'actualité à supprimer depuis la requête POST
        $id_galerieimg = $_POST["deleteId"];

        try {

            // Préparez la requête de suppression
            $query = "DELETE FROM galerie WHERE id_galerieimg = :deleteId";

            // Exécutez la requête en utilisant un paramètre nommé pour éviter les injections SQL
            $stmt = $connect->prepare($query);
            $stmt->bindParam(":deleteId", $id_galerieimg, PDO::PARAM_INT);

            // Exécutez la requête
            $stmt->execute();

            $connect = null;
            
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

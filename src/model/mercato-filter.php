<?php
// Assurez-vous que le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer la valeur du filtre (id_category) et la valider
    $selectedCategory = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);

    // Vérifier si une catégorie a été sélectionnée
    if (!empty($selectedCategory)) {
        try {

            // Construire la requête SQL pour filtrer les résultats de la table "mercato"
            $sql = "SELECT * FROM mercato WHERE id_category = :selectedCategory";

            // Exécuter la requête en utilisant une requête préparée
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':selectedCategory', $selectedCategory, PDO::PARAM_INT);
            $stmt->execute();

            // Récupérer les résultats filtrés
            $filteredResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Afficher les résultats filtrés (vous pouvez personnaliser l'affichage selon vos besoins)
            foreach ($filteredResults as $result) {
                echo $result['nom_colonne'];
                // ... continuer avec d'autres colonnes à afficher
            }

        } catch (PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
    } else {
        // Si aucune catégorie n'a été sélectionnée, afficher un message approprié ou rediriger vers la page principale par exemple
        echo "Veuillez sélectionner une catégorie.";
    }
}
?>

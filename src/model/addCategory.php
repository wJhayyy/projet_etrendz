<?php
if (isset($_POST['submit'])) {

    // Fonction pour valider, échapper et décoder les entités HTML des données
    function validateEscapeAndDecode($data) {
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = html_entity_decode($data); // Ajout de html_entity_decode
        // Vous pouvez ajouter d'autres validations spécifiques ici si nécessaire
        return $data;
    }
    $servername = "localhost";
    $username = "jerem";
    $password = "jerem";
    $dbname = "gamerush";

    $connect = new mysqli($servername, $username, $password, $dbname);

    if ($connect->connect_error) {
        die("La connexion à la base de données a échoué : " . $connect->connect_error);
    }

    // Valider et échapper les données avant insertion
    $name_category = validateEscapeAndDecode($_POST['name_category']);
    $type = validateEscapeAndDecode($_POST['type']);

    // Utilisation de requêtes préparées pour sécuriser les données
    $sql = "INSERT INTO category (name_category, type) VALUES (?, ?)";
    $stmt = $connect->prepare($sql);

    if ($stmt) {
        // Assurez-vous de lier les valeurs correctement avec le type de données attendu dans la base de données
        $stmt->bind_param("ss", $name_category, $type);

        // Exécutez la requête
        if ($stmt->execute()) {
            // La requête a été exécutée avec succès, vous pouvez afficher un message ou rediriger l'utilisateur vers une autre page si nécessaire.
            echo "Les données ont été enregistrées avec succès.";
        } else {
            // Si la requête échoue, vous pouvez afficher un message d'erreur ou faire un traitement supplémentaire.
            echo "Erreur lors de l'enregistrement des données : " . $stmt->error;
        }

        // Fermez la connexion à la base de données après avoir terminé les opérations.
        $stmt->close();
    } else {
        echo "Erreur de préparation de la requête : " . $connect->error;
    }

    $connect->close();
}

?>

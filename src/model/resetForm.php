<?php
include_once('connectBdd.php');

$token = $_GET['token'];

$response = array(); // Tableau pour stocker les réponses

// Rechercher l'e-mail associé au token dans la base de données
$findEmailQuery = "SELECT email FROM users WHERE token = :token";
$findEmailStmt = $connect->prepare($findEmailQuery);
$findEmailStmt->bindParam(':token', $token);
$findEmailStmt->execute();

$row = $findEmailStmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $userEmail = $row['email'];
    $response['email'] = $userEmail; // Ajouter l'e-mail à la réponse
} else {
    $response['error'] = "Token invalide.";
}

if ($_POST['submit'] === 'true') {
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $email = $_POST['email'];

    if ($newPassword === $confirmPassword) {
        // Vérifier la confirmKey pour l'email donné
        $confirmKeyQuery = "SELECT confirmKey FROM users WHERE email = :email";
        $confirmKeyStmt = $connect->prepare($confirmKeyQuery);
        $confirmKeyStmt->bindParam(':email', $email);
        $confirmKeyStmt->execute();

        $row = $confirmKeyStmt->fetch(PDO::FETCH_ASSOC);

        if ($row && $row['confirmKey'] == true) {
            // Mettre à jour le mot de passe
            $updatePasswordQuery = "UPDATE users SET password = :password WHERE email = :email";
            $updatePasswordStmt = $connect->prepare($updatePasswordQuery);
            
            // Hash du mot de passe (assurez-vous d'utiliser des fonctions de hachage sécurisées comme password_hash)
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            $updatePasswordStmt->bindParam(':password', $hashedPassword);
            $updatePasswordStmt->bindParam(':email', $email);
            
            if ($updatePasswordStmt->execute()) {
                $response['success'] = true;
                $response['message'] = "Mot de passe mis à jour avec succès.";
            } else {
                $response['error'] = "Erreur lors de la mise à jour du mot de passe.";
            }
        } else {
            $response['error'] = "La confirmKey n'est pas valide pour cet e-mail.";
        }
    } else {
        $response['error'] = "Les mots de passe ne correspondent pas.";
    }
}

// Renvoyer la réponse au format JSON
header('Content-Type: application/json');
echo json_encode($response);
?>

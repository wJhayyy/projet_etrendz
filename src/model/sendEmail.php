<?php
include_once('connectBdd.php');

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST["email"]);

    $query = "SELECT id_role, email, confirmKey FROM users WHERE email = :email";
    $stmt = $connect->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    var_dump($user);
    
    if ($user) {
        if ($user['confirmKey'] == 1) {
            // Générer un token unique
            $token = bin2hex(random_bytes(32)); // Exemple de génération de token
            
            // Mettre à jour la colonne "token" dans la base de données
            $updateQuery = "UPDATE users SET token = :token WHERE email = :email";
            $updateStmt = $connect->prepare($updateQuery);
            $updateStmt->bindParam(":token", $token);
            $updateStmt->bindParam(":email", $email);
            $updateStmt->execute();

            $response["success"] = true;
            $response["message"] = "Un email de réinitialisation a été envoyé à votre adresse email.";
            
            // Envoyer l'email avec le lien de réinitialisation
            // Utilisez une librairie pour envoyer des emails, comme PHPMailer, ou la fonction mail() si configurée sur votre serveur
            $subject = "Réinitialisation de mot de passe";
            $message = "Pour réinitialiser votre mot de passe, cliquez sur le lien suivant : https://gamerush/index.php?admin=resetPassword&token=" . urlencode($token);
            $headers = "From: noreply@votresite.com";
            mail($email, $subject, $message, $headers);
        
        } else {
            $response["message"] = "Votre compte est désactivé.";
        }
    } else {
        $response["message"] = "Email non trouvé.";
    }
}

$connect = null;

// Envoi de la réponse au format JSON
header('Content-Type: application/json');
echo json_encode($response);
?>

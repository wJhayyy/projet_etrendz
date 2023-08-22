<?php
include_once('connectBdd.php');
$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST["email"]);
    $password = $_POST["password"];

    $query = "SELECT id_role, email, password, confirmKey FROM users WHERE email = :email";
    $stmt = $connect->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        if ($user['confirmKey'] == 1) {
            $response["success"] = true;
            $response["message"] = "Connexion réussie pour l'utilisateur : " . $user['email'];
            $_SESSION['id_role'] = $user['id_role'];
            $_SESSION['email'] = $user['email'];
        } else {
            $response["message"] = "Votre compte est désactivé.";
            // Vous pouvez ajouter ici le code pour la redirection vers une page de compte désactivé.
        }
    } else {
        $response["message"] = "Identifiant ou mot de passe invalide !";
    }
}

$connect = null;

// Envoi de la réponse au format JSON
header('Content-Type: application/json');
echo json_encode($response);
?>

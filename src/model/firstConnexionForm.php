<?php
include_once('connectBdd.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['hiddenEmail'])) {
        $email = $_POST['hiddenEmail'];
        $newPassword = $_POST['password'];
        $confirmedPassword = $_POST['confirm_password'];

        // Ajoutez ici votre expression régulière pour la validation du mot de passe
        $passwordPattern = '/^(?=.*[A-Za-z])(?=.*\d).{10,}$/';

        if (!preg_match($passwordPattern, $newPassword)) {
            echo "password_invalid";
        } elseif ($newPassword !== $confirmedPassword) {
            echo "password_mismatch";
        } else {
            // Hachage du mot de passe
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Mise à jour du mot de passe associé à l'e-mail
            $sql = "UPDATE users SET password = :hashedPassword, confirmKey = 1 WHERE email = :email";
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':hashedPassword', $hashedPassword);
            $stmt->bindParam(':email', $email);

            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "update_error";
            }

            $connect = null;
        }
    } else {
        echo "email_missing";
    }
}
?>

<?php
include_once('connectBdd.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['hiddenEmail'])) {
        $email = filter_input(INPUT_POST, 'hiddenEmail', FILTER_VALIDATE_EMAIL);
        $newPassword = $_POST['password'];
        $confirmedPassword = $_POST['confirm_password'];

        $passwordPattern = '/^(?=.*[A-Za-z])(?=.*\d).{10,}$/';

        if (!preg_match($passwordPattern, $newPassword)) {
            echo "password_invalid";
        } elseif ($newPassword !== $confirmedPassword) {
            echo "password_mismatch";
        } else {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

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

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['nom']) && isset($_POST['sujet']) && isset($_POST['email']) && isset($_POST['message'])) {

        $email = htmlspecialchars($_POST['nom']);
        $sujet = htmlspecialchars($_POST['sujet']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        $headers = "From: contact@exemplecontact.fr\r\n";
        $headers .= "Reply-to: $email\r\n";

        $message_body = "Ce message vous a été envoyé via la page de contact du site Allosimplon.com\n\n";
        $message_body .= "Email: $nom\n";
        $message_body .= "Email: $email\n";
        $message_body .= "Sujet: $sujet\n\n";
        $message_body .= "$message\n";

        $retour = mail('skytek077@gmail.com', $sujet, $message_body, $headers);

        if ($retour) {
            echo "L'email a bien été envoyé.";
        } else {
            echo "Une erreur est survenue lors de l'envoi de l'email.";
        }
    }
}

header('location: ../../index.php')
?>
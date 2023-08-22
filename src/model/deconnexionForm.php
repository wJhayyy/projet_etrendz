<?php
// Démarrer la session (si ce n'est pas déjà fait)
session_start();

// Détruire toutes les variables de session
$_SESSION = array();

// Effacer le cookie de session, si vous l'utilisez
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Détruire la session
session_destroy();

// Rediriger vers la page d'accueil ou une autre page après la déconnexion
header("Location: index.php");
exit();
?>

<?php

function homepage()
{
    require_once('view/accueil.php');
}

function vueContact()
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    $csrfToken = $_SESSION['csrf_token'];
    
    // Fonction pour nettoyer les données d'entrée
    function sanitize($data)
    {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
    
    // Traiter la soumission du formulaire
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Vérifier le jeton CSRF
        if (!empty($_POST['csrf_token']) && hash_equals($_POST['csrf_token'], $_SESSION['csrf_token'])) {
            // Nettoyer les données du formulaire
            $nom = sanitize($_POST['nom']);
            $sujet = sanitize($_POST['sujet']);
            $email = sanitize($_POST['email']);
            $message = sanitize($_POST['message']);
    
            // Votre logique de traitement du formulaire se trouve ici
            // ...
    
            // Après le traitement, regénérer un nouveau jeton CSRF pour la prochaine soumission du formulaire
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    
            // Redirection ou affichage d'un message de succès
            // ...
        } else {
            // Le jeton CSRF est invalide, gérer l'erreur (par exemple, afficher un message d'erreur ou enregistrer l'incident dans les journaux)
            // Vous pouvez également rediriger l'utilisateur vers une page d'erreur ou afficher un message indiquant l'erreur.
            // ...
        }
    }

    require_once('view/contact.php');
}

function ContactForm(){
    require_once('src/model/form-contact.php');
}

function vueApropos(){
    require_once('view/aboutus.php');
}

function vueGalerie(){
    require_once('view/galerie.php');
}

function vueMercatos(){
    require_once('view/mercatos.php');
}

function vueMercato(){
    require_once('view/mercato.php');
}

function vueActualité(){
    require_once('view/actualite.php');
}

function vueActualités(){
    require_once('view/actualites.php');
}
<?php
session_start();
require_once('src/controller/homeController.php');

if (isset($_GET['action']) && $_GET['action'] !== '') {
    switch ($_GET['action']) {
        case 'contact':
            vueContact();
            break;
        case 'apropos':
            vueApropos();
            break;
        case 'article':
            vueArticle();
            break;
        case 'realisations':
            vueRealisations();
            break; 
        case 'accueil':
            homepage();
            break;      
        // génère la home si aucun des cases n'est trouvé
    }
} else {
    homepage();
}
?>
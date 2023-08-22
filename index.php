<?php
session_start();
require_once('src/controller/homeController.php');
require_once('src/controller/adminController.php');

if (isset($_GET['action']) && $_GET['action'] !== '') {
    switch ($_GET['action']) {
        case 'contact':
            vueContact();
            break;
        case 'apropos':
            vueApropos();
            break;
        case 'galerie':
            vueGalerie();
            break;
        case 'mercatos':
            vueMercatos();
            break;
        case 'mercato':
            vueMercato();
            break;
        case 'actualite':
            vueActualite();
            break; 
        case 'actualites':
            vueActualites();
            break; 
        case 'accueil':
            homepage();
            break;
        case 'contactForm':
            ContactForm();
             break;       
        // génère la home si aucun des cases n'est trouvé
    }
} elseif (isset($_GET['admin']) && $_GET['admin'] !== '') {
    //role rentrer en dur pour acceder panel admin
    // $_SESSION['role_user'] = 2;
    // if (isset($_SESSION['role_user']) && $_SESSION['role_user'] == 2) {
        switch ($_GET['admin']) {
            case 'crud':
                panelCrud();
                break;
            case 'connexionAdmin':
                vueConnexion();
                break;
            case 'loginAdmin':
                loginAdmin();
                break;
            case 'profilAdmin':
                profilAdmin();
                break;
            case 'deconnexionForm':
                deconnexionForm();
                break;
            case 'forgottenPassword':
                forgottenPassword();
                break;
            case 'sendEmail':
                sendEmail();
                break;
            case 'resetPassword':
                resetPassword();
                break;
            case 'resetForm':
                resetForm();
                break;
            case 'firstConnexion':
                firstConnexion();
                break;
            case 'firstConnexionForm':
                firstConnexionForm();
                 break;
    


            case 'deleteActu':
                deleteActu();
                break;
            case 'deleteMercato':
                deleteMercato();
                break;
            case 'deleteGalerie':
                deleteGalerie();
                break;
            case 'deleteCategory':
                deleteCategory();
                break;
            case 'deleteUser':
                deleteUser();
                break;
            case 'deleteBoutique':
                deleteBoutique();
                break;


            case 'ajoutActu':
                ajoutActu();
                break;
            case 'addActu':
                addActu();
                break;
            case 'ajoutMercato':
                ajoutMercato();
                break;
            case 'addMercato':
                addMercato();
                break;
            case 'ajoutGalerie':
                ajoutGalerie();
                break;
            case 'addGalerie':
                addGalerie();
                break;
            case 'ajoutCategory':
                ajoutCategory();
                break;
            case 'addCategory':
                addCategory();
                break;
            case 'ajoutUser':
                ajoutUser();
                break;
            case 'addUser':
                addUser();
                break;
            case 'ajoutBoutique':
                ajoutBoutique();
                break;
            case 'addBoutique':
                addBoutique();
                break;


            case 'modifyActu':
                modifyActu();
                break;
            case 'editActu':
                editActu();
                break;
            case 'modifyMercato':
                modifyMercato();
                break;
            case 'editMercato':
                editMercato();
                break;
            case 'modifyGalerie':
                modifyGalerie();
                break;
            case 'editGalerie':
                editGalerie();
                break;
            case 'modifyCategory':
                modifyCategory();
                break;
            case 'editCategory':
                editCategory();
                break;
            case 'modifyUser':
                modifyUser();
                break;
            case 'editUser':
                editUser();
                break;
            case 'addBoutique':
                addBoutique();
                break;

            default:
                homepage();
                break;
        }
    } else {
        homepage();
    }
// } else {
//     homepage();
// }

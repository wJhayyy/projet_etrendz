<?php 

include_once('connectBdd.php');

$allimages = $connect->prepare('SELECT * FROM galerie ORDER BY id_galerieimg DESC');

if(isset($_GET['s']) AND !empty($_GET['s'])){
    $recherche = htmlspecialchars($_GET['s']);
    $allimages = $connect->prepare('SELECT nom_photo, description_photo FROM galerie WHERE nom_photo LIKE "%'.$recherche.'%" OR description_photo LIKE "%'.$recherche.'%" ORDER BY id_galerieimg DESC');
}

?>
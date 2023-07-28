<?php

include_once('src/model/connectBdd.php');

// Vérifier si l'id_mercato est présent dans les paramètres GET
if (isset($_GET['id_actualite']) && !empty($_GET['id_actualite'])) {
    // Récupérer l'id_mercato depuis les paramètres GET
    $id_actualite = $_GET['id_actualite'];

    // Requête SQL avec une jointure entre les tables "mercato" et "category"
    $sql = 'SELECT a.*, c.name_category 
            FROM actualite AS a
            INNER JOIN category AS c ON a.id_category = c.id_category
            WHERE a.id_actualite = :id';

    $stmt_actualite = $connect->prepare($sql);
    $stmt_actualite->bindParam(':id', $id_actualite, PDO::PARAM_INT);
    $stmt_actualite->execute();
    $actualite = $stmt_actualite->fetch(PDO::FETCH_ASSOC);
  

    if (isset($actualite) && empty($actualite)) {
        header('Location: index.php?action=actualités');
        exit;
    }    
}

// Requête pour afficher les éléments sans recherche avec pagination
// Sélectionner le nombre total d'enregistrements dans la table "mercato"
$stmt_count = $connect->prepare("SELECT COUNT(*) FROM actualite");
$stmt_count->execute();
$total_rows = $stmt_count->fetchColumn();

// Vérifier si nous avons au moins 4 enregistrements dans la table
if ($total_rows >= 4) {
    // Tant que nous n'avons pas 4 enregistrements uniques, on continue de générer une nouvelle requête
    do {
        // Générer trois IDs aléatoires
        $random_ids = array_rand(range(1, $total_rows), 4);

        // Convertir les IDs en une chaîne pour la clause IN de la requête
        $random_ids_str = implode(',', $random_ids);

        // Sélectionner les enregistrements avec les IDs aléatoires, en limitant à 4 résultats
        $stmt_actu = $connect->prepare("SELECT id_actualite, image_entete, titre_actualite, description, date_actualite
                                          FROM actualite
                                          WHERE id_actualite IN ($random_ids_str)
                                          LIMIT 4");
        $stmt_actu->execute();
        $all_actualite = $stmt_actu->fetchAll(PDO::FETCH_ASSOC);
        
        // Répéter la boucle si on n'obtient pas trois enregistrements uniques
    } while (count(array_unique(array_column($all_actualite, 'id_actualite'))) < 4);
} else {
    // Traiter le cas où il y a moins de 4 enregistrements dans la table "mercato"
    // Vous pouvez ajuster cette partie selon vos besoins
    $stmt_act = $connect->prepare("SELECT id_actualite, image_entete, titre_actualite, description, date_actualite
                                      FROM actualite
                                      LIMIT 4");
    $stmt_act->execute();
    $all_actualite = $stmt_act->fetchAll(PDO::FETCH_ASSOC);
}


function limitText($text, $limit) {
    if (mb_strlen($text) <= $limit) {
        return $text;
    } else {
        $shortenedText = mb_substr($text, 0, $limit);
        $lastSpace = mb_strrpos($shortenedText, ' ');
        return rtrim(mb_substr($shortenedText, 0, $lastSpace)) . '...';
    }
}

?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Gamerush - <?php echo isset($actualite['titre_actualite']) ? $actualite['titre_actualite'] : 'Titre de la page'; ?></title>
    <link rel="stylesheet" href="assets/css/button-navbar.css">
    <link rel="stylesheet" href="assets/css/gradient-hr.css">
    <?php include_once('include/link.php') ?>
</head>

<body class="bg-color1">
    <?php include_once('include/navbar.php') ?>
    <div class="w-full">
        <hr class="hrgradient w-4/6 m-auto mt-24 md:w-3/6">
            <h2 class="text-color5 text-2xl lg:text-3xl text-center py-8"><?php echo htmlspecialchars($actualite['titre_actualite'])?></h2>
        <hr class="hrgradient w-4/6 m-auto mb-16 md:w-3/6">
            <img class="rounded m-auto max-w-sm mb-10 md:max-w-lg lg:max-w-3xl" src="assets/image/<?php echo htmlspecialchars($actualite['image_entete'])?>">
            <p class="text-color5 text-center m-auto mb-10 w-10/12 lg:w-8/12 lg:text-lg"><?php echo htmlspecialchars($actualite['introduction'])?></p>
            <div class="flex justify-center m-auto mb-10 w-10/12 w-[400px] sm:w-[500px] md:w-[600px] lg:w-7/12 h-[200px] sm:h-[300px] md:h-[400px] lg:h-[500px]">
                <iframe width="1000%" height="100%" src="<?php echo htmlspecialchars($actualite['video'])?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
            <p class="text-color5 text-center m-auto mt-10 mb-10 w-10/12 lg:w-8/12 lg:text-lg"><?php echo htmlspecialchars($actualite['text1'])?></p>
                <img class="rounded m-auto max-w-sm md:max-w-lg lg:max-w-3xl" src="assets/image/<?php echo htmlspecialchars($actualite['image1'])?>">
            <p class="text-color5 text-center m-auto mt-10 mb-10 w-10/12 lg:w-8/12 lg:text-lg"><?php echo htmlspecialchars($actualite['text2'])?></p>
            <hr class="hrgradient w-4/6 m-auto mt-16 md:w-3/6">
                <h3 class="text-color5 text-center mt-8 lg:mt-12 text-lg lg:text-xl mb-8 lg:mb-12"><?php echo htmlspecialchars($actualite['titre2'])?></h3>
            <hr class="hrgradient w-4/6 m-auto mb-16 md:w-3/6">
            <p class="text-color5 text-center m-auto mt-10 mb-10 w-10/12 lg:w-8/12 lg:text-lg"><?php echo htmlspecialchars($actualite['introduction2'])?></p>
                <img class="rounded m-auto max-w-sm md:max-w-lg lg:max-w-3xl" src="assets/image/<?php echo htmlspecialchars($actualite['image2'])?>">
            <p class="text-color5 text-center m-auto mt-10 mb-10 w-10/12 lg:w-8/12 lg:text-lg"><?php echo htmlspecialchars($actualite['text3'])?></p>
            <p class="text-color5 text-center m-auto mt-10 mb-10 w-10/12 lg:w-8/12 lg:text-lg"><?php echo htmlspecialchars($actualite['conclusion'])?></p>
            <p class="text-color5 text-center">Date : <?php echo htmlspecialchars($actualite['date_actualite'])?></p>
            <p class="text-color5 text-center">Catégorie : <?php echo htmlspecialchars(str_replace('- Actualité', '', $actualite['name_category']))?></p>
    </div>
    <h4 class="text-color5 text-center text-xl mt-12 mb-12">Voici d'autres actualités : </h4>
<div class="contain grid grid-cols-2 gap-2 sm:gap-8 justify-items-center">
    <?php foreach ($all_actualite as $actualite) : ?>
        <div class="w-11/12 lg:w-5/6 lg:flex">
            <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" style="background-image: url('assets/image/<?php echo htmlspecialchars($actualite['image_entete']); ?>')" title="<?php echo htmlspecialchars($actualite['titre_actualite']); ?>">
            </div>
            <a href="<?php echo htmlspecialchars('index.php?action=mercato&id_mercato=' . $actualite['id_actualite']); ?>">
            <div class="max-w-full w-full border-r border-b border-l border-grey-light lg:border-l-0 lg:border-t lg:border-grey-light bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                <div class="mb-8">
                <div class="text-black font-bold text-xl mb-2"><a href="<?php echo htmlspecialchars('index.php?action=actualite&id_actualite=' . $actualite['id_actualite']); ?>"><?php echo limitText(htmlspecialchars($actualite['titre_actualite']), 60); ?></a></div>
                <p class="text-grey-darker text-base hidden lg:block">
                <?php echo limitText(htmlspecialchars($actualite['description']), 80); ?></p>
                </div>
                 <div class="text-sm">
                    <p class="text-color1"><?php echo htmlspecialchars($actualite['date_actualite']); ?></p>
                </div>
            </a>
            </div>
            </div>
    <?php endforeach; ?>
</div>
    <?php include_once('include/footer.php') ?>
</body>

</html>


<?php

include_once('src/model/connectBdd.php');

// Vérifier si l'id_mercato est présent dans les paramètres GET
if (isset($_GET['id_mercato']) && !empty($_GET['id_mercato'])) {
    // Récupérer l'id_mercato depuis les paramètres GET
    $id_mercato = $_GET['id_mercato'];

    // Requête SQL avec une jointure entre les tables "mercato" et "category"
    $sql = 'SELECT m.*, c.name_category 
            FROM mercato AS m 
            INNER JOIN category AS c ON m.id_category = c.id_category
            WHERE m.id_mercato = :id';

    $stmt_postmercato = $connect->prepare($sql);
    $stmt_postmercato->bindParam(':id', $id_mercato, PDO::PARAM_INT);
    $stmt_postmercato->execute();
    $mercato = $stmt_postmercato->fetch(PDO::FETCH_ASSOC);
  

    if (isset($mercato) && empty($mercato)) {
        header('Location: index.php?action=mercatos');
        exit;
    }    
}

// Requête pour afficher les éléments sans recherche avec pagination
// Sélectionner le nombre total d'enregistrements dans la table "mercato"
$stmt_count = $connect->prepare("SELECT COUNT(*) FROM mercato");
$stmt_count->execute();
$total_rows = $stmt_count->fetchColumn();

// Vérifier si nous avons au moins 3 enregistrements dans la table
if ($total_rows >= 3) {
    // Tant que nous n'avons pas 3 enregistrements uniques, on continue de générer une nouvelle requête
    do {
        // Générer trois IDs aléatoires
        $random_ids = array_rand(range(1, $total_rows), 3);

        // Convertir les IDs en une chaîne pour la clause IN de la requête
        $random_ids_str = implode(',', $random_ids);

        // Sélectionner les enregistrements avec les IDs aléatoires, en limitant à 3 résultats
        $stmt_mercato = $connect->prepare("SELECT id_mercato, image_entete, titre, description, date_mercato
                                          FROM mercato
                                          WHERE id_mercato IN ($random_ids_str)
                                          LIMIT 3");
        $stmt_mercato->execute();
        $all_mercato = $stmt_mercato->fetchAll(PDO::FETCH_ASSOC);
        
        // Répéter la boucle si on n'obtient pas trois enregistrements uniques
    } while (count(array_unique(array_column($all_mercato, 'id_mercato'))) < 3);
} else {
    // Traiter le cas où il y a moins de 3 enregistrements dans la table "mercato"
    // Vous pouvez ajuster cette partie selon vos besoins
    $stmt_mercato = $connect->prepare("SELECT id_mercato, image_entete, titre, description, date_mercato
                                      FROM mercato
                                      LIMIT 3");
    $stmt_mercato->execute();
    $all_mercato = $stmt_mercato->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Gamerush - <?php echo isset($mercato['titre']) ? $mercato['titre'] : 'Titre de la page'; ?></title>
    <link rel="stylesheet" href="assets/css/button-navbar.css">
    <link rel="stylesheet" href="assets/css/gradient-hr.css">
    <?php include_once('include/link.php') ?>
</head>

<body class="bg-color1">
    <?php include_once('include/navbar.php') ?>
    <div class="w-full">
    <hr class="hrgradient w-4/6 m-auto mt-24 md:w-3/6">
        <h2 class="text-color5 text-2xl lg:text-3xl text-center py-8"><?php echo htmlspecialchars($mercato['titre'])?></h2>
    <hr class="hrgradient w-4/6 m-auto mb-16 md:w-3/6">
        <img class="rounded m-auto" src="assets/image/<?php echo htmlspecialchars($mercato['image_entete'])?>">
        <hr class="hrgradient w-4/6 m-auto mt-16 md:w-3/6">
            <h3 class="text-color5 text-center mt-8 lg:mt-12 text-lg lg:text-xl mb-8 lg:mb-12"><?php echo htmlspecialchars($mercato['titre1'])?></h3>
        <hr class="hrgradient w-4/6 m-auto mb-16 md:w-3/6">
        <p class="text-color5 text-center m-auto mb-10 w-10/12 lg:w-8/12 lg:text-lg"><?php echo htmlspecialchars($mercato['text1'])?></p>
        <div class="flex justify-center">
            <?php echo ($mercato['tweet1'])?>
        </div>
        <p class="text-color5 text-center m-auto mt-10 mb-10 w-10/12 lg:w-8/12 lg:text-lg"><?php echo htmlspecialchars($mercato['text2'])?></p>
        <div class="flex justify-center">
            <?php echo ($mercato['tweet2'])?>
        </div>
        <p class="text-color5 text-center m-auto mt-10 mb-10 w-10/12 lg:w-8/12 lg:text-lg"><?php echo htmlspecialchars($mercato['text3'])?></p>
        <hr class="hrgradient w-4/6 m-auto mt-16 md:w-3/6">
            <h3 class="text-color5 text-center mt-8 lg:mt-12 text-lg lg:text-xl mb-8 lg:mb-12"><?php echo htmlspecialchars($mercato['titre2'])?></h3>
        <hr class="hrgradient w-4/6 m-auto mb-16 md:w-3/6">
        <p class="text-color5 text-center m-auto mt-10 mb-10 w-10/12 lg:w-8/12 lg:text-lg"><?php echo htmlspecialchars($mercato['text4'])?></p>
        <div class="flex justify-center">
            <?php echo ($mercato['tweet3'])?>
        </div>
        <p class="text-color5 text-center m-auto mt-10 mb-10 w-10/12 lg:w-8/12 lg:text-lg"><?php echo htmlspecialchars($mercato['conclusion'])?></p>
        
        <p class="text-color5 text-center">Catégorie : <?php echo htmlspecialchars(str_replace('- Mercato', '', $mercato['name_category']))?></p>
    </div>
    <h4 class="text-color5 text-center text-xl mt-12 mb-12">Voici d'autres actualités : </h4>
<div class="contain grid grid-cols-2 gap-8 justify-items-center">
    <?php foreach ($all_mercato as $mercato) : ?>
        <div class="w-5/6 lg:flex">
            <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" style="background-image: url('assets/image/<?php echo htmlspecialchars($mercato['image_entete']); ?>')" title="<?php echo htmlspecialchars($mercato['titre']); ?>">
            </div>
            <div class="max-w-full w-96 border-r border-b border-l border-grey-light lg:border-l-0 lg:border-t lg:border-grey-light bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                <div class="mb-8">
                <div class="text-black font-bold text-xl mb-2"><a href="<?php echo htmlspecialchars('index.php?action=mercato&id_mercato=' . $mercato['id_mercato']); ?>"><?php echo limitText(htmlspecialchars($mercato['titre']), 60); ?></a></div>
                <p class="text-grey-darker text-base">
                <?php echo limitText(htmlspecialchars($mercato['description']), 80); ?></p>
                </div>
                 <div class="text-sm">
                    <p class="text-color1"><?php echo htmlspecialchars($mercato['date_mercato']); ?></p>
                </div>
            </div>
            </div>
    <?php endforeach; ?>
</div>
    <?php include_once('include/footer.php') ?>
</body>

</html>


<?php
include_once('../src/model/connectBdd.php');

if (isset($_POST['request'])) {
    $request = $_POST['request'];

// Assurez-vous que $stmt_filter est correctement défini avec la connexion à la base de données et la requête SQL
$stmt_filter = $connect->prepare("SELECT * FROM actualite WHERE id_category = :request");
$stmt_filter->bindParam(':request', $request);
$stmt_filter->execute();
$all_filter = $stmt_filter->fetchAll(PDO::FETCH_ASSOC);

$stmt_mercato = $connect->prepare("SELECT * FROM mercato WHERE id_category = :request");
$stmt_mercato->bindParam(':request', $request);
$stmt_mercato->execute();
$all_mercato = $stmt_mercato->fetchAll(PDO::FETCH_ASSOC);

// Fonction pour limiter le nombre de caractères en conservant les mots complets
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

    <?php foreach ($all_filter as $filter) : ?>
        <div class="w-5/6 lg:flex">
            <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" style="background-image: url('assets/upload/<?php echo htmlspecialchars($filter['image_entete']); ?>')" title="<?php echo htmlspecialchars($filter['titre_actualite']); ?>">
            </div>
            <div class="max-w-full w-96 border-r border-b border-l border-grey-light lg:border-l-0 lg:border-t lg:border-grey-light bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                <div class="mb-8">
                    <div class="text-black font-bold text-xl mb-2"><a href="<?php echo htmlspecialchars('index.php?action=actualite?id_actualite=' . $filter['id_actualite']); ?>"><?php echo limitText(htmlspecialchars($filter['titre_actualite']),60); ?></a></div>
                    <p class="text-grey-darker text-base"><?php echo limitText(htmlspecialchars($filter['description']),80); ?></p>
                </div>
                <div class="text-sm">
                    <p class="text-color1"><?php echo htmlspecialchars($filter['date_actualite']); ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <?php foreach ($all_mercato as $mercato_filter) : ?>
        <div class="w-5/6 lg:flex">
                    <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" style="background-image: url('assets/upload/<?php echo htmlspecialchars($mercato_filter['image_entete']); ?>')" title="<?php echo htmlspecialchars($mercato_filter['titre']); ?>">
                    </div>
                    <div class="max-w-full w-96 border-r border-b border-l border-grey-light lg:border-l-0 lg:border-t lg:border-grey-light bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                        <div class="mb-8">
                        <div class="text-black font-bold text-xl mb-2"><a href="<?php echo htmlspecialchars('index.php?action=mercato?id_mercato=' . $mercato_filter['id_mercato']); ?>"><?php echo limitText(htmlspecialchars($mercato_filter['titre']),60); ?></a></div>
                            <p class="text-grey-darker text-base"><?php echo limitText(htmlspecialchars($mercato_filter['description']),80); ?></p>
                        </div>
                        <div class="text-sm">
                            <p class="text-color1"><?php echo htmlspecialchars($mercato_filter['date_mercato']); ?></p>
                        </div>
                    </div>
                    </div>
    <?php endforeach; ?>


<?php } ?>

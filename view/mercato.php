<?php

include_once('src/model/connectBdd.php');

// Pagination
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 10;

$offset = ($page - 1) * $limit;

// Requête pour afficher les éléments sans recherche avec pagination
$stmt_mercato = $connect->prepare("SELECT id_mercato, image_entete, titre, description, date_mercato
                                  FROM mercato
                                  LIMIT :limit OFFSET :offset
                                  ");
$stmt_mercato->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt_mercato->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt_mercato->execute();
$all_mercato = $stmt_mercato->fetchAll(PDO::FETCH_ASSOC);

$chemin = 'assets/image/'; // The path to the images directory

// Initialiser la variable $show_error
$show_error = false;

// Variable pour déterminer si la pagination doit être affichée
$show_pagination = true;

// Initialiser la variable $search_no_results
$search_no_results = false;

// Traitement de la recherche
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['csrf_token']) && hash_equals($_POST['csrf_token'], $_SESSION['csrf_token'])) {
        $recherche = trim($_POST['s']);
        // Vérifier si la recherche contient au moins 4 caractères
        if (strlen($recherche) >= 4) {
            // Use prepared statement with named placeholders
            $stmt_recherche = $connect->prepare('SELECT * FROM mercato WHERE titre LIKE :search_term OR description LIKE :search_term ORDER BY id_mercato DESC');
            $search_term = '%' . $recherche . '%';
            $stmt_recherche->bindValue(':search_term', $search_term, PDO::PARAM_STR);
            $stmt_recherche->execute();
            $search_results = $stmt_recherche->fetchAll(PDO::FETCH_ASSOC);

            // Masquer la pagination lorsque des résultats de recherche sont trouvés
            $show_pagination = false;

            // Vérifier si aucun résultat n'a été trouvé
            if (count($search_results) === 0) {
                $search_no_results = true;
            }
        } else {
            // Afficher l'erreur dans la pop-up
            $show_error = true;
        }
    } else {
        // CSRF token mismatch or missing, handle the error (e.g., redirect to an error page or log it)
        exit('Invalid CSRF token');
    }
}

try{
    $stmt = $connect->prepare("SELECT id_category, name_category FROM category");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

?>

<!doctype html>

<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Titre de la page</title>
    <link rel="stylesheet" href="assets/css/button-navbar.css">
    <?php include_once('include/link.php') ?>
</head>

<body class="bg-color1">
<?php include_once('include/navbar.php') ?>

<div class="flex items-center justify-center my-28">
    <div class="relative">
        <form action="" method="POST">
        <?php
        $csrf_token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrf_token;
        ?>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="search" name="s" class="py-2 pl-10 pr-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Rechercher...">
            <span class="absolute inset-y-0 left-3 flex items-center">
                <button type="submit" class="cursor-pointer">
                     <i class="fas fa-search text-gray-500"></i>
                 </button>
             </span>
        </form>
    </div>
</div>

<!-- <form action="src/model/mercato-filter.php" method="">
    <label for="category">Filtrer par catégorie:</label>
    <select name="category" id="category">
        <option value="">Toutes les catégories</option>
        <?php
        foreach ($categories as $category) {
            echo "<option value='{$category['id_category']}'>{$category['name_category']}</option>";
        }
        ?>
    </select>
    <button type="submit">Filtrer</button>
</form> -->

    <!-- Afficher la pop-up d'erreur -->
    <div id="errorPopup" class="hidden fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-8 rounded-lg">
            <p>La recherche doit contenir au moins 4 caractères.</p>
            <button id="closeBtn" class="mt-4 px-4 py-2 bg-gray-700 text-white rounded-lg">Fermer</button>
        </div>
    </div>


    <!-- Votre formulaire de recherche ici -->

<div id="searchResults" class="grid grid-cols-2 gap-8 justify-items-center">
    <?php if (isset($search_results) && !empty($search_results)) : ?>
    <?php foreach ($search_results as $index => $result) : ?>
        <div class="w-2/3 lg:flex">
                    <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" style="background-image: url('assets/image/<?php echo htmlspecialchars($result['image_entete']); ?>')" title="<?php echo htmlspecialchars($result['titre']);?>">
                    </div>
                    <div class="max-w-full w-96 border-r border-b border-l border-grey-light lg:border-l-0 lg:border-t lg:border-grey-light bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                        <div class="mb-8">
                        <div class="text-black font-bold text-xl mb-2"><a href="<?php echo htmlspecialchars('index.php?mercato.php?id=' . $result['id_mercato']); ?>"><?php echo htmlspecialchars($result['titre']); ?></a></div>
                            <p class="text-grey-darker text-base"><?php echo htmlspecialchars($result['description']); ?></p>
                        </div>
                        <div class="text-sm">
                            <p class="text-color1"><?php echo htmlspecialchars($result['date_mercato']); ?></p>
                        </div>
                    </div>
                    </div>
            <?php endforeach; ?>
        <?php elseif ($search_no_results) : ?>
            <div id="notFoundPopup" class="hidden fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
                <div class="bg-white p-8 rounded-lg">
                    <p>Aucun résultat trouvé pour votre recherche.</p>
                    <button id="closeBtnNotFound" class="mt-4 px-4 py-2 bg-gray-700 text-white rounded-lg">Fermer</button>
                </div>
            </div>

        <?php else : ?>
            <?php foreach ($all_mercato as $mercato) : ?>
                <div class="w-5/6 lg:flex">
                    <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" style="background-image: url('assets/image/<?php echo htmlspecialchars($mercato['image_entete']); ?>')" title="<?php echo htmlspecialchars($mercato['titre']); ?>">
                    </div>
                    <div class="max-w-full w-96 border-r border-b border-l border-grey-light lg:border-l-0 lg:border-t lg:border-grey-light bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                        <div class="mb-8">
                        <div class="text-black font-bold text-xl mb-2"><a href="<?php echo htmlspecialchars('index.php?mercato.php?id=' . $mercato['id_mercato']); ?>"><?php echo htmlspecialchars($mercato['titre']); ?></a></div>
                            <p class="text-grey-darker text-base"><?php echo htmlspecialchars($mercato['description']); ?></p>
                        </div>
                        <div class="text-sm">
                            <p class="text-color1"><?php echo htmlspecialchars($mercato['date_mercato']); ?></p>
                        </div>
                    </div>
                    </div>
            <?php endforeach; ?>
        <?php endif; ?>
</div>

    <?php if ($show_pagination) : ?>
        <div class="flex justify-center mt-8">
            <?php
            // Calculer le nombre total de pages
            $stmt_count = $connect->prepare("SELECT COUNT(*) FROM mercato");
            $stmt_count->execute();
            $total_rows = $stmt_count->fetchColumn();
            $total_pages = ceil($total_rows / $limit);

            // Afficher les boutons de pagination
            for ($i = 1; $i <= $total_pages; $i++) {
                $active_class = ($i === $page) ? "bg-blue-500 text-white" : "bg-white text-blue-500";
                echo '<a href="index.php?action=mercato&page=' . $i . '" class="px-4 py-2 mx-1 rounded-lg cursor-pointer ' . $active_class . '">' . $i . '</a>';
            }
            ?>
        </div>
    <?php endif; ?>

<?php include_once('include/footer.php') ?>

<script>
    // Afficher la pop-up si l'erreur doit être montrée
    <?php if ($show_error) : ?>
        document.getElementById('errorPopup').classList.remove('hidden');
    <?php endif; ?>

    // Cacher la pop-up lorsque le bouton "Fermer" est cliqué
    document.getElementById('closeBtn').addEventListener('click', function() {
        document.getElementById('errorPopup').classList.add('hidden');
    });
</script>

<script>
    // Afficher la pop-up si l'erreur doit être montrée
    <?php if ($search_no_results) : ?>
        document.getElementById('notFoundPopup').classList.remove('hidden');
    <?php endif; ?>

    // Cacher la pop-up lorsque le bouton "Fermer" est cliqué
    document.getElementById('closeBtnNotFound').addEventListener('click', function() {
        document.getElementById('notFoundPopup').classList.add('hidden');
    });
</script>

</body>

</html>
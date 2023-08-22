<?php

include_once('src/model/connectBdd.php');

// Pagination
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header("Location: index.php?action=actualites");
    exit();
}

$limit = 10;
$offset = ($page - 1) * $limit;

// Requête pour afficher les éléments sans recherche avec pagination
$stmt_actualite = $connect->prepare("SELECT id_actualite, image_entete, titre_actualite, description, date_actualite
                                  FROM actualite
                                  ORDER BY id_actualite DESC
                                  LIMIT :limit OFFSET :offset
                                  ");
$stmt_actualite->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt_actualite->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt_actualite->execute();
$all_actualite = $stmt_actualite->fetchAll(PDO::FETCH_ASSOC);

$stmt_count = $connect->prepare("SELECT COUNT(*) FROM actualite");
$stmt_count->execute();
$total_rows = $stmt_count->fetchColumn();
$total_pages = ceil($total_rows / $limit);

// Ensure page number is not greater than the total number of pages
if ($page > $total_pages && $total_pages > 0) {
    header("Location: index.php?action=actualites&page=" . $total_pages);
    exit();
}

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
            $stmt_recherche = $connect->prepare('SELECT * FROM actualite WHERE titre_actualite LIKE :search_term OR description LIKE :search_term ORDER BY id_actualite DESC');
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

$stmt_filter = $connect->prepare("SELECT id_category, name_category
                                  FROM category
                                  WHERE type = 'actualite'
                                  ");
$stmt_filter->execute();
$all_filter = $stmt_filter->fetchAll(PDO::FETCH_ASSOC);

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

<!doctype html>

<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Titre de la page</title>
    <link rel="stylesheet" href="assets/css/button-navbar.css">
    <link rel="stylesheet" href="assets/css/button-twitch.css">
    <?php include_once('include/link.php') ?>
</head>

<body class="bg-gradient-to-b from-color1 to-black">
<?php include_once('include/navbar.php') ?>

<div class="flex my-28 flex-col lg:flex-row justify-evenly">
    <div class="flex items-center mb-8 lg:mb-0 justify-center">
        <div class="relative">
            <form action="" method="POST">
            <?php
            $csrf_token = bin2hex(random_bytes(32));
            $_SESSION['csrf_token'] = $csrf_token;
            ?>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="search" name="s" class="pl-10 w-fit m-auto flex justify-center bg-transparent text-color5 font-semibold hover:text-white py-2 px-4 border border-color3 focus:border-color5 hover:border-orange-600 transition ease-in-out duration-300 ring-yellow-500 rounded" placeholder="Rechercher...">
                <span class="absolute inset-y-0 left-3 flex items-center">
                    <button type="submit" class="cursor-pointer">
                        <i class="fas fa-search text-gray-500"></i>
                    </button>
                </span>
            </form>
        </div>
    </div>

    <div id="filters">
        <select class="w-fit m-auto flex justify-center bg-transparent text-color5 font-semibold hover:text-white py-2 px-4 border border-color3 focus:border-color5 hover:border-orange-600 transition ease-in-out duration-300 ring-yellow-500 rounded" name="fetchval" id="fetchval">
            <option class="bg-red-500" value="" selected="">Toutes les catégories</option>
            <?php foreach ($all_filter as $filter) : ?>
            <option value="<?php echo htmlspecialchars($filter['id_category'])?>"><?php echo htmlspecialchars($filter['name_category'])?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button class="text-color5 hidden" id="btnClearCategories">Supprimer le filtre</button>
</div>

    <!-- Afficher la pop-up d'erreur -->
    <div id="errorPopup" class="hidden fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-8 rounded-lg">
            <p>La recherche doit contenir au moins 4 caractères.</p>
            <button id="closeBtn" class="mt-4 px-4 py-2 bg-gray-700 text-white rounded-lg">Fermer</button>
        </div>
    </div>


    <!-- Votre formulaire de recherche ici -->

<div id="searchResults" class="contain grid grid-cols-2 gap-2 sm:gap-8 justify-items-center">
    <?php if (isset($search_results) && !empty($search_results)) : ?>
    <?php foreach ($search_results as $index => $result) : ?>
        <div class="w-11/12 lg:w-5/6 lg:flex">
                    <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover lg:rounded-tl lg:rounded-l text-center overflow-hidden" style="background-image: url('assets/upload/<?php echo htmlspecialchars($result['image_entete']); ?>')" title="<?php echo htmlspecialchars($result['titre_actualite']);?>">
                    </div>
                    <a href="<?php echo htmlspecialchars('index.php?action=actualite&id_actualite=' . $result['id_actualite']); ?>">
                    <div class="max-w-full w-full border-r border-b border-l border-grey-light lg:border-l-0 lg:border-t lg:border-grey-light bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                        <div class="mb-8">
                        <div class="text-black font-bold text-xl mb-2"><?php echo limitText(htmlspecialchars($result['titre_actualite']),60); ?></div>
                            <p class="text-grey-darker text-base hidden lg:block"><?php echo limitText(htmlspecialchars($result['description']),80); ?></p>
                        </div>
                        <div class="text-sm">
                            <p class="text-color1"><?php echo htmlspecialchars($result['date_actualite']); ?></p>
                        </div>
                    </a>
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
            <?php foreach ($all_actualite as $actualite) : ?>
                <div class="w-11/12 lg:w-5/6 lg:flex">
                    <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover lg:rounded-tl lg:rounded-l text-center overflow-hidden" style="background-image: url('assets/upload/<?php echo htmlspecialchars($actualite['image_entete']); ?>')" title="<?php echo htmlspecialchars($actualite['titre_actualite']); ?>">
                    </div>
                    <a href="<?php echo htmlspecialchars('index.php?action=actualite&id_actualite=' . $actualite['id_actualite']); ?>">
                    <div class="max-w-full w-full border-r border-b border-l border-grey-light lg:border-l-0 lg:border-t lg:border-grey-light bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                        <div class="mb-8">
                        <div class="text-black font-medium lg:font-bold text-lg lg:text-xl mb-2"><?php echo limitText(htmlspecialchars($actualite['titre_actualite']),60); ?></div>
                            <p class="text-grey-darker text-base hidden lg:block"><?php echo limitText(htmlspecialchars($actualite['description']),80); ?></p>
                        </div>
                        <div class="text-sm">
                            <p class="text-color1"><?php echo htmlspecialchars($actualite['date_actualite']); ?></p>
                        </div>
                        </a>
                    </div>
                    </div>
            <?php endforeach; ?>
        <?php endif; ?>
</div>

    <?php if ($show_pagination) : ?>
        <div class="flex justify-center mt-8">
            <?php
            // Calculer le nombre total de pages
            $stmt_count = $connect->prepare("SELECT COUNT(*) FROM actualite");
            $stmt_count->execute();
            $total_rows = $stmt_count->fetchColumn();
            $total_pages = ceil($total_rows / $limit);

            // Afficher les boutons de pagination
            for ($i = 1; $i <= $total_pages; $i++) {
                $active_class = ($i === $page) ? "" : "";
                echo '<a href="index.php?action=actualites&page=' . $i . '" class="w-fit flex justify-center button-twitch bg-transparent text-color5 font-semibold hover:text-color4 mx-4 py-2 px-4 border border-rose hover:border-transparent rounded mt-8 mb-12 ' . $active_class . '">' . '<p class="z-10">' .$i .'</p>'.'</a>';
            }
            ?>
        </div>
    <?php endif; ?>

<?php include_once('include/footer.php') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script>
    // Fonction pour enlever le terme "Mercato" du texte des options
    function updateFilterText() {
        const selectElement = document.getElementById('fetchval');
        const options = selectElement.options;

        for (let i = 0; i < options.length; i++) {
            const originalText = options[i].textContent;
            options[i].textContent = originalText.replace(' - Actualité', '');
        }
    }

    // Appeler la fonction pour mettre à jour le texte initial
    updateFilterText();
</script>

<script>
    $(document).ready(function () {
        // Écoute du changement de valeur dans le sélecteur de catégories
        $("#fetchval").on('change', function () {
            var value = $(this).val();

            // Si l'option par défaut est sélectionnée, effectuer la redirection vers actualités.php
            if (value === "") {
                window.location.href = "index.php?action=actualites";
            } else {
                // Sinon, faire la requête AJAX pour rafraîchir la liste des résultats en fonction de la catégorie sélectionnée
                $.ajax({
                    type: "POST",
                    url: "view/fetch.php",
                    data: { request: value }, // Passer la valeur de la catégorie sélectionnée dans la requête
                    success: function (data) {
                        // Mettre à jour la liste des résultats avec les données reçues du serveur
                        $(".contain").html(data);
                    },
                    error: function (xhr, status, error) {
                        // Gérer les erreurs si nécessaire
                        console.error("Une erreur s'est produite lors de la requête AJAX.");
                    }
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        // Écoute du changement de sélection dans le sélecteur
        $("#fetchval").change(function () {
            // Vérifier si une option est sélectionnée
            if ($("#fetchval").val() === "") {
                // Aucune catégorie sélectionnée, masquer le bouton "Supprimer le filtre"
                $("#btnClearCategories").hide();
            } else {
                // Une catégorie est sélectionnée, afficher le bouton "Supprimer le filtre" s'il était masqué
                $("#btnClearCategories").show();
            }
        });

        // Écoute du clic sur le bouton "Supprimer le filtre"
        $("#btnClearCategories").click(function () {
            // Supprimer la sélection en définissant la valeur du sélecteur sur une option vide
            $("#fetchval").val("");

            // Rediriger l'utilisateur vers la page mercato.php
            window.location.href = "index.php?action=actualites";
        });
    });
</script>

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
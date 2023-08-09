<?php

include_once('src/model/connectBdd.php');

// Pagination
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 9;

$offset = ($page - 1) * $limit;

// Requête pour afficher les éléments sans recherche avec pagination
$stmt_galerie = $connect->prepare("SELECT id_galerieimg, img_photo, nom_photo, mot_clé
                                  FROM galerie
                                  LIMIT :limit OFFSET :offset
                                  ");
$stmt_galerie->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt_galerie->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt_galerie->execute();
$all_galerie = $stmt_galerie->fetchAll(PDO::FETCH_ASSOC);

$chemin = 'assets/upload/'; // Removed htmlspecialchars for this variable

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
            $stmt_recherche = $connect->prepare('SELECT * FROM galerie WHERE nom_photo LIKE :search_term OR mot_clé LIKE :search_term ORDER BY id_galerieimg DESC');
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

?>


<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Titre de la page</title>
    <link rel="stylesheet" href="assets/css/button-navbar.css">
    <link rel="stylesheet" href="assets/css/button-twitch.css">
    <link rel="stylesheet" href="assets/css/animation-galerie.css">
    <?php include_once('include/link.php') ?>
</head>

<body class="bg-gradient-to-b from-color1 to-black">
    <?php include_once('include/navbar.php') ?>

    <div class="flex items-center justify-center my-28">
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

    <!-- Afficher la pop-up d'erreur -->
    <div id="errorPopup" class="hidden fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-8 rounded-lg">
            <p>La recherche doit contenir au moins 4 caractères.</p>
            <button id="closeBtn" class="mt-4 px-4 py-2 bg-gray-700 text-white rounded-lg">Fermer</button>
        </div>
    </div>


    <!-- Votre formulaire de recherche ici -->

    <div id="searchResults" class="grid grid-cols-2 gap-8 justify-items-center lg:grid-cols-3">
        <?php if (isset($search_results) && !empty($search_results)) : ?>
            <?php foreach ($search_results as $index => $result) : ?>
                <div class="anim-galerie items flex flex-col items-center slide-in">
                    <img class="object-cover w-60 h-48 md:w-80 md:h-72 lg:w-96 lg:h-80 hover:cursor-pointer mb-4 rounded" src="<?php echo htmlspecialchars($chemin)?><?php echo htmlspecialchars($result['img_photo']); ?>" onclick="openImage('assets/upload/<?php echo htmlspecialchars($result['img_photo']); ?>')" />
                    <a href="<?php echo htmlspecialchars($chemin)?><?php echo htmlspecialchars($result['img_photo']); ?>" download="<?php echo htmlspecialchars($result['nom_photo']); ?>.jpg" class="w-5/6 lg:w-2/3 px-4 py-3 bg-blue-600 hover:bg-blue-800 transition duration-300 rounded-md text-white outline-none focus:ring-4 shadow-lg mx-5 flex">
                        <span class="m-auto">Télécharger</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </a>
                    <h3 class="text-color4 text-md md:text-lg"><?php echo htmlspecialchars($result['nom_photo']); ?></h3>
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
            <?php foreach ($all_galerie as $galerie) : ?>
                <div class="anim-galerie items flex flex-col items-center slide-in">
                    <img class="object-cover w-60 h-48 md:w-80 md:h-72 lg:w-96 lg:h-80 hover:cursor-pointer mb-4 rounded" src="<?php echo htmlspecialchars($chemin)?><?php echo htmlspecialchars($galerie['img_photo']); ?>" onclick="openImage('assets/upload/<?php echo htmlspecialchars($galerie['img_photo']); ?>')" />
                    <a href="<?php echo htmlspecialchars($chemin)?><?php echo htmlspecialchars($galerie['img_photo']); ?>" download="<?php echo htmlspecialchars($galerie['nom_photo']); ?>.jpg" class="w-5/6 lg:w-2/3 px-4 py-3 bg-blue-600 hover:bg-blue-800 transition duration-300 rounded-md text-white outline-none focus:ring-4 shadow-lg mx-5 flex">
                        <span class="m-auto">Télécharger</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </a>
                    <h3 class="text-color4 text-md md:text-lg"><?php echo htmlspecialchars($galerie['nom_photo']); ?></h3>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if ($show_pagination) : ?>
        <div class="flex justify-center mt-8">
            <?php
            // Calculer le nombre total de pages
            $stmt_count = $connect->prepare("SELECT COUNT(*) FROM galerie");
            $stmt_count->execute();
            $total_rows = $stmt_count->fetchColumn();
            $total_pages = ceil($total_rows / $limit);

            // Afficher les boutons de pagination
            for ($i = 1; $i <= $total_pages; $i++) {
                $active_class = ($i === $page) ? "" : "";
                echo '<a href="index.php?action=galerie&page=' . $i . '" class="w-fit flex justify-center button-twitch bg-transparent text-color5 font-semibold hover:text-color4 mx-4 py-2 px-4 border border-rose hover:border-transparent rounded mt-8 mb-12 ' . $active_class . '">' . '<p class="z-10">' .$i .'</p>'.'</a>';
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

<script>
        function openImage(imagePath) {
            // Ouvrir une nouvelle page avec l'image en grand format
            window.open(imagePath, "_blank");
        }
</script>

<script>
    function fadeInWhenVisible() {
        const items = document.querySelectorAll('.anim-galerie');
        items.forEach(item => {
            const rect = item.getBoundingClientRect();
            const windowHeight = window.innerHeight;
            if (rect.top < windowHeight) {
                item.classList.add('fade-in');
            }
        });
    }

    fadeInWhenVisible(); // Appeler la fonction initialement

    // Ajouter un événement de défilement pour détecter quand l'utilisateur voit l'élément
    window.addEventListener('scroll', fadeInWhenVisible);
</script>


<script>
  let currentPage = <?php echo $page; ?>;
  let isLoading = false;

  function loadResults() {
    isLoading = true;
    $.ajax({
      url: '<?php echo $_SERVER['PHP_SELF']; ?>',
      type: 'GET',
      data: {
        s: '<?php echo isset($_GET['s']) ? $_GET['s'] : ''; ?>',
        page: currentPage + 1
      },
      dataType: 'json',
      success: function (data) {
        if (data && data.length > 0) {
          let resultHtml = '';
          for (let i = 0; i < data.length; i++) {
            resultHtml += '<div class="item flex flex-col items-center">';
            // Ajouter le reste du code HTML pour afficher les résultats de recherche ici
            // ...
            resultHtml += '</div>';
          }
          $('#searchResults').append(resultHtml);
          currentPage++;
          isLoading = false;
        }
      },
      error: function () {
        isLoading = false;
      }
    });
  }

  // Fonction pour détecter le défilement de la page
  $(window).scroll(function () {
    if ($(window).scrollTop() >= $(document).height() - $(window).height() - 200 && !isLoading) {
      loadResults();
    }
  });

  // Charger les résultats de recherche initiaux
  loadResults();
</script>


</body>

</html>

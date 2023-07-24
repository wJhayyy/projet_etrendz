<?php

include_once('src/model/connectBdd.php');

include_once('src/model/connectBdd.php');

// Pagination
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Récupérer le numéro de la page à partir des paramètres d'URL
$limit = 9; // Nombre d'éléments à afficher par page

$offset = ($page - 1) * $limit; // Calculer l'offset pour la clause LIMIT

// Requête pour afficher les éléments sans recherche avec pagination
$stmt_galerie = $connect->prepare("SELECT id_galerieimg, img_photo, nom_photo, description_photo
                                  FROM galerie
                                  LIMIT :limit OFFSET :offset
                                  ");
$stmt_galerie->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt_galerie->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt_galerie->execute();
$all_galerie = $stmt_galerie->fetchAll(PDO::FETCH_ASSOC);

// Initialiser la variable $show_error
$show_error = false;

// Variable pour déterminer si la pagination doit être affichée
$show_pagination = true;

// Traitement de la recherche
if (isset($_POST['s']) && !empty($_POST['s'])) {
    $recherche = htmlspecialchars($_POST['s']);

    // Vérifier si la recherche contient au moins 4 caractères
    if (strlen($recherche) >= 4) {
        $stmt_recherche = $connect->prepare('SELECT * FROM galerie WHERE nom_photo LIKE ? OR description_photo LIKE ? ORDER BY id_galerieimg DESC');
        $search_term = '%' . $recherche . '%';
        $stmt_recherche->execute([$search_term, $search_term]);
        $search_results = $stmt_recherche->fetchAll(PDO::FETCH_ASSOC);

        // Masquer la pagination lorsque des résultats de recherche sont trouvés
        $show_pagination = false;
    } else {
        // Afficher l'erreur dans la pop-up
        $show_error = true;
    }
}

?>


<!doctype html>

<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Titre de la page</title>
  <link rel="stylesheet" href="assets/css/button-navbar.css">
  <?php include_once('include/link.php')?>
</head>

<body class="bg-color1">
<?php include_once('include/navbar.php')?>

<div class="flex items-center justify-center my-28">
    <div class="relative">
        <form action="" method="POST">
            <input type="search" name="s" class="py-2 pl-10 pr-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Rechercher...">
            <span class="absolute inset-y-0 left-3 flex items-center">
                <button type="submit" class="cursor-pointer">
                    <i class="fas fa-search text-gray-500"></i>
                </button>
            </span>
        </form>
    </div>
</div>

<!-- Afficher la pop-up d'erreur -->
<div id="errorPopup" class="hidden fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-8 rounded-lg">
        <p>La recherche doit contenir au moins 4 caractères.</p>
        <button id="closeBtn" class="mt-4 px-4 py-2 bg-gray-700 text-white rounded-lg">Fermer</button>
    </div>
</div>


<!-- Votre formulaire de recherche ici -->

<div id="searchResults" class="grid grid-cols-2 gap-8 justify-items-center lg:grid-cols-3">
    <?php if (isset($search_results) && !empty($search_results)) : ?>
        <?php foreach ($search_results as $result) : ?>
            <!-- Afficher les images correspondantes à la recherche ici -->
            <div class="item flex flex-col items-center">
                <img class="w-5/6 lg:w-2/3 hover:cursor-pointer mb-4 rounded" src="assets/image/<?php echo $result['img_photo']; ?>" onclick="openImage('assets/image/<?php echo $result['img_photo']; ?>')" />
                <a 
                href="assets/image/<?php echo $result['img_photo']; ?>"
                download="<?php echo $result['nom_photo']; ?>.jpg"
                class="w-5/6 lg:w-2/3 px-4 py-3 bg-green-600 hover:bg-green-800 transition duration-300 rounded-md text-white outline-none focus:ring-4 shadow-lg mx-5 flex"
                >
                    <span class="m-auto">Télécharger</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                </a>
                <h3 class="text-color4"><?php echo $result['nom_photo']; ?></h3>
            </div>
        <?php endforeach; ?>
        <!-- Aucun résultat de recherche -->
        <p>Aucun résultat trouvé pour votre recherche.</p>
    <?php endif; ?>
    
    <?php if (!isset($search_results) || empty($search_results)) : ?>
        <?php foreach ($all_galerie as $galerie) : ?>
            <!-- Afficher les images sans recherche ici -->
            <div class="item flex flex-col items-center">
                <img class="w-5/6 lg:w-2/3 hover:cursor-pointer mb-4 rounded" src="assets/image/<?php echo $galerie['img_photo']; ?>" onclick="openImage('assets/image/<?php echo $galerie['img_photo']; ?>')" />
                <a 
                href="assets/image/<?php echo $galerie['img_photo']; ?>"
                download="<?php echo $galerie['nom_photo']; ?>.jpg"
                class="w-5/6 lg:w-2/3 px-4 py-3 bg-green-600 hover:bg-green-800 transition duration-300 rounded-md text-white outline-none focus:ring-4 shadow-lg mx-5 flex"
                >
                    <span class="m-auto">Télécharger</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                </a>
                <h3 class="text-color4"><?php echo $galerie['nom_photo']; ?></h3>
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
            $active_class = ($i === $page) ? "bg-blue-500 text-white" : "bg-white text-blue-500";
            echo '<a href="index.php?action=galerie&page=' . $i . '" class="px-4 py-2 mx-1 rounded-lg cursor-pointer ' . $active_class . '">' . $i . '</a>';
        }
        ?>
    </div>
<?php endif; ?>

<?php include_once('include/footer.php')?>
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
        function openImage(imagePath) {
            // Ouvrir une nouvelle page avec l'image en grand format
            window.open(imagePath, "_blank");
        }
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

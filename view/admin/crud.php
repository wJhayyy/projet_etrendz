<?php 

include_once('src/model/connectBdd.php');

$stmt_actualite = $connect->prepare('SELECT actualite.*, category.name_category
                                    FROM actualite
                                    INNER JOIN category ON actualite.id_category = category.id_category');
$stmt_actualite->execute();
$all_actualite = $stmt_actualite->fetchAll(PDO::FETCH_ASSOC);

$stmt_mercato = $connect->prepare('SELECT mercato.*, category.name_category
                                    FROM mercato
                                    INNER JOIN category ON mercato.id_category= category.id_category');
$stmt_mercato->execute();
$all_mercato = $stmt_mercato->fetchAll(PDO::FETCH_ASSOC);


$stmt_galerie = $connect->prepare('SELECT * FROM galerie');
$stmt_galerie->execute();
$all_galerie = $stmt_galerie->fetchAll(PDO::FETCH_ASSOC);

$stmt_category = $connect->prepare('SELECT * FROM category');
$stmt_category->execute();
$all_category = $stmt_category->fetchAll(PDO::FETCH_ASSOC);

$stmt_user = $connect->prepare('SELECT users.*, roles.role
                                FROM users
                                INNER JOIN roles ON users.id_role = roles.id_role');
$stmt_user->execute();
$all_user = $stmt_user->fetchAll(PDO::FETCH_ASSOC);

if (!isset($_SESSION['id_role'])) {
    // Rediriger vers la page de connexion si l'id_role n'est pas défini dans la session
    header("Location: index.php"); // Remplacez "login.php" par le chemin de votre page de connexion
    exit();
}

$id_role = $_SESSION['id_role']; // Récupérez l'id_role depuis la session

if ($id_role <= 1) {
    // Rediriger vers la page d'accueil si le rôle n'est pas supérieur à 1
    header("Location: index.php");
    exit();
}

?>

<!doctype html>

<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Titre de la page</title>
  <link rel="stylesheet" href="assets/css/button-twitch.css">
  <!-- dataTables -->
  <link href="DataTables/datatables.min.css" rel="stylesheet">

<?php  include_once('view/include/link.php');?>
</head>

<style>
    .striped-table tr:nth-child(even) {
    background-color: #212121; /* Replace this color with your desired lighter color */
}
</style>

<body class="bg-gradient-to-b from-color1 to-black">
<?php include_once('view/include/navbar.php');?>
<br class="mt-28">

<div class="w-full lg:w-1/2 m-auto flex justify-center">

<?php
if ($_SESSION['id_role'] === 3 || $_SESSION['id_role'] === 4 || $_SESSION['id_role'] === 6) {
?>
    <button onclick="openTab(event, 'tab1')" class="w-fit button-twitch bg-transparent text-color5 font-semibold hover:text-white py-2 px-4 border border-rose hover:border-transparent rounded mt-8 mr-4 focus:outline-none">
        <p class="z-10 relative">Gestion Actualité</p>
    </button>
    <button onclick="openTab(event, 'tab2')" class="w-fit button-twitch bg-transparent text-color5 font-semibold hover:text-white py-2 px-4 border border-rose hover:border-transparent rounded mt-8 mr-4 focus:outline-none">
        <p class="z-10 relative">Gestion Mercato</p>
    </button>
    <?php
}
?>

<?php
if ($_SESSION['id_role'] === 3 || $_SESSION['id_role'] === 5) {
?>

    <button onclick="openTab(event, 'tab3')" class="w-fit button-twitch bg-transparent text-color5 font-semibold hover:text-white py-2 px-4 border border-rose hover:border-transparent rounded mt-8 focus:outline-none">
        <p class="z-10 relative">Gestion Galerie</p>
    </button>
    <?php
}
?>

</div>

<?php
if ($_SESSION['id_role'] === 3) {
?>
<div class="w-full lg:w-1/2 m-auto flex justify-center mb-12">
    <button onclick="openTab(event, 'tab4')" class="w-fit button-twitch bg-transparent text-color5 font-semibold hover:text-white py-2 px-4 border border-rose hover:border-transparent rounded mt-8 mr-4 focus:outline-none">
        <p class="z-10 relative">Gestion Catégorie</p>
    </button>
    <button onclick="openTab(event, 'tab5')" class="w-fit button-twitch bg-transparent text-color5 font-semibold hover:text-white py-2 px-4 border border-rose hover:border-transparent rounded mt-8 mr-4 focus:outline-none">
        <p class="z-10 relative">Gestion Users</p>
    </button>
    <!-- <button onclick="openTab(event, 'tab6')" class="w-fit button-twitch bg-transparent text-color5 font-semibold hover:text-white py-2 px-4 border border-rose hover:border-transparent rounded mt-8 focus:outline-none">
        <p class="z-10 relative">Gestion Boutique</p>
    </button> -->
</div>
<?php
}
?>

<div id="tab1" class="bg-colorcrud tab-content text-color5 p-4">
    <div class="flex justify-end mb-2">
        <a href="index.php?admin=ajoutActu" class="relative inline-flex items-center justify-center p-0.5 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-blue-400 to-blue-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-green-200">
            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                Ajouter une actualité
            </span>
        </a>
    </div>
    <table id="myActualite" class="display striped-table">
      <thead>
          <tr class="text-color5">
              <th>Id</th>
              <th>Titre</th>
              <th>Image 1</th>
              <th>Image 2</th>
              <th>Catégorie</th>
              <th>Date</th>
              <th>Action</th>
          </tr>
      </thead>
      <tbody>
          <tr>
            <?php foreach($all_actualite as $actualite) :?>
            <td class="text-color5"><?php echo htmlspecialchars($actualite['id_actualite'])?></td>
            <td class="text-color5"><?php echo htmlspecialchars($actualite['titre_actualite'])?></td>
            <td class="text-color5"><img src="assets/upload/<?php echo htmlspecialchars($actualite['image1'])?>" alt="Image 1" width="150px"></td>
            <td class="text-color5"><img src="assets/upload/<?php echo htmlspecialchars($actualite['image2'])?>" alt="Image 2" width="150px"></td>
            <td class="text-color5"><?php echo htmlspecialchars(str_replace(' - Actualité', '', $actualite['name_category']))?></td>
            <td class="text-color5"><?php echo htmlspecialchars($actualite['date_actualite'])?></td>
            <td class="flex flex-row justify-center items-center h-20">
            <form class="w-fit" method="post" action="index.php?admin=modifyActu">
                <input type="hidden" name="id_actualite" value="<?php echo htmlspecialchars($actualite['id_actualite'])?>">
                <button class="h-1/2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Modifier</button>
            </form>
            <form class="w-fit">
            <button class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded delete-button"
            data-category="actu"
            data-id="<?php echo htmlspecialchars($actualite['id_actualite'])?>">Supprimer</button>
            </form>
            </td>
          </tr>
          <?php endforeach;?>
    </tbody>
  </table>
</div>

<br>

<div id="tab2" class="bg-colorcrud tab-content hidden text-color5 p-4">
    <div class="flex justify-end mb-2">
        <a href="index.php?admin=ajoutMercato" class="relative inline-flex items-center justify-center p-0.5 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-blue-400 to-blue-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-green-200">
            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                Ajouter un article mercato
            </span>
        </a>
    </div>
    <table id="myMercato" class="display striped-table">
      <thead>
          <tr class="text-color5">
              <th>Id</th>
              <th>Titre</th>
              <th>Image Entete</th>
              <th>Catégorie</th>
              <th>Date</th>
              <th>Action</th>
          </tr>
      </thead>
      <tbody>
          <tr>
          <?php foreach($all_mercato as $mercato) :?>
            <td class="text-color5"><?php echo htmlspecialchars($mercato['id_mercato'])?></td>
            <td class="text-color5"><?php echo htmlspecialchars($mercato['titre'])?></td>
            <td class="text-color5"><img src="assets/upload/<?php echo htmlspecialchars($mercato['image_entete'])?>" alt="Image 2" width="150px"></td>
            <td class="text-color5"><?php echo htmlspecialchars(str_replace(' - Mercato', '', $mercato['name_category']))?></td>
            <td class="text-color5"><?php echo htmlspecialchars($mercato['date_mercato'])?></td>
            <td class="flex flex-row justify-center items-center h-20">
            <form class="w-fit" method="post" action="index.php?admin=modifyMercato">
                <input type="hidden" name="id_mercato" value="<?php echo htmlspecialchars($mercato['id_mercato'])?>">
                <button class="h-1/2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Modifier</button>
            </form>
            <form class="w-fit">
            <button class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded delete-button"
            data-category="mercato"
            data-id="<?php echo htmlspecialchars($mercato['id_mercato'])?>">Supprimer</button>
            </form>
            </td>
          </tr>
          <?php endforeach;?>
    </tbody>
  </table>
</div>

<div id="tab3" class="bg-colorcrud tab-content hidden text-color5 p-4">
    <div class="flex justify-end mb-2">
        <a href="index.php?admin=ajoutGalerie" class="relative inline-flex items-center justify-center p-0.5 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-blue-400 to-blue-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-green-200">
            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                Ajouter une image de galerie
            </span>
        </a>
    </div>
    <table id="myGalerie" class="display striped-table">
      <thead>
          <tr class="text-color5">
              <th>Id</th>
              <th>Titre</th>
              <th>Image</th>
              <th>Mots clés</th>
              <th>Action</th>
          </tr>
      </thead>
      <tbody>
          <tr>
          <?php foreach($all_galerie as $galerie) :?>
            <td class="text-color5"><?php echo htmlspecialchars($galerie['id_galerieimg'])?></td>
            <td class="text-color5"><?php echo htmlspecialchars($galerie['nom_photo'])?></td>
            <td class="text-color5"><img src="assets/upload/<?php echo htmlspecialchars($galerie['img_photo'])?>" alt="Image 2" width="150px"></td>
            <td class="text-color5"><?php echo htmlspecialchars($galerie['mot_clé'])?></td>
            <td class="flex flex-row justify-center items-center h-20">
            <form class="w-fit" method="post" action="index.php?admin=modifyGalerie">
                <input type="hidden" name="id_galerieimg" value="<?php echo htmlspecialchars($galerie['id_galerieimg'])?>">
                <button class="h-1/2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Modifier</button>
            </form>
            <form class="w-fit">
            <button class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded delete-button"
            data-category="galerie"
            data-id="<?php echo htmlspecialchars($galerie['id_galerieimg'])?>">Supprimer</button>
            </form>
            </td>
          </tr>
          <?php endforeach;?>
    </tbody>
  </table>
</div>

<div id="tab4" class="bg-colorcrud tab-content hidden text-color5 p-4">
    <div class="flex justify-end mb-2">
        <a href="index.php?admin=ajoutCategory" class="relative inline-flex items-center justify-center p-0.5 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-blue-400 to-blue-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-green-200">
            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                Ajouter une categorie
            </span>
        </a>
    </div>
    <table id="myCategory" class="display striped-table">
      <thead>
          <tr class="text-color5">
              <th>Id</th>
              <th>Nom de la catégorie</th>
              <th>Domaine</th>
              <th>Action</th>
          </tr>
      </thead>
      <tbody>
          <tr>
            <?php foreach($all_category as $category) :?>
            <td class="text-color5"><?php echo htmlspecialchars($category['id_category'])?></td>
            <td class="text-color5"><?php echo htmlspecialchars($category['name_category'])?></td>
            <td class="text-color5"><?php echo htmlspecialchars($category['type'])?></td>
            <td class="flex flex-row justify-center items-center h-20">
            <form class="w-fit" method="post" action="index.php?admin=modifyCategory">
                <input type="hidden" name="id_category" value="<?php echo htmlspecialchars($category['id_category'])?>">
                <button class="h-1/2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Modifier</button>
            </form>
            <form class="w-fit">
            <button class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded delete-button"
            data-category="category"
            data-id="<?php echo htmlspecialchars($category['id_category'])?>">Supprimer</button>
            </form>
            </td>
          </tr>
          <?php endforeach;?>
    </tbody>
  </table>
</div>

<div id="tab5" class="bg-colorcrud tab-content hidden text-color5 p-4">
    <div class="flex justify-end mb-2">
        <a href="index.php?admin=ajoutUser" class="relative inline-flex items-center justify-center p-0.5 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-blue-400 to-blue-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-green-200">
            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                Ajouter un user
            </span>
        </a>
    </div>
    <table id="myUsers" class="display striped-table">
      <thead>
          <tr class="text-color5">
              <th>Id</th>
              <th>Email</th>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Adresse</th>
              <th>Role</th>
              <th>Action</th>
          </tr>
      </thead>
      <tbody>
          <tr>
            <?php foreach($all_user as $user) :?>
            <td class="text-color5"><?php echo htmlspecialchars($user['id_user'])?></td>
            <td class="text-color5"><?php echo htmlspecialchars($user['email'])?></td>
            <td class="text-color5"><?php echo htmlspecialchars($user['name'])?></td>
            <td class="text-color5"><?php echo htmlspecialchars($user['firstname'])?></td>
            <td class="text-color5"><?php echo htmlspecialchars($user['adresse'])?></td>
            <td class="text-color5"><?php echo htmlspecialchars($user['role'])?></td>
            <td class="flex flex-row justify-center items-center h-20">
            <form class="w-fit" method="post" action="index.php?admin=modifyUser">
                <input type="hidden" name="id_user" value="<?php echo htmlspecialchars($user['id_user'])?>">
                <button class="h-1/2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Modifier</button>
            </form>
            <button class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded delete-button"
            data-category="user"
            data-id="<?php echo htmlspecialchars($user['id_user'])?>">Supprimer</button>
            </form>
            </td>
          </tr>
          <?php endforeach;?>
    </tbody>
  </table>
</div>

<!-- <div id="tab6" class="bg-colorcrud tab-content hidden text-color5 p-4">
    <div class="flex justify-end mb-2">
        <button class="relative inline-flex items-center justify-center p-0.5 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-600 group-hover:from-green-400 group-hover:to-blue-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-green-200">
            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                Ajouter un article
            </span>
        </button>
    </div>
    <table id="myBoutique" class="display striped-table">
      <thead>
          <tr class="text-color5">
              <th>Id</th>
              <th>Titre</th>
              <th>Image 1</th>
              <th>Image 2</th>
              <th>Catégorie</th>
              <th>Date</th>
              <th>Action</th>
          </tr>
      </thead>
      <tbody>
          <tr>
            <?php foreach($all_actualite as $actualite) :?>
            <td class="text-color5"><?php echo htmlspecialchars($actualite['id_actualite'])?></td>
            <td class="text-color5"><?php echo htmlspecialchars($actualite['titre_actualite'])?></td>
            <td class="text-color5"><img src="assets/upload/<?php echo htmlspecialchars($actualite['image1'])?>" alt="Image 1" width="150px"></td>
            <td class="text-color5"><img src="assets/upload/<?php echo htmlspecialchars($actualite['image2'])?>" alt="Image 2" width="150px"></td>
            <td class="text-color5"><?php echo htmlspecialchars(str_replace(' - Actualité', '', $actualite['name_category']))?></td>
            <td class="text-color5"><?php echo htmlspecialchars($actualite['date_actualite'])?></td>
            <td><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Modifier</button>
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Supprimer</button></td>
          </tr>
          <?php endforeach;?>
    </tbody>
  </table>
</div> -->

<?php include_once('view/include/footer.php');?>


<!--================================
===========================-->

<!-- script general -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>

<!-- datatable -->
<script src="DataTables/datatables.min.js"></script>

<script>

$(document).ready(function() {
    $(".delete-button").on("click", function(event) {
        event.preventDefault();

        var deleteButton = $(this);
        var dataCategory = deleteButton.data("category");
        var dataId = deleteButton.data("id");
        var deleteMethod;
        var deleteId;

        // Correspondance entre les catégories et les noms de méthodes de suppression
        if (dataCategory === "actu") {
            deleteMethod = "deleteActu";
            deleteId = "id_actualite";
        } else if (dataCategory === "mercato") {
            deleteMethod = "deleteMercato";
            deleteId = "id_mercato";
        } else if (dataCategory === "galerie") {
            deleteMethod = "deleteGalerie";
            deleteId = "id_galerieimg";
        } else if (dataCategory === "category") {
            deleteMethod = "deleteCategory";
            deleteId = "id_category";
        } else if (dataCategory === "user") {
            deleteMethod = "deleteUser";
            deleteId = "id_user";
        }

        Swal.fire({
        title: 'Êtes-vous sûr de vouloir supprimer cet élément ?',
        text: "Vous ne pourrez pas revenir en arrière !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#22c55e',
        cancelButtonColor: '#ef4444',
        color:'#F5F5F5',
        background:'#1d1d1f',
        confirmButtonText: 'Oui, supprimer !',
        cancelButtonText: 'Annuler !',
        }).then((result) => {
            if (result.isConfirmed) {
                var requestData = {
                    deleteId: dataId
                };

                $.ajax({
                    type: "POST",
                    url: "index.php?admin=" + deleteMethod,
                    data: { deleteId: dataId },
                    success: function(response) {
                        deleteButton.closest("tr").fadeOut(function() {
                            $(this).remove();
                        });

                        Swal.fire(
                            'Supprimé !',
                            'Votre fichier a été supprimé.',
                            'success',
                        );
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });
    });
});


</script>

<script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByTagName("button");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }
</script>

<script>
    var table = new DataTable('#myActualite', {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json',
        },
    });
</script>
<script>
    var table = new DataTable('#myMercato', {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json',
        },
    });
</script>
<script>
    var table = new DataTable('#myGalerie', {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json',
        },
    });
</script>
<script>
    var table = new DataTable('#myCategory', {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json',
        },
    });
</script>
<script>
    var table = new DataTable('#myUsers', {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json',
        },
    });
</script>
<script>
    var table = new DataTable('#myBoutique', {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json',
        },
    });
</script>

</body>

</html>
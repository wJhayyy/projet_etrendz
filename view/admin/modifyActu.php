<?php 

include_once('src/model/connectBdd.php');

// echo($_POST['id_actualite']);

if (isset($_POST['id_actualite'])) {
    $id_actualite = $_POST['id_actualite'];

    try {

        // Préparer la requête avec le paramètre préparé
        $stmt_actualite = $connect->prepare("SELECT *
                                            FROM actualite
                                            WHERE id_actualite = :id_actualite
                                            ");

        // Exécuter la requête en liant le paramètre préparé avec la valeur de $_POST['id_actualite']
        $stmt_actualite->bindParam(':id_actualite', $id_actualite, PDO::PARAM_INT);
        $stmt_actualite->execute();

        // Récupérer les données dans un tableau associatif
        $all_actualite = $stmt_actualite->fetchAll(PDO::FETCH_ASSOC);
        
        } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "Aucun ID d'actualité reçu via POST.";
}

$stmt_filter = $connect->prepare("SELECT id_category, name_category
                                  FROM category
                                  WHERE type = 'actualite'
                                  ");
$stmt_filter->execute();
$all_filter = $stmt_filter->fetchAll(PDO::FETCH_ASSOC);
// Assurez-vous que $all_actualite[0]['date'] contient la date correcte depuis la base de données
$dateFromDB = $all_actualite[0]['date_actualite'];

// Vérifiez que la date n'est pas vide avant de la reformater
if (!empty($dateFromDB)) {
    $dateObj = DateTime::createFromFormat('Y-m-d', $dateFromDB);
    if ($dateObj) {
        $formattedDate = $dateObj->format('Y-m-d');
    } else {
        // En cas d'échec de la conversion, laisser la date telle quelle
        $formattedDate = $dateFromDB;
    }
} else {
    // Laisser vide si la date est NULL ou vide
    $formattedDate = '';
}

?>


<!doctype html>

<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Titre de la page</title>
    <link rel="stylesheet" href="assets/css/button-twitch.css">
    <?php  include_once('view/include/link.php');?>
</head>

<body class="bg-color1">

<?php include_once('view/include/navbar.php');?>

<section class="max-w-4xl p-6 mx-auto bg-color2 rounded-md shadow-md dark:bg-gray-800 mt-24">
    <h2 class="text-xl font-bold text-white capitalize dark:text-white">Modification d'une actualité</h2>
    <form method="POST" action="index.php?admin=editActu" enctype="multipart/form-data">
        <input type="hidden" name="id_actualite" value="<?= $id_actualite; ?>">
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <div>
                <label class="text-white dark:text-gray-200" for="titre_actualite">Titre</label>
                <input id="titre_actualite" name="titre_actualite" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Titre de l'actualité" value="<?php echo htmlspecialchars($all_actualite[0]['titre_actualite']); ?>">
            </div>
            <div>
                <label class="block text-sm font-medium text-white">
                Image Entete : 
              </label>
              <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md backgroundDiv" id="image_entete_div" style="background: url(assets/upload/<?php echo $all_actualite[0]['image_entete']; ?>); background-size: 100%; background-position: center center;">
                <div class="space-y-1 text-center">
                  <svg class="mx-auto h-12 w-12 text-white" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <div class="flex text-sm text-gray-600">
                    <label for="image_entete" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                      <span class="">Télécharger un fichier</span>
                      <input id="image_entete" name="image_entete" type="file" class="sr-only" onchange="updateBackgroundImage('image_entete_div', event)">
                    </label>
                  </div>
                  <p class="text-xs text-white">
                    PNG, JPG, GIF jusqu'à 2MB
                  </p>
                </div>
              </div>
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="introduction">Introduction</label>
                <textarea rows="5" name="introduction" id="introduction" type="textarea" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Introduction de l'actualité"><?php echo htmlspecialchars($all_actualite[0]['introduction']); ?></textarea>
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="video">Video : </label>
                <textarea rows="5" name="video" id="video" type="textarea" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Doit contenir : https://www.youtube.com/embed/"><?php echo htmlspecialchars($all_actualite[0]['video']); ?></textarea>
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="text1">Texte 1 : </label>
                <textarea rows="5" name="text1" id="text1" type="textarea" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Premier texte"><?php echo htmlspecialchars($all_actualite[0]['text1']); ?></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-white">
                Image 1 : 
              </label>
              <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md backgroundDiv" id="image_1_div" style="background: url(assets/upload/<?php echo $all_actualite[0]['image1']; ?>); background-size: 100%; background-position: center center;">
                <div class="space-y-1 text-center">
                  <svg class="mx-auto h-12 w-12 text-white" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <div class="flex text-sm text-gray-600">
                    <label for="image1" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                      <span class="">Télécharger un fichier</span>
                      <input id="image1" name="image1" type="file" class="sr-only" onchange="updateBackgroundImage('image_1_div', event)">
                    </label>
                  </div>
                  <p class="text-xs text-white">
                    PNG, JPG, GIF jusqu'à 2MB
                  </p>
                </div>
              </div>
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="text2">Texte 2 : </label>
                <textarea rows="5" name="text2" id="text2" type="textarea" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Deuxième texte"><?php echo htmlspecialchars($all_actualite[0]['text2']); ?></textarea>
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="titre2">Titre 2 :</label>
                <input id="titre2" name="titre2" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Second titre de l'actualité" value="<?php echo htmlspecialchars($all_actualite[0]['titre2']); ?>">
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="introduction2">Introduction 2 :</label>
                <textarea rows="5" name="introduction2" id="introduction2" type="textarea" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Seconde introduction"><?php echo htmlspecialchars($all_actualite[0]['introduction2']); ?></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-white">
                Image 2 : 
              </label>
              <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md backgroundDiv" id="image_2_div" style="background: url(assets/upload/<?php echo $all_actualite[0]['image2']; ?>); background-size: 100%; background-position: center center;">
                <div class="space-y-1 text-center">
                  <svg class="mx-auto h-12 w-12 text-white" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <div class="flex text-sm text-gray-600">
                    <label for="image2" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                      <span class="">Télécharger un fichier</span>
                      <input id="image2" name="image2" type="file" class="sr-only" onchange="updateBackgroundImage('image_2_div', event)">
                    </label>
                  </div>
                  <p class="text-xs text-white">
                    PNG, JPG, GIF jusqu'à 2MB
                  </p>
                </div>
              </div>
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="text2">Texte 3 : </label>
                <textarea rows="5" name="text3" id="text3" type="textarea" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Troisième texte"><?php echo htmlspecialchars($all_actualite[0]['text3']); ?></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-white">
                Image cashprize / tournoi : 
              </label>
              <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md backgroundDiv" id="image_gain_div" style="background: url(assets/upload/<?php echo $all_actualite[0]['imagegain']; ?>); background-size: 100%; background-position: center center;">
                <div class="space-y-1 text-center">
                  <svg class="mx-auto h-12 w-12 text-white" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <div class="flex text-sm text-gray-600">
                    <label for="imagegain" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                      <span class="">Télécharger un fichier</span>
                      <input id="imagegain" name="imagegain" type="file" class="sr-only" onchange="updateBackgroundImage('image_gain_div', event)">
                    </label>
                  </div>
                  <p class="text-xs text-white">
                    PNG, JPG, GIF jusqu'à 2MB
                  </p>
                </div>
              </div>
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="conclusion">Conclusion :</label>
                <textarea rows="5" name="conclusion" id="conclusion" type="textarea" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Texte de conclusion"><?php echo htmlspecialchars($all_actualite[0]['conclusion']); ?></textarea>
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="description">Description : </label>
                <textarea rows="5" name="description" id="description" type="textarea" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Description de l'actualité"><?php echo htmlspecialchars($all_actualite[0]['description']); ?></textarea>
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="date">Date :</label>
                <input id="date" name="date" type="date" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" value="<?php echo $formattedDate; ?>">
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="categorie">Catégorie : </label>
                <select name="category" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    <?php foreach ($all_filter as $filter) : ?>
                        <?php
                        // Vérifier si l'ID de la catégorie correspond à l'ID de l'actualité à modifier
                        $selected = ($filter['id_category'] == $all_actualite[0]['id_category']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo htmlspecialchars($filter['id_category']) ?>" <?php echo $selected ?>>
                            <?php echo htmlspecialchars(str_replace(' - Actualité', '', $filter['name_category'])) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="flex justify-evenly mt-6">
          <a class="ml-2 transition-colors duration-200 transform bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" href="index.php?admin=crud">Retour</a>
          <input type="submit" class="px-6 py-2 font-bold text-white transition-colors duration-200 transform bg-blue-500 rounded hover:bg-blue-700" value="Envoyer" name="submit">
        </div>
    </form>
</section>

<?php include_once('view/include/footer.php');?>

<script>
  function updateBackgroundImage(divId, event) {
    const fileInput = event.target;
    if (fileInput.files && fileInput.files[0]) {
      const reader = new FileReader();

      reader.onload = function (e) {
        const backgroundImageUrl = e.target.result;
        const backgroundDiv = document.getElementById(divId);

        backgroundDiv.style.backgroundImage = `url(${backgroundImageUrl})`;
        backgroundDiv.style.backgroundSize = '100%'; // You can adjust the zoom percentage here.
      };

      reader.readAsDataURL(fileInput.files[0]);
    }
  }
</script>

</body>

</html>
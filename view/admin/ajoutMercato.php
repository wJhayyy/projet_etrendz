<?php 

include_once('src/model/connectBdd.php');

$stmt_filter = $connect->prepare("SELECT id_category, name_category
                                  FROM category
                                  WHERE type = 'mercato'
                                  ");
$stmt_filter->execute();
$all_filter = $stmt_filter->fetchAll(PDO::FETCH_ASSOC);

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
    <h2 class="text-xl font-bold text-white capitalize dark:text-white">Ajout d'un Mercato</h2>
    <form method="POST" action="index.php?admin=addMercato" enctype="multipart/form-data">
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <div>
                <label class="text-white dark:text-gray-200" for="titre">Titre</label>
                <input id="titre" name="titre" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Titre du mercato">
            </div>
            <div>
                <label class="block text-sm font-medium text-white">
                Image Entete : 
              </label>
              <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md backgroundDiv" id="image_entete_div" style="background-size: 100%; background-position: center center;">
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
                <label class="text-white dark:text-gray-200" for="titre1">Titre 1 : </label>
                <input id="titre1" name="titre1" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Premier titre">
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="text1">Texte 1 : </label>
                <textarea rows="5" name="text1" id="text1" type="textarea" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Premier texte"></textarea>
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="tweet1">Tweet 1 : </label>
                <input id="tweet1" name="tweet1" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Premier tweet">
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="text2">Texte 2 : </label>
                <textarea rows="5" name="text2" id="text2" type="textarea" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Deuxième texte"></textarea>
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="tweet2">Tweet 2 : </label>
                <input id="tweet2" name="tweet2" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Deuxième tweet">
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="text3">Texte 3 : </label>
                <textarea rows="5" name="text3" id="text3" type="textarea" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Troisième texte"></textarea>
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="titre2">Titre 2 : </label>
                <input id="titre2" name="titre2" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Second titre">
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="text4">Texte 4 : </label>
                <textarea rows="5" name="text4" id="text4" type="textarea" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Quatrième texte"></textarea>
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="tweet3">Tweet 3 : </label>
                <input id="tweet3" name="tweet3" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Troisième tweet">
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="conclusion">Conclusion :</label>
                <textarea rows="5" name="conclusion" id="conclusion" type="textarea" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Texte de conclusion"></textarea>
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="description">Description : </label>
                <textarea rows="5" name="description" id="description" type="textarea" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Description de l'article"></textarea>
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="date_mercato">Date :</label>
                <input id="date_mercato" name="date_mercato" type="date" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="categorie">Catégorie : </label>
                <select name="category" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                <?php foreach ($all_filter as $filter) : ?>
                  <option value="<?php echo htmlspecialchars($filter['id_category'])?>"><?php echo htmlspecialchars(str_replace(' - Mercato', '', $filter['name_category']))?></option>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector("form").addEventListener("submit", function(event) {
        var isFormValid = true; // Variable pour vérifier si le formulaire est valide

        // Vérifier chaque champ du formulaire
        var formFields = document.querySelectorAll("input, textarea, select");
        for (var i = 0; i < formFields.length; i++) {
            if (formFields[i].value.trim() === "") {
                isFormValid = false;
                break; // Sortir de la boucle dès qu'un champ vide est trouvé
            }
        }

        if (!isFormValid) {
            event.preventDefault(); // Empêcher l'envoi du formulaire
            Swal.fire({
                title: 'Erreur',
                text: 'Tous les champs doivent être remplis.',
                icon: 'error',
                confirmButtonText: 'Fermer',
                confirmButtonColor: '#ef4444',
                color:'#F5F5F5',
                background:'#1d1d1f',
            });
        } else {
            // Le formulaire est valide, la page se rafraîchira automatiquement après l'envoi

            // Afficher un message de confirmation
            Swal.fire({
                title: 'Succès',
                text: 'Le formulaire a été soumis avec succès !',
                icon: 'success',
                color:'#F5F5F5',
                background:'#1d1d1f',
            });
        }
    });
});
</script>

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
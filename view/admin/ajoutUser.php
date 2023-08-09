<?php

include_once('src/model/connectBdd.php');

$stmt_roles = $connect->prepare("SELECT id_role, role FROM roles");
$stmt_roles->execute();
$all_roles = $stmt_roles->fetchAll(PDO::FETCH_ASSOC);

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
    <h2 class="text-xl font-bold text-white capitalize dark:text-white">Ajout d'un user</h2>
    <form method="POST" action="index.php?admin=addUser" enctype="multipart/form-data">
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <div>
                <label class="text-white dark:text-gray-200" for="email">Email :</label>
                <input id="email" name="email" type="email" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Email utilisé">
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="password">Password :</label>
                <input id="password" name="password" type="password" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Mot de passe">
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="name">Nom :</label>
                <input id="name" name="name" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Nom">
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="firstname">Prénom :</label>
                <input id="firstname" name="firstname" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Prénom">
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="adresse">Adresse : </label>
                <textarea rows="3" name="adresse" id="adresse" type="textarea" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Ex : 19 Avenue Charle de Gaulle, 08000"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-white">
                Image de profil (Employé) : 
              </label>
              <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md backgroundDiv" id="image_profil_div" style="background-size: 100%; background-position: center center;">
                <div class="space-y-1 text-center">
                  <svg class="mx-auto h-12 w-12 text-white" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <div class="flex text-sm text-gray-600">
                    <label for="img_profil" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                      <span class="">Télécharger un fichier</span>
                      <input id="img_profil" name="img_profil" type="file" class="sr-only" onchange="updateBackgroundImage('image_profil_div', event)">
                    </label>
                  </div>
                  <p class="text-xs text-white">
                    PNG, JPG, GIF jusqu'à 2MB
                  </p>
                </div>
              </div>
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="role">Role : </label>
                <select name="role" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    <?php foreach ($all_roles as $role) : ?>
                        <option value="<?php echo htmlspecialchars($role['id_role']) ?>"><?php echo htmlspecialchars($role['role']) ?></option>
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
<?php 

include_once('src/model/connectBdd.php');

if (isset($_POST['id_category'])) {
    $id_category = $_POST['id_category'];

    try {

        // Préparer la requête avec le paramètre préparé
        $stmt_category = $connect->prepare("SELECT *
                                            FROM category
                                            WHERE id_category = :id_category
                                            ");

        // Exécuter la requête en liant le paramètre préparé avec la valeur de $_POST['id_actualite']
        $stmt_category->bindParam(':id_category', $id_category, PDO::PARAM_INT);
        $stmt_category->execute();

        // Récupérer les données dans un tableau associatif
        $all_category = $stmt_category->fetchAll(PDO::FETCH_ASSOC);
        
        } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "Aucun ID de la category reçu via POST.";
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

<body class="bg-color1 h-screen">

<?php include_once('view/include/navbar.php');?>
<div class="h-4/6">
    <section class="max-w-4xl p-6 mx-auto bg-gradient-to-t from-color2 via-colorcrud to-color2 rounded-md shadow-md dark:bg-gray-800 mt-24">
        <h2 class="text-xl font-bold text-white capitalize dark:text-white">Modification d'une catégorie</h2>
        <form method="POST" action="index.php?admin=editCategory" enctype="multipart/form-data">
        <input type="hidden" name="id_category" value="<?= $id_category; ?>">
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                <div>
                    <label class="text-white dark:text-gray-200" for="name_category">Nom :</label>
                    <input id="name_category" name="name_category" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Titre de l'actualité" value="<?php echo htmlspecialchars($all_category[0]['name_category']); ?>">
                </div>
                <div>
                    <label class="text-white dark:text-gray-200" for="type">Type :</label>
                    <input id="type" name="type" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" placeholder="Titre de l'actualité" value="<?php echo htmlspecialchars($all_category[0]['type']); ?>">
                </div>
                <div class="flex justify-evenly mt-6">
                    <a class="ml-2 transition-colors duration-200 transform bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" href="index.php?admin=crud">Retour</a>
                    <input type="submit" class="px-6 py-2 font-bold text-white transition-colors duration-200 transform bg-blue-500 rounded hover:bg-blue-700" value="Envoyer" name="submit">
                </div>
        </form>
    </section>
</div>

<?php include_once('view/include/footer.php');?>

</body>

</html>
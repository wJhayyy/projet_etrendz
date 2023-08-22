<?php
// Vérifier si l'e-mail est stocké en session
if(isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Se connecter à la base de données (remplacez les valeurs par vos propres informations)
    $host = 'localhost';
    $username = 'jerem';
    $password = 'jerem';
    $database = 'gamerush';

    $conn = new mysqli($host, $username, $password, $database);

    // Vérifier la connexion à la base de données
    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    // Éviter les injections SQL en utilisant une requête préparée
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $result = $stmt->get_result();

    // Traiter les données récupérées
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Maintenant vous pouvez accéder aux données de la base de données
        $password = $row['password'];
        $nom = $row['name'];
        $prenom = $row['firstname'];
        $adresse = $row['adresse'];
        $img_profil = $row['img_profil'];

    } else {
        echo "Aucune donnée trouvée pour cet e-mail.";
    }

    // Fermer la connexion à la base de données
    $stmt->close();
    $conn->close();
} else {
    header('Location: index.php');
}
?>


<!doctype html>

<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Titre de la page</title>
  <link rel="stylesheet" href="assets/css/button-navbar.css">
  <?php include_once('view/include/link.php')?>
</head>

<body class="bg-color1">

<?php include_once('view/include/navbar.php')?>
<form class="" action="" method="" enctype="multipart/form-data">
    <div class="m-auto w-4/6 lg:w-full justify-center flex flex-col mb-40 mt-40 lg:flex-row">
        <div class="m-0 lg:mr-20 flex-shrink-0 space-y-10">
            <div class="flex flex-col">
                <h3 class="m-auto mb-2 text-color4">Email : </h3>
                <p class="w-auto sm:w-96 m-auto flex justify-center bg-colorcrud text-color5 text-opacity-60 font-semibold hover:text-white py-2 px-4 border border-color3 focus:border-color5 hover:border-orange-600 transition ease-in-out duration-300 ring-yellow-500 rounded"><?php echo $row['email'];?></p>
            </div>
            <div class="flex flex-col">
                <h3 class="m-auto mb-2 text-color4">Nom : </h3>
                <p class="w-auto sm:w-96 m-auto flex justify-center bg-colorcrud text-color5 text-opacity-60 font-semibold hover:text-white py-2 px-4 border border-color3 focus:border-color5 hover:border-orange-600 transition ease-in-out duration-300 ring-yellow-500 rounded"><?php echo $row['name'];?></p>
            </div>
            <div class="flex flex-col">
                <h3 class="m-auto mb-2 text-color4">Prénom : </h3>
                <p class="w-auto sm:w-96 m-auto flex justify-center bg-colorcrud text-color5 text-opacity-60 font-semibold hover:text-white py-2 px-4 border border-color3 focus:border-color5 hover:border-orange-600 transition ease-in-out duration-300 ring-yellow-500 rounded"><?php echo $row['firstname'];?></p>
            </div>
            <div class="flex flex-col">
                <h3 class="m-auto mb-2 text-color4">Adresse : </h3>
                <p class="w-auto sm:w-96 m-auto flex justify-center bg-colorcrud text-color5 text-opacity-60 font-semibold hover:text-white py-2 px-4 border border-color3 focus:border-color5 hover:border-orange-600 transition ease-in-out duration-300 ring-yellow-500 rounded"><?php echo $row['adresse'];?></p>
            </div>
</form>
            <p class="text-lg text-color4 text-center">Vous souhaitez changer de mot de passes ? Cliquez <a class="text-blue-400 hover:underline" href="index.php?admin=forgottenPassword">ici</a></p>
            <span class="inset-y-0 left-3 flex justify-center">
                <form action="index.php?admin=deconnexionForm" method="POST">
                    <button type="submit" class="cursor-pointer border rounded border-red-400 p-2 hover:bg-red-400 text-red-400 hover:text-color1 transition duration-300 ease-in-out">
                        <p class="">Se déconnecter</p>
                    </button>
                </form>
            </span>
        </div>
        <div class="m-auto mt-8 lg:m-0 flex justify-center items-center h-60 w-60 sm:h-96 sm:w-96">
            <img class="object-cover rounded-full h-full w-full max-h-full max-w-full" src="assets/upload/<?php echo $row['img_profil'];?>">
        </div>
    </div>

<?php include_once('view/include/footer.php')?>

</body>

</html>
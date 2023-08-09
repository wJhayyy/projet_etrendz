<?php 

include_once('src/model/connectBdd.php');

$stmt_users = $connect->prepare("SELECT u.*, r.role AS role_name FROM users u
                                 JOIN roles r ON u.id_role = r.id_role
                                 WHERE u.id_role > 1");
$stmt_users->execute();
$all_users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>

<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Titre de la page</title>
  <link rel="stylesheet" href="assets/css/button-navbar.css">
  <?php include_once('include/link.php')?>
</head>

<body class="bg-gradient-to-b from-color1 to-black">

<?php include_once('include/navbar.php')?>

<section class="flex items-center py-12 font-poppins">
        <div class="justify-center flex-1 max-w-6xl px-4 py-4 mx-auto lg:py-6 md:px-6">
            <div class="flex flex-wrap items-center">
                <div class="w-full px-4 mb-10 xl:w-1/2 lg:mb-8">
                    <div class="flex flex-wrap">
                        <div class="w-full px-4 md:w-1/2">
                            <img src="assets/upload/aboutme1.jpg" alt=""
                                class="object-cover w-full mb-6 rounded-lg h-80">
                            <img src="assets/upload/aboutme3.jpg" alt=""
                                class="object-cover w-full rounded-lg h-80">
                        </div>
                        <div class="w-full px-4 my-6 md:w-1/2 xl:mt-11">
                            <img src="assets/upload/aboutme2.jpg" alt=""
                                class="object-cover w-full mb-6 rounded-lg h-80">
                            <img src="assets/upload/aboutme4.jpg" alt=""
                                class="object-cover w-full rounded-lg h-80">
                        </div>
                    </div>
                </div>
                <div class="w-full px-4 mb-10 xl:w-1/2 lg:mb-8">
                    <span class="text-sm font-semibold text-color3">Notre histoire </span>
                    <h2 class="mt-2 mb-4 text-2xl font-bold text-color4">
                        Le centre de l'esport Français
                    </h2>
                    <p class="mb-4 text-base leading-7 text-gray-500">
                        Créée en avril 2019, Gamerush commente les plus grands événements eSport mondiaux 
                        et publie toutes les actualités dont les fans ont besoin. 
                        Regroupant la plus grande base de fans d'eSport, n'hésitez pas à nous retrouver 
                        sur notre chaîne <a class="text-color3" href="#">Twitch</a> pour suivre en direct les commentaires de nos casters.
                    </p>
                </div>
            </div>
        </div>
    </section>

<!-- Container for demo purpose -->
<div class="container my-24 mx-auto md:px-6">
  <!-- Section: Design Block -->
  <section class="text-center">
    <h2 class="mb-12 text-3xl font-bold text-color4">
     Découvrez notre <u class="text-color3">équipe</u>
    </h2>

    <div class="lg:gap-xl-12 grid gap-x-6 md:grid-cols-3 xl:grid-cols-4">
      <?php foreach($all_users as $user) : ?>
        <div class="mb-12">
          <img src="assets/upload/<?php echo htmlspecialchars($user['img_profil'])?>"
            class="mx-auto mb-4 rounded-full shadow-lg h-36 w-36 object-cover" alt="" />
          <p class="mb-2 font-bold text-color4"><?php echo htmlspecialchars($user['name'])?> <?php echo htmlspecialchars($user['firstname'])?></p>
          <p class="text-neutral-500"><?php echo htmlspecialchars($user['role_name'])?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
  <!-- Section: Design Block -->
</div>

<?php include_once('include/footer.php')?>

</body>
</html>



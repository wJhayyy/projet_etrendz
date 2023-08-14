<?php var_dump($_POST);die; ?>

<!doctype html>

<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Titre de la page</title>
  <link rel="stylesheet" href="assets/css/bg-gradient.css">
  <?php include_once('view/include/link.php')?>
</head>

<body>

<div class="min-h-screen flex justify-center items-center">
  <div class="py-12 px-12 bg-color1 rounded-2xl shadow-xl z-20 bg-opacity-30">
    <form id="resetPassword" action="index.php?admin=firstConnexionForm" method="POST">
      <div>
        <h1 class="text-3xl font-bold text-center text-color4 mb-4">Première connexion ?</h1>
        <p class="w-80 text-center m-auto mb-8 font-semibold text-color4 tracking-wide">Veuillez changer votre mot de passe pour un plus personnel.</p>
      </div>
      <div class="space-y-4">
        <input type="password" id="password" name="password" placeholder="Mot de passe" class="block text-sm py-3 px-4 rounded-lg w-full border outline-none" required/>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmer mot de passe" class="block text-sm py-3 px-4 rounded-lg w-full border outline-none" required/>
      </div>
      <div class="flex flex-col text-center mt-6">
        <input type="submit" name="submit" value="Connexion" class="m-auto py-3 w-64 text-xl text-white bg-color3 transition-colors duration-200 hover:bg-orange-500 hover:cursor-pointer rounded-2xl">
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

console.log()

</script>

</body>

</html>
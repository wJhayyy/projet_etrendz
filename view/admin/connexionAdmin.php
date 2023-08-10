<!doctype html>

<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Titre de la page</title>
  <link rel="stylesheet" href="assets/css/bg-gradient.css">
  <script src="script.js"></script>
  <?php include_once('view/include/link.php')?>
</head>

<body>

<div class="min-h-screen flex justify-center items-center">
  <div class="py-12 px-12 bg-color1 rounded-2xl shadow-xl z-20 bg-opacity-30">
    <form id="loginForm" action="index.php?admin=loginAdmin" method="POST">
      <div>
        <h1 class="text-3xl font-bold text-center text-color4 mb-4">Connexion</h1>
        <p class="w-80 text-center mb-8 font-semibold text-color4 tracking-wide">Connexion réservée aux admins du site Gamerush.</p>
      </div>
      <div class="space-y-4">
        <input type="text" id="email" name="email" placeholder="Adresse mail" class="block text-sm py-3 px-4 rounded-lg w-full border outline-none" required/>
        <input type="password" id="password" name="password" placeholder="Mot de passe" class="block text-sm py-3 px-4 rounded-lg w-full border outline-none" required/>
      </div>
      <div class="flex flex-col text-center mt-6">
        <input type="submit" value="Connexion" class="m-auto py-3 w-64 text-xl text-white bg-color3 transition-colors duration-200 hover:bg-orange-500 hover:cursor-pointer rounded-2xl">
        <a href="" class="w-fit m-auto mt-4 text-color4 hover:underline">Mot de passe oublié ?</a>
      </div>
    </form>
  </div>
</div>

<!-- Intégrer le CDN de SweetAlert2 et jQuery -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $("#loginForm").submit(function(e) {
        e.preventDefault();

        var email = $("#email").val();
        var password = $("#password").val();

        $.ajax({
            type: "POST",
            url: "index.php?admin=loginAdmin", // Remplacez par le chemin de votre script PHP de traitement
            data: {email: email, password: password},
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: true,
                        confirmButtonColor: '#22c55e',
                        color:'#F5F5F5',
                        background:'#1d1d1f'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'index.php'; // Rediriger vers index.php
                        }
                    });
                } else {
                    if (response.message === "Votre compte est désactivé.") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Compte désactivé',
                            text: response.message,
                            footer: '<a href="index.php?admin=#">Cliquez ici pour réactiver votre compte</a>',
                            confirmButtonColor: '#ef4444',
                            color:'#F5F5F5',
                            background:'#1d1d1f'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message,
                            footer: '<a href="index.php?admin=forgettenPassword">Mot de passe oublié ?</a>',
                            confirmButtonColor: '#ef4444',
                            color:'#F5F5F5',
                            background:'#1d1d1f'
                        });
                    }
                }
            }
        });
    });
});
</script>



</body>

</html>
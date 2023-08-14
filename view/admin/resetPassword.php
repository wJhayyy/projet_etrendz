<?php

include_once('src/model/connectBdd.php');

$token = $_GET['token'];
var_dump($token);

$stmt_email = $connect->prepare('SELECT * FROM users WHERE token = :token');
$token = $_GET['token'];
$stmt_email->bindParam(':token', $token, PDO::PARAM_STR);
$stmt_email->execute();
$userData = $stmt_email->fetch(PDO::FETCH_ASSOC);

var_dump($userData);

?>

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
    <form id="resetPassword" action="index.php?admin=resetForm&token=<?php echo $_GET['token']; ?>" method="POST">
      <div>
        <h1 class="text-3xl font-bold text-center text-color4 mb-4">Réinitialiser votre mot de passe</h1>
        <p class="w-80 text-center m-auto mb-8 font-semibold text-color4 tracking-wide">Entrer votre nouveau mot de passe.</p>
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
$(document).ready(function() {
    $("#resetPassword").submit(function(e) {
        e.preventDefault();
        var password = $("#password").val();
        var confirmPassword = $("#confirm_password").val();
        var token = "<?php echo $_GET['token']; ?>"; // Récupération du token de l'URL
        var email = "<?php echo $userData['email']; ?>"; // Récupération de l'email du token

        console.log(password, confirmPassword, token, email);
        $.ajax({
            type: "POST",
            url: "index.php?admin=resetForm&token=<?php echo $_GET['token']; ?>",
            data: {
                token: token,
                email: email,
                password: password,
                confirm_password: confirmPassword,
                submit: true
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Mot de passe changé avec succès.',
                        showConfirmButton: true,
                        confirmButtonColor: '#22c55e',
                        color:'#F5F5F5',
                        background:'#1d1d1f'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'index.php?admin=connexionAdmin'; // Remplacez par le chemin de votre page de connexionAdmin
                        }
                    });
                } else {
                    if (response.errorType === "accountDisabled") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Compte désactivé',
                            text: 'Votre compte est désactivé.',
                            footer: '<a href="index.php?admin=#">Cliquez ici pour réactiver votre compte</a>',
                            confirmButtonColor: '#ef4444',
                            color:'#F5F5F5',
                            background:'#1d1d1f'
                        });
                    } else if (response.errorType === "invalidConfirmKey") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'La confirmKey n\'est pas valide.',
                            confirmButtonColor: '#ef4444',
                            color:'#F5F5F5',
                            background:'#1d1d1f'
                        });
                    } else if (response.errorType === "passwordMismatch") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Les mots de passe ne correspondent pas.',
                            confirmButtonColor: '#ef4444',
                            color:'#F5F5F5',
                            background:'#1d1d1f'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Une erreur est survenue.',
                            footer: '<a href="index.php?admin=forgottenPassword">Mot de passe oublié ?</a>',
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
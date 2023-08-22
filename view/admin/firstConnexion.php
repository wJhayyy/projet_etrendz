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
  $(document).ready(function() {
    $("#resetPassword").submit(function(event) {
      event.preventDefault();

      // Récupérer les valeurs des champs
      var email = $("#hiddenEmail").val();
      var password = $("#password").val();
      var confirmPassword = $("#confirm_password").val();
      console.log(email);

      // Vérifier si les mots de passe correspondent
      if (password !== confirmPassword) {
        // Afficher une erreur
        Swal.fire({
          icon: 'error',
          text: 'Les mots de passe ne correspondent pas.',
          color:'#F5F5F5',
          background:'#1d1d1f',
        });
        return;
      }

      // Créer un FormData pour envoyer les données POST
      var formData = new FormData(this);
      formData.append("hiddenEmail", email);

      // Soumettre le formulaire avec les données FormData
      $.ajax({
        url: "index.php?admin=firstConnexionForm",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          // Gérer la réponse du serveur (afficher succès ou erreur)
          switch (response) {
            case "success":
            Swal.fire({
              icon: 'success',
              text: 'Le mot de passe a été mis à jour avec succès.',
              showConfirmButton: true,
              color: '#F5F5F5',
              background: '#1d1d1f',
              confirmButtonText: 'Ok',
            }).then((result) => {
              // Si l'utilisateur clique sur "Ok", effectuer la redirection
              if (result.isConfirmed) {
                window.location.href = "index.php?admin=connexionAdmin";
              }
            });
            break;
            case "password_invalid":
              Swal.fire({
                icon: 'error',
                text: 'Le mot de passe ne respecte pas les règles de validation. Il faut 1 majuscule, 1 chiffre et 10 lettres au minimum.',
                color:'#F5F5F5',
                background:'#1d1d1f',
              });
              break;
            case "password_mismatch":
              Swal.fire({
                icon: 'error',
                text: 'Les mots de passe ne correspondent pas.',
                color:'#F5F5F5',
                background:'#1d1d1f',
              });
              break;
            case "update_error":
              Swal.fire({
                icon: 'error',
                text: 'Erreur lors de la mise à jour du mot de passe.',
                color:'#F5F5F5',
                background:'#1d1d1f',
              });
              break;
            case "email_missing":
              Swal.fire({
                icon: 'error',
                text: "L'adresse e-mail n'a pas été transmise.",
                color:'#F5F5F5',
                background:'#1d1d1f',
              });
              break;
            default:
              Swal.fire({
                icon: 'error',
                text: "Une erreur s'est produite lors de la soumission du formulaire.",
                color:'#F5F5F5',
                background:'#1d1d1f',
              });
              break;
          }
        }
      });
    });
  });
</script>

</body>

</html>
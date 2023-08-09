<?php 

include_once('src/model/connectBdd.php');

$stmt_mercato = $connect->prepare("SELECT id_mercato, titre, image_entete, description
                                  FROM mercato
                                  ORDER BY id_mercato DESC
                                  LIMIT 6
                                  ");
$stmt_mercato->execute();
$all_mercato = $stmt_mercato->fetchAll(PDO::FETCH_ASSOC);

$stmt_actualite = $connect->prepare("SELECT id_actualite, titre_actualite, image_entete, description
                                  FROM actualite
                                  ORDER BY id_actualite DESC
                                  LIMIT 6
                                  ");
$stmt_actualite->execute();
$all_actualite = $stmt_actualite->fetchAll(PDO::FETCH_ASSOC);


$stmt_galerie = $connect->prepare("SELECT id_galerieimg, img_photo
                                  FROM galerie
                                  ORDER BY id_galerieimg DESC
                                  LIMIT 8
                                  ");
$stmt_galerie->execute();
$all_galerie = $stmt_galerie->fetchAll(PDO::FETCH_ASSOC);

function limitText($text, $limit) {
  if (mb_strlen($text) <= $limit) {
      return htmlspecialchars(mb_substr($text, 0, $limit));
  } else {
      $shortenedText = mb_substr($text, 0, $limit);
      $lastSpace = mb_strrpos($shortenedText, ' ');
      return rtrim(mb_substr($shortenedText, 0, $lastSpace)) . '...';
  }
}

?>

<!doctype html>


<html lang="fr">


<head>
  <meta charset="utf-8">
  <title>Titre de la page</title>
  <link rel="stylesheet" href="assets/css/accueil.css">
  <link rel="stylesheet" href="assets/css/testimonialimage.css">
  <link rel="stylesheet" href="assets/css/commentcard.css">
  <link rel="stylesheet" href="assets/css/card.css">
  <link rel="stylesheet" href="assets/css/button-twitch.css">
  <link rel="stylesheet" href="assets/css/button-navbar.css">
  <?php include_once('include/link.php')?>
</head>

<body class="bg-gradient-to-b from-color1 to-black overflow-x-hidden">

<?php include_once('include/navbar.php')?>

<header>
    <div class="box-position">
        <video class="box-video"autoplay muted loop id="myVideo" disablePictureInPicture>
            <source src="assets/upload/videoplayback.mp4">
        </video>
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-[#0f0f0f] via-transparent to-[#0f0f0f]"></div>
    </div>
    <div class="text-overlay background-entete mt-40 h-full">
        <div class="content-container">
            <h1 class="text-3xl font-bold uppercase">GameRush, le site d'actualité esport numéro 1 !</h1>
            <div class="grid grid-cols-2 lg:grid-cols-4 lg:gap-8 xl:gap-24 justify-center justify-evenly pt-16 lg:pt-24 w-11/12 lg:w-11/12 xl:w-10/12 m-auto">
                <div>
                    <i class="fa-solid fa-dollar-sign text-5xl" style="color: #fca311;"></i>
                    <h3 class="mt-8 font-semibold">L'actualités sur les mercatos en temps réel</h3>
                </div>
                <div>
                    <i class="fa-brands fa-twitch text-5xl" style="color: #fca311;"></i>
                    <h3 class="mt-8 font-semibold">Des streams quotidiens sur tous les événements e-sport du moment</h3>
                </div>
                <div class="mt-8 lg:mt-0">
                    <i class="fa-solid fa-calendar-days text-5xl" style="color: #fca311;"></i>
                    <h3 class="mt-8 font-semibold">Le calendrier des compétitions</h3>
                </div>
                <div class="mt-8 lg:mt-0">
                    <i class="fa-solid fa-fire text-5xl" style="color: #fca311;"></i>
                    <h3 class="mt-8 font-semibold">Toutes l'actualités e-sport chaude du moment</h3>
                </div>
            </div>
        </div>
    </div>
</header>


<!-- <div class="flex" style="height: 600px;">
  <iframe class="w-full lg:w-9/12 h-full m-auto my-12" src="https://player.twitch.tv/?channel=rocketbaguette&parent=localhost" frameborder="0" allowfullscreen="true" scrolling="no"></iframe>
</div> -->

<div class="ntshow">
<hr class="hrgradient w-4/6 m-auto mt-32 md:w-2/6">

<h3 class="text-3xl text-blanc text-center">
  Les revues 
  <span class="magic">
    <span class="magic-text">mercato</span>
  </span>
</h3>

<hr class="hrgradient w-4/6 m-auto mb-16 md:w-2/6">
</div>

	<a href="index.php?action=mercatos" class="w-fit m-auto flex justify-center button-twitch bg-transparent text-color5 font-semibold hover:text-white py-2 px-4 border border-rose hover:border-transparent rounded mt-8 mb-12">
		<p class="z-10">En savoir plus</p>
	</a>

  <div class="cards mt-2">
    <?php foreach ($all_mercato as $mercato): ?>
        <div class="card ntshow">
            <div class="card-content">
                <div class="card-image" title="<?php echo htmlspecialchars($mercato['titre']); ?>">
                <a href="<?php echo htmlspecialchars('index.php?action=mercato&id_mercato=' . $mercato['id_mercato'])?>">
                <img src="assets/upload/<?php echo $mercato['image_entete']; ?>"/>
                </div>
                </a>
                <div class="card-info-wrapper">
                <a href="<?php echo htmlspecialchars('index.php?action=mercato&id_mercato=' . $mercato['id_mercato'])?>">
                    <div class="card-info">
                        <div class="card-info-title">
                            <h3><?php echo limitText(htmlspecialchars($mercato['titre']),60); ?></h3>
                            <h4 class="sm:block"><?php echo limitText(htmlspecialchars($mercato['description']),80); ?></h4>
                        </div>
                    </div>
                </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

		   <div class="ntshow">
<hr class="hrgradient w-4/6 m-auto mt-32 md:w-2/6">

<h3 class="text-3xl text-blanc text-center">
  L'actualités 
  <span class="magic">
    <span class="magic-text">e-sport</span>
  </span>
</h3>

<hr class="hrgradient w-4/6 m-auto mb-16 md:w-2/6">
</div>

	<a href="index.php?action=actualités" class="w-fit m-auto flex justify-center button-twitch bg-transparent text-color5 font-semibold hover:text-white py-2 px-4 border border-rose hover:border-transparent rounded mt-8 mb-12">
		<p class="z-10">En savoir plus</p>
	</a>

<div class="cards mt-2">
  <?php foreach ($all_actualite as $actualite): ?>
	<div class="card ntshow">
	<div class="card-content">
          <div class="card-image" title="<?php echo htmlspecialchars($actualite['titre_actualite']); ?>">
				    <a href="<?php echo htmlspecialchars('index.php?action=actualité&id_actualite=' . $actualite['id_actualite'])?>">
				    <img src="assets/upload/<?php echo $actualite['image_entete']; ?>">
				  </div>
				  </a>
				<div class="card-info-wrapper">
        <a href="<?php echo htmlspecialchars('index.php?action=actualité&id_actualite=' . $actualite['id_actualite'])?>">
          <div class="card-info">
            <div class="card-info-title">
              <h3><?php echo limitText(htmlspecialchars($actualite['titre_actualite']),60); ?></h3>  
              <h4><?php echo limitText(htmlspecialchars($actualite['description']),80); ?></h4>
            </div>    
          </div>
        </a>
				</div>
	</div>
	</div>
  <?php endforeach;?>
</div>

<div class="ntshow">
  <hr class="hrgradient w-4/6 m-auto mt-32 md:w-2/6">
    <h3 class="text-3xl text-blanc text-center">
      Nos
      <span class="magic">
          <span class="magic-text">commentaires</span>
        </span>
    </h3>
  <hr class="hrgradient w-4/6 m-auto mb-16 md:w-2/6">
</div>

<div class="max-comment-width grid grid-cols-3 gap-2">
  <figure class="snip1574 ntshow"><img src="assets/upload/comment1.jpeg" alt="profile-sample1" />
    <figcaption>
      <blockquote>
        <p>Gamerush fais du bien à l'eSport en général.</p>
      </blockquote>
      <h3>Alexandre "Kaydop" Courant</h3>
      <h5>Ancien joueur de la team "Vitality"</h5>
    </figcaption>
  </figure>
  <figure class="snip1574 ntshow"><img src="assets/upload/comment2.jpg" alt="profile-sample2" />
    <figcaption>
      <blockquote>
        <p>L'impact international de Gamerush est même visible au Brésil.</p>
      </blockquote>
      <h3>Yan "yanxnz" Xisto Nolasco</h3>
      <h5>Joueur de la team "Furia"</h5>
    </figcaption>
  </figure>
  <figure class="snip1574 ntshow"><img src="assets/upload/comment3.jpg" alt="profile-sample3" />
    <figcaption>
      <blockquote>
        <p>La communauté qu'apporte Gamerush nous donnent tous envie d'être à fond.</p>
      </blockquote>
      <h3>Khalid "oKhaliD" Qasim</h3>
      <h5>Joueur de la team "Falcon"</h5>
    </figcaption>
  </figure>
  <figure class="snip1574 ntshow"><img src="assets/upload/comment4.jpg" alt="profile-sample4" />
    <figcaption>
      <blockquote>
        <p>Avoir un site qui publie de l'actualité sur plusieurs scènes eSport, c'est le top.</p>
      </blockquote>
      <h3>Lucas "Saken" Fayard </h3>
      <h5>Joueur de la team "Karmine Corp"</h5>
    </figcaption>
  </figure>
  <figure class="snip1574 ntshow"><img src="assets/upload/comment5.jpg" alt="profile-sample5" />
    <figcaption>
      <blockquote>
        <p>Maintenant que je suis sur le banc, je peux suivre à fond l'eSport grâce à Gamerush.</p>
      </blockquote>
      <h3>Alexandre "Extra" Paoli</h3>
      <h5>Ancien joueur de la team "BDS"</h5>
    </figcaption>
  </figure>
  <figure class="snip1574 ntshow"><img src="assets/upload/comment6.jpg" alt="profile-sample6" />
    <figcaption>
      <blockquote>
        <p>Après le titre de Champion du monde, on a suivi de prêt le mercato grâce à Gamerush.</p>
      </blockquote>
      <h3>Evan "M0nkey M00n" Rogez </h3>
      <h5>Joueur de la team "BDS"</h5>
    </figcaption>
  </figure>
</div> 

<div class="ntshow">
<hr class="hrgradient w-4/6 m-auto mt-32 md:w-2/6">

<h3 class="text-3xl text-blanc text-center">
  Notre galerie
  <span class="magic">
    <span class="magic-text">photo</span>
  </span>
</h3>

<hr class="hrgradient w-4/6 m-auto mb-16 md:w-2/6">
</div>

<a href="index.php?action=galerie" class="w-fit m-auto flex justify-center button-twitch bg-transparent text-color5 font-semibold hover:text-white py-2 px-4 border border-rose hover:border-transparent rounded mb-12">
	<p class="z-10">En savoir plus</p>
</a>

<div class="ntshow">
	<div id="image-track" data-mouse-down-at="0" data-prev-percentage="0">
    <?php foreach ($all_galerie as $galerie): ?>
		<img class="image" src="assets/upload/<?php echo $galerie['img_photo']?>" draggable="false" />
    <?php endforeach;?>
	</div>
</div>

<?php include_once('include/footer.php')?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.6/flowbite.min.js"></script>

<script src="assets/js/testimonialimage.js"></script>

<script>

const cards = document.getElementsByClassName("cards");
  for (const cardsElement of cards) {
    cardsElement.onmousemove = e => {
      for (const card of cardsElement.getElementsByClassName("card")) {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        card.style.setProperty("--mouse-x", `${x}px`);
        card.style.setProperty("--mouse-y", `${y}px`);
      }
    };
  }

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('show');
            observer.unobserve(entry.target);
        } else {
            entry.target.classList.remove('show');
        }
    });
});

const hiddenElements = document.querySelectorAll('.ntshow');
hiddenElements.forEach((el) => observer.observe(el));


  document.addEventListener('DOMContentLoaded', function () {
    const swiper = new Swiper('.swiper-container', {
      loop: true,
      slidesPerView: 1,
      spaceBetween: 32,
      centeredSlides: true,
      autoplay: {
        delay: 8000,
      },
      breakpoints: {
        640: {
          slidesPerView: 1.5,
        },
        1024: {
          slidesPerView: 3,
        },
      },
    })
  })

</script>


</body>

</html>
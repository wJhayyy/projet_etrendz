<!doctype html>


<html lang="fr">


<head>
  <meta charset="utf-8">
  <title>Titre de la page</title>
  <link rel="stylesheet" href="assets/css/accueil.css">
  <link rel="stylesheet" href="assets/css/card.css">
  <link rel="stylesheet" href="assets/css/button-twitch.css">
  <?php include_once('include/link.php')?>
</head>

<body class="bg-color1">

<?php include_once('include/navbar.php')?>

<header>
    <div class="box-position">
        <video class="box-video" autoplay muted loop id="myVideo" controls="false" disablePictureInPicture>
            <source src="assets/image/videoplayback.mp4">
        </video>
        <div class="gradient-overlay"></div>
    </div>
    <div class="text-overlay text-3xl">
        <h1>eTrendz, le site d'actualité esport numéro 1 ! </h1>
    </div>
</header>

<div class="flex" style="height: 600px;">
  <iframe class="w-full lg:w-9/12 h-full m-auto my-12" src="https://player.twitch.tv/?channel=rocketbaguette&parent=localhost" frameborder="0" allowfullscreen="true" scrolling="no"></iframe>
</div>

<div class="ntshow">
<hr class="hrgradient w-4/6 m-auto mt-32 md:w-2/6">

<h2 class="text-3xl text-blanc text-center">
  Quelques-uns de
  <span class="magic">
    <span class="magic-text">nos projets</span>
  </span>
</h2>

<hr class="hrgradient w-4/6 m-auto mb-16 md:w-2/6">
</div>

	<a href="#" class="w-fit m-auto flex justify-center button-twitch bg-transparent text-color5 font-semibold hover:text-white py-2 px-4 border border-rose hover:border-transparent rounded mt-8">
		<p class="z-10">En savoir plus</p>
	</a>

		<div class="cards mt-2">
			<div class="card ntshow">
			<div class="card-content">
				  <div class="card-image">
				  <a href="">
				  <img src="assets/image/card1.jpg">
				  </div>
				  </a>
				<div class="card-info-wrapper">
				<div class="card-info">
					<div class="card-info-title">
					<h3>Apartments</h3>  
					<h4>Places to be apart. Wait, what?</h4>
					</div>    
				</div>
				</div>
			</div>
			</div>

			<div class="card ntshow">
			<div class="card-content">
				<div class="card-image">
				<img src="assets/image/card2.jpg">
				</div>
				<div class="card-info-wrapper">
				<div class="card-info">
					<div class="card-info-title">
					<h3>Unicorns</h3>  
					<h4>A single corn. Er, I mean horn.</h4>
					</div>    
				</div>  
				</div>
			</div>
			</div>

			<div class="card ntshow">
			<div class="card-content">
				<div class="card-image">
				<img src="assets/image/card3.jpg">
				</div>
				<div class="card-info-wrapper">
				<div class="card-info">
					<div class="card-info-title">
					<h3>Blender Phones</h3>  
					<h4>These absolutely deserve to exist.</h4>
					</div>    
				</div>
				</div>
			</div>
			</div>

			<div class="card ntshow">
			<div class="card-content">
				<div class="card-image">
				<img src="assets/image/card4.jpg">
				</div>
				<div class="card-info-wrapper">
				<div class="card-info">
					<div class="card-info-title">
					<h3>Adios</h3>  
					<h4>See you....</h4>
					</div>    
				</div>
				</div>
			</div>
			</div>

			<div class="card ntshow">
			<div class="card-content">
				<div class="card-image">
				<img src="assets/image/card5.jpg">
				</div>
				<div class="card-info-wrapper">
				<div class="card-info">
					<div class="card-info-title">
					<h3>I mean hello</h3>  
					<h4>...over here.</h4>
					</div>    
				</div>
				</div>
			</div>
			</div>

			<div class="card ntshow">
			<div class="card-content">
				<div class="card-image">
				<img src="assets/image/card6.jpg">
				</div>
				<div class="card-info-wrapper">
				<div class="card-info">
					<div class="card-info-title">
					<h3>Otters</h3>  
					<h4>Look at me, imma cute lil fella.</h4>
					</div>    
				</div>
				</div>
			</div>
			</div>

   		</div>

</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.6/flowbite.min.js"></script>

<script src="assets/js/video-homepage.js"></script>

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

</html>
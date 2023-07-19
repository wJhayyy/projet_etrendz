<!doctype html>


<html lang="fr">


<head>
  <meta charset="utf-8">
  <title>Titre de la page</title>
  <link rel="stylesheet" href="assets/css/accueil.css">
  <link rel="stylesheet" href="assets/css/testimonialimage.css">
  <link rel="stylesheet" href="assets/css/card.css">
  <link rel="stylesheet" href="assets/css/button-twitch.css">
  <?php include_once('include/link.php')?>
</head>

<body class="bg-color1">

<?php include_once('include/navbar.php')?>

<header>
    <div class="box-position">
        <video class="box-video"autoplay muted loop id="myVideo" disablePictureInPicture>
            <source src="assets/image/videoplayback.mp4">
        </video>
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-[#0f0f0f] via-transparent to-[#0f0f0f]"></div>
    </div>
    <div class="text-overlay background-entete mt-40 h-full">
        <div class="content-container">
            <h1 class="text-2xl">eTrendz, le site d'actualité esport numéro 1 !</h1>
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

<h2 class="text-3xl text-blanc text-center">
  Les revues 
  <span class="magic">
    <span class="magic-text">mercato</span>
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

		   <div class="ntshow">
<hr class="hrgradient w-4/6 m-auto mt-32 md:w-2/6">

<h2 class="text-3xl text-blanc text-center">
  L'actualités 
  <span class="magic">
    <span class="magic-text">e-sport</span>
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

	<!-- Container for demo purpose
<div class="my-24 mx-auto md:px-6">
   Section: Design Block 
  <section class="mb-32 text-center">
    <h2 class="mb-12 text-3xl font-bold">Testimonials</h2>

    <div class="grid gap-x-6 md:grid-cols-3 xl:gap-x-12">
      <div class="w-5/6 m-auto md:w-full mb-6 lg:mb-0">
        <div
          class="block rounded-lg bg-white shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700">
          <div class="relative overflow-hidden bg-cover bg-no-repeat">
            <img src="assets/image/testimonial1.jpg" class="w-full rounded-t-lg" />
            <a href="#!">
              <div class="absolute top-0 right-0 bottom-0 left-0 h-full w-full overflow-hidden bg-fixed"></div>
            </a>
            <svg class="absolute left-0 bottom-0 text-white dark:text-neutral-700" xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 1440 320">
              <path fill="currentColor"
                d="M0,288L48,272C96,256,192,224,288,197.3C384,171,480,149,576,165.3C672,181,768,235,864,250.7C960,267,1056,245,1152,250.7C1248,256,1344,288,1392,304L1440,320L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
              </path>
            </svg>
          </div>
          <div class="p-6 pb-8 lg:max-h-64">
            <h5 class="mb-2 text-lg font-bold">Victor "Ferra" Francal</h5>
            <h6 class="mb-4 font-medium text-primary dark:text-primary-400">
              Coach "Team Vitality"
            </h6>
            <ul class="mb-6 flex justify-center">
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" class="w-5 text-warning">
                  <path fill="currentColor"
                    d="m233 976 65-281L80 506l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z" />
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" class="w-5 text-warning">
                  <path fill="currentColor"
                    d="m233 976 65-281L80 506l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z" />
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" class="w-5 text-warning">
                  <path fill="currentColor"
                    d="m233 976 65-281L80 506l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z" />
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" class="w-5 text-warning">
                  <path fill="currentColor"
                    d="m233 976 65-281L80 506l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z" />
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" class="w-5 text-warning">
                  <path fill="currentColor"
                    d="m480 757 157 95-42-178 138-120-182-16-71-168v387ZM233 976l65-281L80 506l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z" />
                </svg>
              </li>
            </ul>
            <p>
              En étant coach de la team Vitality,
			  eTrendz nous aide à rester dans l'actualité
			  sur d'autre jeux que nous ne pouvons pas suivre.
            </p>
          </div>
        </div>
      </div>

      <div class="w-5/6 m-auto md:w-full mb-6 lg:mb-0">
        <div
          class="block rounded-lg bg-white shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700">
          <div class="relative overflow-hidden bg-cover bg-no-repeat">
            <img src="assets/image/testimonial4.jpeg" class="w-full rounded-t-lg" />
            <a href="#!">
              <div class="absolute top-0 right-0 bottom-0 left-0 h-full w-full overflow-hidden bg-fixed"></div>
            </a>
            <svg class="absolute left-0 bottom-0 text-white dark:text-neutral-700" xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 1440 320">
              <path fill="currentColor"
                d="M0,96L48,128C96,160,192,224,288,240C384,256,480,224,576,213.3C672,203,768,213,864,202.7C960,192,1056,160,1152,128C1248,96,1344,64,1392,48L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
              </path>
            </svg>
          </div>
          <div class="p-6 pb-8 lg:max-h-64">
            <h5 class="mb-2 text-lg font-bold">Benjamin "Eversax" Wagner</h5>
            <h6 class="mb-4 font-medium text-primary dark:text-primary-400">
			Coach "Karmine Corp"
            </h6>
            <ul class="mb-6 flex justify-center">
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" class="w-5 text-warning">
                  <path fill="currentColor"
                    d="m233 976 65-281L80 506l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z" />
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" class="w-5 text-warning">
                  <path fill="currentColor"
                    d="m233 976 65-281L80 506l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z" />
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" class="w-5 text-warning">
                  <path fill="currentColor"
                    d="m233 976 65-281L80 506l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z" />
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" class="w-5 text-warning">
                  <path fill="currentColor"
                    d="m233 976 65-281L80 506l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z" />
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" class="w-5 text-warning">
                  <path fill="currentColor"
                    d="m233 976 65-281L80 506l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z" />
                </svg>
              </li>
            </ul>
            <p>
              eTrendz regroupe une grosse communauté francophone et 
			  n'hésite pas à faire le voyage pour venir
			  encourager les francophones.
            </p>
          </div>
        </div>
      </div>

      <div class="w-5/6 m-auto md:w-auto mb-6 lg:mb-0">
        <div
          class="block rounded-lg bg-white shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700">
          <div class="relative overflow-hidden bg-cover bg-no-repeat">
            <img src="assets/image/testimonial6.jpeg" class="w-full rounded-t-lg" />
            <a href="#!">
              <div class="absolute top-0 right-0 bottom-0 left-0 h-full w-full overflow-hidden bg-fixed"></div>
            </a>
            <svg class="absolute left-0 bottom-0 text-white dark:text-neutral-700" xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 1440 320">
              <path fill="currentColor"
                d="M0,288L48,256C96,224,192,160,288,160C384,160,480,224,576,213.3C672,203,768,117,864,85.3C960,53,1056,75,1152,69.3C1248,64,1344,32,1392,16L1440,0L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
              </path>
            </svg>
          </div>
          <div class="p-6 pb-8 lg:max-h-64">
            <h5 class="mb-2 text-lg font-bold">Brice "ExoTiiK" Bigeard</h5>
            <h6 class="mb-4 font-medium text-primary dark:text-primary-400">
              Joueur "Karmine Corp"
            </h6>
            <ul class="mb-6 flex justify-center">
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" class="w-5 text-warning">
                  <path fill="currentColor"
                    d="m233 976 65-281L80 506l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z" />
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" class="w-5 text-warning">
                  <path fill="currentColor"
                    d="m233 976 65-281L80 506l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z" />
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" class="w-5 text-warning">
                  <path fill="currentColor"
                    d="m233 976 65-281L80 506l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z" />
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" class="w-5 text-warning">
                  <path fill="currentColor"
                    d="m233 976 65-281L80 506l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z" />
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" class="w-5 text-warning">
                  <path fill="currentColor"
                    d="m233 976 65-281L80 506l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z" />
                </svg>
              </li>
            </ul>
            <p>
			On est fier d'avoir une plateforme
			comme ça qui nous donnent de la force sur 
			la scène et qui montre la ferveur de la communauté
			française.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
  Section: Design Block 
</div> -->
<!-- Container for demo purpose -->
<div>
	<div id="image-track" data-mouse-down-at="0" data-prev-percentage="0">
		<img class="image" src="assets/image/card1.jpg" draggable="false" />
		<img class="image" src="assets/image/card2.jpg" draggable="false" />
		<img class="image" src="assets/image/card3.jpg" draggable="false" />
		<img class="image" src="https://images.unsplash.com/photo-1495805442109-bf1cf975750b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" draggable="false" />
		<img class="image" src="https://images.unsplash.com/photo-1548021682-1720ed403a5b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" draggable="false" />
		<img class="image" src="https://images.unsplash.com/photo-1496753480864-3e588e0269b3?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2134&q=80" draggable="false" />
		<img class="image" src="https://images.unsplash.com/photo-1613346945084-35cccc812dd5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1759&q=80" draggable="false" />
		<img class="image" src="https://images.unsplash.com/photo-1516681100942-77d8e7f9dd97?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" draggable="false" />
	</div>
</div>

</body>

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

</html>
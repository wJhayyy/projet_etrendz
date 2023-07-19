<nav class="fixed top-0 left-0 right-0 z-50 px-4 py-4 flex justify-between items-center bg-gradient-to-b from-color1 to-transparent">
		<a class="text-3xl font-bold leading-none w-20" href="index.php">
                <img class="w-full h-full" src="assets/image/logonobg.png">
		</a>
		<div class="lg:hidden">
			<button class="navbar-burger flex items-center text-blue-600 p-3">
				<svg class="block h-4 w-4 fill-current text-color4" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
					<title>Mobile menu</title>
					<path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
				</svg>
			</button>
		</div>
		<ul class="hidden absolute top-1/2 right-12 transform -translate-y-1/2 -translate-x-1/2 lg:flex lg:mx-auto lg:flex lg:items-center lg:w-auto lg:space-x-6">
			<li><a class="block text-base font-semibold rounded gradient-button-desktop" href="#">Actualité</a></li>
			<hr class="vertical-hr">
			<li><a class="block text-base font-semibold rounded gradient-button-desktop" href="#">Mercato</a></li>
			<hr class="vertical-hr">
			<li><a class="block text-base font-semibold rounded gradient-button-desktop" href="#">A propos</a></li>
			<hr class="vertical-hr">
			<li><a class="block text-base font-semibold rounded gradient-button-desktop" href="#">Twitch</a></li>
			<hr class="vertical-hr">
			<li><a class="block text-base font-semibold rounded gradient-button-desktop" href="#">Contact</a></li>
		</ul>
	</nav>
	<div class="navbar-menu relative z-50 hidden">
		<div class="navbar-backdrop fixed inset-0 bg-gray-800 opacity-25"></div>
		<nav class="fixed top-0 left-0 bottom-0 flex flex-col w-5/6 max-w-sm py-4 px-4 bg-gradient-to-r from-color1 via-color1 to-transparent overflow-y-auto">
			<div class="flex items-center mb-8">
				<a class="mr-auto text-3xl font-bold leading-none w-20" href="#">
                    <img class="w-full h-full" src="assets/image/logonobg.png">
				</a>
				<button class="navbar-close">
					<svg class="h-6 w-6 text-color4 cursor-pointer hover:text-color5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
					</svg>
				</button>
			</div>
			<div>
				<ul>
					<li class="mb-2">
						<a class="block p-4 text-base font-semibold rounded gradient-button" href="#">Actualités</a>
					</li>
					<li class="mb-2">
						<a class="block p-4 text-base font-semibold rounded gradient-button" href="#">Mercato</a>
					</li>
					<li class="mb-2">
						<a class="block p-4 text-base font-semibold rounded gradient-button" href="#">A propos</a>
					</li>
					<li class="mb-2">
						<a class="block p-4 text-base font-semibold rounded gradient-button" href="#">Twitch</a>
					</li>
					<li class="mb-2">
						<a class="block p-4 text-base font-semibold rounded gradient-button" href="#">Contact</a>
					</li>
				</ul>
			</div>
				<p class="my-4 text-xs text-gray-400">
					<span>Copyright © 2021</span>
				</p>
			</div>
		</nav>
	</div>

    <script>
// Burger menus
document.addEventListener('DOMContentLoaded', function() {
    // open
    const burger = document.querySelectorAll('.navbar-burger');
    const menu = document.querySelectorAll('.navbar-menu');

    if (burger.length && menu.length) {
        for (var i = 0; i < burger.length; i++) {
            burger[i].addEventListener('click', function() {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }

    // close
    const close = document.querySelectorAll('.navbar-close');
    const backdrop = document.querySelectorAll('.navbar-backdrop');

    if (close.length) {
        for (var i = 0; i < close.length; i++) {
            close[i].addEventListener('click', function() {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }

    if (backdrop.length) {
        for (var i = 0; i < backdrop.length; i++) {
            backdrop[i].addEventListener('click', function() {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }
});
</script>
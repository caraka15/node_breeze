<div class="bg-orange-500 pt-12">
    <div class="container mx-auto flex flex-col flex-wrap items-center px-5 md:flex-row">
        <!--Left Col-->
        <div class="flex w-full flex-col items-start justify-center text-center md:w-2/5 md:text-left">
            <p class="tracking-loose w-full uppercase">Looking to redefine your financial future?</p>
            <h1 class="my-4 text-5xl font-bold leading-tight">
                Unlock the Power of Staking with Us!
            </h1>
            <p class="mb-8 text-2xl leading-normal">
                Pondering your financial future? Unlock the Power of Staking with Us! Explore the possibilities with our
                platform and guide. Ready to dive in?
            </p>
            <a href="#network"
                class="focus:shadow-outline z-20 mx-auto my-6 transform scroll-auto rounded-full bg-white px-8 py-4 font-bold text-gray-800 shadow-lg transition duration-300 ease-in-out hover:scale-105 focus:outline-none lg:mx-0">
                Subscribe
            </a>
        </div>
        <!--Right Col-->
        <div class="z-20 w-full py-6 text-center md:w-3/5">
            <img class="z-50 mx-auto" src="{{ asset('img/hero.svg') }}" />
        </div>
    </div>
</div>
<div id="network" class="relative -mt-12 lg:-mt-24">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" id="mySvg">
        <path fill="#f97316" fill-opacity="1"
            d="M0,160L80,138.7C160,117,320,75,480,90.7C640,107,800,181,960,186.7C1120,192,1280,128,1360,96L1440,64L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z">
        </path>
        <path fill-opacity="1" class="fill-light-mode"
            d="M0,160L80,138.7C160,117,320,75,480,90.7C640,107,800,181,960,186.7C1120,192,1280,128,1360,96L1440,64L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z">
        </path>

        <script>
            // Function to check if dark mode is enabled
            function isDarkMode() {
                return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            }

            // Get the path element
            const pathElement = document.querySelector('#mySvg .fill-light-mode');

            // Set the fill color based on the mode
            if (isDarkMode()) {
                pathElement.style.fill = '#111827'; // Dark mode color
            } else {
                pathElement.style.fill = '#f3f4f6'; // Light mode color
            }
        </script>
    </svg>
</div>

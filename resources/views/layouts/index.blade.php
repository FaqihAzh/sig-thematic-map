<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Peta Tematik')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    @vite('resources/css/app.css')
    <style>
        .menu-enter {
            opacity: 0;
            transform: translateY(-10px) scale(0.95);
            transition: opacity 0.4s ease-in-out, transform 0.4s ease-in-out;
        }
        .menu-enter-active {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        .menu-leave {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        .menu-leave-active {
            opacity: 0;
            transform: translateY(-10px) scale(0.95);
        }

        #navigation-menu {
            transition: all 0.3s ease;
        }

        #map {
            width: 100%;
            height: 100vh;
            z-index: 0;
        }

    </style>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center relative w-full">

    <div class="absolute top-4 left-4 md:top-6 md:left-6 space-y-2 z-10 w-[100vw]">
        <div class="flex gap-2 w-full max-w-[90%]">
            <div
            id="hamburger-button"
            class="min-w-14 min-h-14 bg-white text-white flex items-center justify-center rounded-full shadow-lg cursor-pointer transition-transform transform hover:scale-105"
        >
                <i id="menu-icon" class="material-icons-round text-gray-700">menu</i>
                <i id="close-icon" class="material-icons-round hidden text-gray-700">close</i>
            </div>
            <div class="bg-white rounded-full shadow-lg px-4 md:px-8 h-14 w-full md:w-auto items-center font-medium flex text-xs !text-center md:text-left leading-4 md:leading-normal md:text-base">@yield('title', 'Peta Tematik')</div>
        </div>
        <div
            id="navigation-menu"
            class="bg-white rounded-lg shadow-lg p-2 w-fit hidden z-10"
        >
            <div class="flex flex-col gap-0 md:gap-2">
                <a href="{{ url('/') }}" class="text-sm md:text-base flex items-center gap-2 px-3 py-2 text-gray-800 hover:bg-gray-100 rounded-md">
                    <i class="material-icons-round text-gray-400">map</i>
                    Provinsi di Indonesia
                </a>
                <a href="{{ url('/thematic-map/sulsel/density') }}" class="text-sm md:text-base flex items-center gap-2 px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <i class="material-icons-round text-gray-400">location_city</i>
                    Kepadatan Penduduk
                </a>
                <a href="{{ url('/thematic-map/sulsel/tpt') }}" class="text-sm md:text-base flex items-center gap-2 px-3 py-2 text-gray-800 hover:bg-gray-100 rounded-md">
                    <i class="material-icons-round text-gray-400">people</i>
                    Tingkat Pengangguran Terbuka
                </a>
                <a href="{{ url('/thematic-map/sulsel/student') }}" class="text-sm md:text-base flex items-center gap-2 px-3 py-2 text-gray-800 hover:bg-gray-100 rounded-md">
                    <i class="material-icons-round text-gray-400">school</i>
                    Sebaran Pelajar
                </a>
                <a href="{{ url('/ina/earthquakes') }}" class="text-sm md:text-base flex items-center gap-2 px-3 py-2 text-gray-800 hover:bg-gray-100 rounded-md">
                    <i class="material-symbols-outlined text-gray-400">earthquake</i>
                    Sebaran Gempa Terkini
                </a>
            </div>
        </div>
    </div>

    @yield('content')

    <script>
        const button = document.getElementById('hamburger-button');
        const menu = document.getElementById('navigation-menu');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');

        button.addEventListener('click', () => {
            const isMenuOpen = !menu.classList.contains('hidden');

            if (isMenuOpen) {
                menu.classList.remove('menu-enter-active');
                menu.classList.add('menu-leave');
                menu.classList.remove('menu-enter');
                menu.classList.add('hidden');
            } else {
                menu.classList.remove('hidden');
                menu.classList.add('menu-enter');
                setTimeout(() => {
                    menu.classList.add('menu-enter-active');
                    menu.classList.remove('menu-enter');
                }, 10);
            }

            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });
    </script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    @stack('scripts')
</body>
</html>

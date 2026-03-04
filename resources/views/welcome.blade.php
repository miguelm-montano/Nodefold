<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nodefold</title>

  <link rel="icon" type="image/svg+xml"
    href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' viewBox='0 0 24 24'><rect width='8' height='8' x='3' y='3' fill='black' rx='1.5' ry='1.5'/><rect width='8' height='8' x='13' y='3' fill='black' rx='1.5' ry='1.5'/><rect width='8' height='8' x='3' y='13' fill='black' rx='1.5' ry='1.5'/><rect width='8' height='8' x='13' y='13' fill='black' rx='1.5' ry='1.5'/></svg>">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.9.3/dist/dotlottie-wc.js" type="module"></script>
</head>

<body class="antialiased font-['Montserrat',_serif]">

  <!-- HEADER -->
  <header class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-6 md:px-16 py-6 bg-black">
    <h1 class="text-3xl font-bold text-white">
      Nodefold
    </h1>

    <div class="flex items-center gap-4 text-xs">
      @if (Route::has('login'))
        <a href="{{ route('login') }}" class="text-sm font-medium text-white hover:opacity-70 transition">
          Log In
        </a>
      @endif

      @if (Route::has('register'))
        <a href="{{ route('register') }}"
          class="bg-white text-black px-3 py-2 rounded-3xl font-bold hover:bg-gray-200 transition">
          Sign Up
        </a>
      @endif
    </div>
  </header>

  <!-- First Section -->
  <section class="h-screen bg-black text-white flex flex-col bg-cover bg-center bg-no-repeat"
    style="background-image: url('{{ asset('images/Hero-bg.webp') }}')">

    <div class="flex items-center gap-4 text-xs">
      @if (Route::has('login'))
        <a href="{{ route('login') }}" class="text-sm font-medium hover:opacity-70 transition">
          Log In
        </a>
      @endif

      @if (Route::has('register'))
        <a href="{{ route('register') }}"
          class="bg-white text-black px-3 py-2 rounded-3xl font-bold hover:bg-gray-200 transition">
          Sign Up
        </a>
      @endif
    </div>
    </header>

    <!-- HERO CONTENT -->
    <div class="flex-1 flex items-center justify-center px-6 md:px-16">
      <div class="text-center max-w-2xl flex flex-col items-center gap-6">

        <!-- LOTTIE -->
        <div class="h-28 overflow-hidden flex justify-center -mt-48">
          <dotlottie-wc src="https://lottie.host/7f3129a3-cb27-4f59-94a7-e1b00a792639/7yEPP2VRSt.lottie"
            class="w-48 h-48" autoplay loop>
          </dotlottie-wc>
        </div>

        <!-- TEXT -->
        <h2 class="text-5xl font-bold">
          Organize everything in one place.
        </h2>

        <p class="text-white font-regular -mt-2">
          Minimal workspace to manage your resources, folders and ideas
        </p>

        <a href="{{ route('register') }}"
          class="bg-white text-black px-10 py-2 rounded-3xl font-semibold hover:bg-gray-200 transition">
          Sign Up
        </a>

      </div>
    </div>

  </section>


  <!-- Second section -->
  <section class="bg-white text-black px-6 md:px-16 py-20">
    <div class="max-w-7xl mx-auto w-full flex flex-col gap-16">

      <!-- HEADLINE -->
      <div class="flex flex-col md:flex-row gap-12 items-start">

        <!-- TITLE -->
        <div class="flex-1 flex flex-col gap-4 text-right mt-28">
          <h2 class="text-4xl md:text-5xl font-bold leading-tight">
            Start with an empty space, like a blank sheet of paper.
          </h2>
          <!-- LINE AND SUBTITLE -->
          <div class="mt-2 h-[10px] w-full bg-black rounded-full"></div>
          <p class="text-black text-lm font-medium mt-2 text-right">
            Nodefol helps you organize each project with what you need
          </p>
        </div>

        <!-- IMAGES -->
        <div class="flex flex-row gap-4 w-full md:w-auto shrink-0 items-start mt-4">

          <!-- PAPER IMAGE -->
          <div class="w-[294px] h-[340px] rounded-3xl overflow-hidden bg-gray-200 shrink-0 mt-8">
            <img src="{{ asset('images/Papers.jpeg') }}" alt="Papers"
              class="w-full h-full object-cover object-center" />
          </div>

          <!-- WEB CARD -->
          <div class="flex flex-col gap-3 w-[240px] shrink-0">

            <!-- INFO CARD -->
            <div
              class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm flex flex-col gap-1 transition-all duration-300 ease-in-out hover:scale-[1.03] hover:shadow-md cursor-default">
              <div class="flex items-center gap-2 mb-1">
                <!-- ICON -->
                <div
                  class="w-6 h-6 rounded-md bg-blue-100 flex items-center justify-center text-[10px] font-bold text-blue-500 shrink-0">
                  <img src="{{ asset('images/coolors_icon.png') }}" alt="Main visual"
                    class="w-full h-full object-cover object-center" />
                </div>
              </div>
              <p class="text-sm font-semibold text-black leading-tight">Coolors</p>
              <p class="text-xs text-gray-400">coolors.co</p>
            </div>

            <!-- COLOR PALETTE -->
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
              <!-- IMAGGE -->
              <div class="h-[280px] bg-gray-100 overflow-hidden relative">
                <img src="{{ asset('images/Palete.png') }}" alt="Main visual"
                  class="w-full h-full object-cover object-center" />
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- HOW IT WORKS -->
      <div class="flex flex-col gap-6 -mt-14">
        <p class="text-lm font-bold text-black uppercase font-['Montserrat',_serif]">How it works?</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

          <!-- Card 1 -->
          <div
            class="group bg-gray-100 border border-gray-100 rounded-2xl p-6 flex flex-col gap-4 shadow-sm transition-all duration-300 ease-in-out hover:scale-[1.03] hover:shadow-md cursor-default">
            <div
              class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 group-hover:bg-black transition-colors duration-300">
              <x-heroicon-o-plus class="w-5 h-5 text-gray-600 group-hover:text-white transition-colors duration-300"
                style="stroke-width: 1.5" />
            </div>
            <div>
              <p class="font-bold text-sm mb-1">Create Folders</p>
              <p class="text-lm text-gray-500 leading-relaxed">Create folders and organize things in your own way</p>
            </div>
          </div>

          <!-- Card 2 -->
          <div
            class="group bg-gray-100 border border-gray-100 rounded-2xl p-6 flex flex-col gap-4 shadow-sm transition-all duration-300 ease-in-out hover:scale-[1.03] hover:shadow-md cursor-default">
            <div
              class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 group-hover:bg-black transition-colors duration-300">
              <x-heroicon-o-folder-open
                class="w-5 h-5 text-gray-600 group-hover:text-white transition-colors duration-300"
                style="stroke-width: 1.5" />
            </div>
            <div>
              <p class="font-bold text-sm mb-1">Manage Collections</p>
              <p class="text-lm text-gray-500 leading-relaxed">Collections allows you to keep everything separated by
                type</p>
            </div>
          </div>

          <!-- Card 3 -->
          <div
            class="group bg-gray-100 border border-gray-100 rounded-2xl p-6 flex flex-col gap-4 shadow-sm transition-all duration-300 ease-in-out hover:scale-[1.03] hover:shadow-md cursor-default">
            <div
              class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 group-hover:bg-black transition-colors duration-300">
              <x-heroicon-o-paper-clip
                class="w-5 h-5 text-gray-600 group-hover:text-white transition-colors duration-300"
                style="stroke-width: 1.5" />
            </div>
            <div>
              <p class="font-bold text-sm mb-1">Add Resources</p>
              <p class="text-lm text-gray-500 leading-relaxed">Images, fonts, typographies and more. All in one place
              </p>
            </div>
          </div>

          <!-- Card 4 -->
          <div
            class="group bg-gray-100 border border-gray-100 rounded-2xl p-6 flex flex-col gap-4 shadow-sm transition-all duration-300 ease-in-out hover:scale-[1.03] hover:shadow-md cursor-default">
            <div
              class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 group-hover:bg-black transition-colors duration-300">
              <x-heroicon-o-tag class="w-5 h-5 text-gray-600 group-hover:text-white transition-colors duration-300"
                style="stroke-width: 1.5" />
            </div>
            <div>
              <p class="font-bold text-sm mb-1">Work with Tags</p>
              <p class="text-lm text-gray-500 leading-relaxed">Tag your favorites to keep track of them</p>
            </div>
          </div>

          <!-- Card 5 -->
          <div
            class="group bg-gray-100 border border-gray-100 rounded-2xl p-6 flex flex-col gap-4 shadow-sm transition-all duration-300 ease-in-out hover:scale-[1.03] hover:shadow-md cursor-default">
            <div
              class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 group-hover:bg-black transition-colors duration-300">
              <x-heroicon-o-magnifying-glass
                class="w-5 h-5 text-gray-600 group-hover:text-white transition-colors duration-300"
                style="stroke-width: 1.5" />
            </div>
            <div>
              <p class="font-bold text-sm mb-1">Search your resources</p>
              <p class="text-lm text-gray-500 leading-relaxed">Searching by name or tag will make it easier for you to
                find everything</p>
            </div>
          </div>

          <!-- Card 6 -->
          <div
            class="group bg-gray-100 border border-gray-100 rounded-2xl p-6 flex flex-col gap-4 shadow-sm transition-all duration-300 ease-in-out hover:scale-[1.03] hover:shadow-md cursor-default">
            <div
              class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 group-hover:bg-black transition-colors duration-300">
              <x-heroicon-o-queue-list
                class="w-5 h-5 text-gray-600 group-hover:text-white transition-colors duration-300"
                style="stroke-width: 1.5" />
            </div>
            <div>
              <p class="font-bold text-sm mb-1">Stay organized</p>
              <p class="text-lm text-gray-500 leading-relaxed">Delete what you don't need, update information, organise
                as you like</p>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- Third section-->
  <section class="text-black px-6 md:px-16 pt-18 relative bg-white">

    <!-- Background -->
    <div class="absolute inset-x-0 bottom-0 h-[30%] flex flex-col">
      <div class="flex-1 bg-white"></div>
      <div class="flex-1 bg-black"></div>
    </div>

    <!-- Image -->
    <div class="max-w-7xl mx-auto w-full flex justify-center relative z-10 pb-18">
      <div class="flex flex-col items-center">
        <p class="font-bold text-5xl mb-3 text-center">Capture ideas and inspiration.</p>
        <p class="text-center text-black">Centralize what you need, see the big picture and the details in
          <strong><em>one place</em></strong>
        </p>
        <img src="{{ asset('images/nd-dash.png') }}" class="w-[1100px] object-contain mt-4" />
      </div>
    </div>

  </section>

  <!-- Fourth section -->
  <section class="bg-black text-white px-6 md:px-16 py-10">
    <div class="max-w-7xl mx-auto w-full flex flex-col items-center gap-16">

      <!-- Title -->
      <div class="text-center">
        <h2 class="font-bold text-4xl md:text-5xl mb-4">
          Made for creative work.
        </h2>
        <p class="text-white">Nodefold has space for your favorites</p>
      </div>

      <!-- Cards -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6 w-full text-white">

        <!-- Card 1 -->
        <div class="flex flex-col items-center gap-3">
          <p class="font-semibold text-sm">Photos</p>
          <img src="{{ asset('images/card-1.jpeg') }}"
            class="w-full h-72 object-cover rounded-2xl transition-transform duration-300 ease-in-out hover:scale-105" />
          <p class="text-sm text-center">Upload photos from your device</p>
        </div>

        <!-- Card 2 -->
        <div class="flex flex-col items-center gap-3">
          <p class="font-semibold text-sm">Web</p>
          <img src="{{ asset('images/card-2.png') }}"
            class="w-full, h-72 object-cover rounded-2xl transition-transform duration-300 ease-in-out hover:scale-105" />
          <p class="text-sm text-center">Save the web pages you need</p>
        </div>

        <!-- Card 3 -->
        <div class="flex flex-col items-center gap-3">
          <p class="font-semibold text-sm">Fonts</p>
          <img src="{{ asset('images/card-3.jpg') }}"
            class="w-full h-72 object-cover rounded-2xl transition-transform duration-300 ease-in-out hover:scale-105" />
          <p class="text-sm text-center">Keep track of your favorite fonts</p>
        </div>

        <!-- Card 4 -->
        <div class="flex flex-col items-center gap-3">
          <p class="font-semibold text-sm">Others</p>
          <img src="{{ asset('images/card-4.jpeg') }}"
            class="w-full h-72 object-cover rounded-2xl transition-transform duration-300 ease-in-out hover:scale-105" />
          <p class="text-sm text-center">Icons and color also have a place here</p>
        </div>

      </div>
    </div>
  </section>

  <!-- Final section -->
  <section class="bg-black text-white px-6 md:px-16 py-18">
    <div class="max-w-7xl mx-auto w-full flex flex-col items-center gap-6">

      <!-- Logo -->
      <div class="h-28 overflow-hidden flex justify-center mb-10">
        <dotlottie-wc src="https://lottie.host/7f3129a3-cb27-4f59-94a7-e1b00a792639/7yEPP2VRSt.lottie"
          class="w-48 h-48" autoplay loop></dotlottie-wc>
      </div>
      <!-- Text -->
      <p class="font-bold text-3xl -mt-10">Ready to start? Try for free.</p>

      <!-- Button -->
      <a href="{{ route('register') }}"
        class="bg-white text-black px-12 py-3 mt-10 rounded-3xl font-semibold hover:bg-gray-200 transition">
        Sign up
      </a>

      <!-- Footer links -->
      <div class="flex gap-6 text-sm text-gray-200 mt-36 mb-5">
        <a href="#" class="hover:text-gray-200 transition">More</a>
        <a href="#" class="hover:text-gray-200 transition">Terms</a>
        <a href="#" class="hover:text-gray-200 transition">Privacy</a>
      </div>

    </div>
  </section>


</body>

</html>

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
  <section class="bg-gray-50 text-black px-6 md:px-16 py-24">
    <div class="max-w-6xl mx-auto w-full flex flex-col items-center gap-10">

      <!-- TITLE -->
      <h2 class="text-4xl md:text-4xl font-bold text-center">
        Start with a empty space, like a blank sheet of paper.
      </h2>

      <!-- CENTER -->
      <div class="w-full rounded-3xl overflow-hidden grid grid-cols-2 shadow-lg h-[440px]">

        <!-- IMG -->
        <div class="bg-white border border-gray-200 rounded-l-3xl overflow-hidden">
          <img src="{{ asset('images/Empty-dashboard.jpg') }}"
            class="w-full h-full object-cover object-[0%_0%] scale-[2] origin-top-left" />
        </div>

        <!-- TXT -->
        <div class="bg-[#000000] flex px-10">
          <p class="text-white mt-8 font-bold text-2xl md:text-3xl leading-tight">
            Your resources will<br>be stored and <br> displayed in this <br> space.
          </p>
        </div>
      </div>

      <!-- CARDS -->
      <div class="w-full grid grid-cols-5 gap-4">

        <!-- CARD 1 -->
        <div class="bg-white border border-gray-200 rounded-2xl p-5 flex flex-col justify-between gap-6 shadow-sm">
          <div class="flex flex-col gap-2">
            <x-heroicon-o-plus class="w-5 h-5" style="stroke-width: 1.5" />
            <p class="text-sm">Create new folder</p>
          </div>
          <p class="text-sm font-bold">Build your project structure</p>
        </div>

        <!-- CARD 2 -->
        <div class="bg-white border border-gray-200 rounded-2xl p-5 flex flex-col justify-between gap-6 shadow-sm">
          <div class="flex flex-col gap-2">
            <div class="flex flex-row gap-2">
              <x-heroicon-o-folder-open class="w-5 h-5" style="stroke-width: 1.5" />
              <p>Collection</p>
            </div>
            <div class="text-sm text-black">
              <p class="pl-6 flex flex-row gap-2"> <x-heroicon-o-folder class="w-5 h-5"
                  style="stroke-width: 1.5" />Fonts</p>
            </div>
          </div>
          <p class="text-sm font-bold">Stay organized with custom collections</p>
        </div>

        <!-- CARD 3 -->
        <div class="bg-white border border-gray-200 rounded-2xl p-5 flex flex-col justify-between gap-6 shadow-sm">
          <div class="flex flex-col gap-2">
            <x-heroicon-o-pencil class="w-5 h-5" style="stroke-width: 1.5" />
            <p class="text-sm">Rename project</p>
          </div>
          <p class="text-sm font-bold">Rename each folder as needed</p>
        </div>

        <!-- CARD 4 -->
        <div class="bg-white border border-gray-200 rounded-2xl p-5 flex flex-col justify-between gap-6 shadow-sm">
          <div class="flex flex-col gap-2">
            <x-heroicon-o-paper-clip class="w-5 h-5" style="stroke-width: 1.5" />
            <p class="text-sm">Add resource</p>
          </div>
          <p class="text-sm font-bold">You can add images, web pages and more</p>
        </div>

        <!-- CARD 5 -->
        <div class="bg-white border border-gray-200 rounded-2xl p-5 flex flex-col justify-between gap-6 shadow-sm">
          <div class="flex flex-col gap-2">
            <x-heroicon-o-magnifying-glass class="w-5 h-5" style="stroke-width: 1.5" />
            <p class="text-sm">Search</p>
          </div>
          <p class="text-sm font-bold">Search what you need by name or tag</p>
        </div>

      </div>

    </div>
  </section>

  <!-- SVG DIVISOR -->

  <!-- Third section-->
  <section class="text-black px-6 md:px-16 pt-18 relative bg-gray-50">

    <!-- Background -->
    <div class="absolute inset-x-0 bottom-0 h-[30%] flex flex-col">
      <div class="flex-1 bg-gray-50"></div>
      <div class="flex-1 bg-black"></div>
    </div>

    <!-- Image -->
    <div class="max-w-7xl mx-auto w-full flex justify-center relative z-10 pb-18">
      <div class="flex flex-col items-center">
        <p class="font-bold text-5xl mb-3 text-center">Capture ideas and inspiration.</p>
        <p class="text-center text-black">Centralize your resources: see the big picture and the details in
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
        <p class="text-white">Nodefold let you safe diferent resources for your projects</p>
      </div>

      <!-- Cards -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6 w-full text-white">

        <!-- Card 1 -->
        <div class="flex flex-col items-center gap-3">
          <p class="font-semibold text-sm">Photos</p>
          <img src="{{ asset('images/card-1.jpeg') }}" class="w-full h-72 object-cover rounded-2xl" />
          <p class="text-sm text-center">Upload photos from your device</p>
        </div>

        <!-- Card 2 -->
        <div class="flex flex-col items-center gap-3">
          <p class="font-semibold text-sm">Web</p>
          <img src="{{ asset('images/card-2.jpeg') }}" class="w-full , h-72 object-cover rounded-2xl" />
          <p class="text-sm text-center">Save the web pages you need</p>
        </div>

        <!-- Card 3 -->
        <div class="flex flex-col items-center gap-3">
          <p class="font-semibold text-sm">Fonts</p>
          <img src="{{ asset('images/card-3.jpg') }}" class="w-full h-72 object-cover rounded-2xl" />
          <p class="text-sm text-center">Keep track of your favorite fonts</p>
        </div>

        <!-- Card 4 -->
        <div class="flex flex-col items-center gap-3">
          <p class="font-semibold text-sm">Others</p>
          <img src="{{ asset('images/card-4.jpeg') }}" class="w-full h-72 object-cover rounded-2xl" />
          <p class="text-sm text-center">Icons and color also have a place here</p>
        </div>

      </div>
    </div>
  </section>

  <!-- Final section -->
  <section class="bg-gray-50 text-black px-6 md:px-16 py-18">
    <div class="max-w-7xl mx-auto w-full flex flex-col items-center gap-6">

      <!-- Logo -->
      <div class="h-28 overflow-hidden flex justify-center mb-10">
        <dotlottie-wc src="https://lottie.host/67fb3ab4-4d5c-47dd-91ce-4d70dca3b40c/F693QrzY3H.lottie"
          class="w-48 h-48" autoplay loop></dotlottie-wc>
      </div>
      <!-- Text -->
      <p class="font-bold text-3xl -mt-10">Ready to start? Try for free.</p>

      <!-- Button -->
      <a href="{{ route('register') }}"
        class="bg-black text-white px-12 py-3 mt-10 rounded-3xl font-semibold hover:bg-gray-800 transition">
        Sign up
      </a>

      <!-- Footer links -->
      <div class="flex gap-6 text-sm text-gray-400 mt-36 mb-5">
        <a href="#" class="hover:text-black transition">More</a>
        <a href="#" class="hover:text-black transition">Terms</a>
        <a href="#" class="hover:text-black transition">Privacy</a>
      </div>

    </div>
  </section>


</body>

</html>

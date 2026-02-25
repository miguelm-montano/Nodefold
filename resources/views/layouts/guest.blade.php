<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.9.3/dist/dotlottie-wc.js" type="module"></script>
</head>

<body class="font-['Montserrat',_serif] text-gray-900 antialiased">
  <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-black dark:bg-gray-900">
    <div class="flex flex-col items-center text-center">
      <a href="/" wire:navigate>
        <a href="/" wire:navigate class="flex justify-center">
          <div class="flex justify-center h-28 overflow-hidden -mt-20">
            <dotlottie-wc src="https://lottie.host/7f3129a3-cb27-4f59-94a7-e1b00a792639/7yEPP2VRSt.lottie"
              class="w-72 h-72 -mt-16" autoplay loop>
            </dotlottie-wc>
          </div>
        </a>
      </a>
      @if (isset($header))
        <div class="mt-3">
          {{ $header }}
        </div>
      @endif
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-10 bg-white dark:bg-gray-800 shadow-md overflow-hidden rounded-2xl">
      {{ $slot }}
    </div>
  </div>
</body>

</html>

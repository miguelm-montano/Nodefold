<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Nodefold') }}</title>

  <link rel="icon" type="image/svg+xml"
    href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' viewBox='0 0 24 24'><rect width='8' height='8' x='3' y='3' fill='black' rx='1.5' ry='1.5'/><rect width='8' height='8' x='13' y='3' fill='black' rx='1.5' ry='1.5'/><rect width='8' height='8' x='3' y='13' fill='black' rx='1.5' ry='1.5'/><rect width='8' height='8' x='13' y='13' fill='black' rx='1.5' ry='1.5'/></svg>">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>

<body class="font-sans antialiased">
  <div class="min-h-screen bg-white">

    <!-- Page Content -->
    <main>
      {{ $slot }}
    </main>
  </div>
  @livewireScripts
</body>

</html>

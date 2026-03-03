<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>404 - Nodefold</title>
  @vite(['resources/css/app.css'])
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body class="font-['Montserrat',_serif] relative flex flex-col items-center justify-between h-screen overflow-hidden">

  <!-- FONDO -->
  <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
    style="background-image: url('{{ asset('images/Error404.webp') }}')">
  </div>

  <div class="relative z-10 flex flex-col items-center h-full py-16 w-full gap-8">

    <!-- TOP -->
    <div class="flex flex-col items-center">
      <h1 class="text-3xl font-bold text-white">Nodefold</h1>
      <p class="font-bold text-white -mt-16 mb-10" style="font-size: 8rem">oops!</p>
    </div>

    <!-- 404 -->
    <div class="flex flex-col items-center">
      <p class="font-bold text-white text-2xl mt-10">404</p>
    </div>

    <!-- BOTTOM -->
    <div class="flex flex-col items-center gap-6 mt-auto">
      <p class="text-gray-300 font-regular text-ml">We couldn't find the page you were looking for</p>
      <a href="{{ route('dashboard') }}"
        class="px-8 py-3 bg-white text-black font-semibold text-sm rounded-3xl hover:bg-gray-200 transition">
        Go back
      </a>
    </div>

  </div>

</body>

</html>

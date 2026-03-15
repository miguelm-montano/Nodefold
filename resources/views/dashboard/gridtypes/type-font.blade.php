@php $fontName = $resource->getFontName() @endphp

@if ($fontName)
  <link href="https://fonts.googleapis.com/css2?family={{ urlencode($fontName) }}&display=swap" rel="stylesheet">
@endif

<div
  class="relative bg-gray-50 border border-gray-100 rounded-lg p-5 flex flex-col gap-3 hover:bg-gray-100 transition cursor-pointer">
  <p class="text-xs text-gray-400 uppercase tracking-widest">Font</p>
  <p class="text-3xl text-black leading-tight" style="font-family: '{{ $fontName ?? $resource->title }}', sans-serif;">
    Aa
  </p>
  <p class="text-lg text-black" style="font-family: '{{ $fontName ?? $resource->title }}', sans-serif;">
    ABCDEFGHIJKLM<br>abcdefghijklm<br>0123456789
  </p>
  <p class="text-xs text-gray-400 truncate mt-1">{{ $fontName ?? $resource->title }}</p>
</div>

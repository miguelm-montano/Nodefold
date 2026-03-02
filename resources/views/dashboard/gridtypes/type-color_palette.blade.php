<div
  class="relative rounded-lg overflow-hidden cursor-pointer hover:scale-[1.02] transition duration-300 ease-out transform-gpu">

  <!-- FRANJAS DE COLORES -->
  <div class="flex w-full h-80">
    @foreach ($resource->color_data ?? [] as $color)
      <div class="flex-1 h-full" style="background-color: #{{ $color }}"></div>
    @endforeach
  </div>

  <!-- CÓDIGOS HEX -->
  <div class="flex w-full bg-white border border-t-0 border-gray-100 rounded-b-lg">
    @foreach ($resource->color_data ?? [] as $color)
      <div class="flex-1 py-2 flex flex-col items-center">
        <span class="text-[9px] text-gray-500 font-mono">#{{ strtoupper($color) }}</span>
      </div>
    @endforeach
  </div>

</div>

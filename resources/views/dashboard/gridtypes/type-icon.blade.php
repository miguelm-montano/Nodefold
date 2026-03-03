<div
  class="relative bg-gray-50 border border-gray-100 rounded-lg p-5 flex flex-col items-center justify-center gap-3 hover:bg-gray-100 transition cursor-pointer">
  <img src="{{ $resource->url }}" width="64" height="64" class="w-16 h-16 object-contain"
    style="min-width: 64px; min-height: 64px;">
  <p class="text-xs text-gray-400 truncate w-full text-center">{{ $resource->title }}</p>
</div>

<div class="relative bg-gray-100 rounded-lg p-4 flex flex-col gap-3 hover:bg-gray-200 transition cursor-pointer">
  <div class="flex items-center gap-2">
    <img src="https://www.google.com/s2/favicons?domain={{ parse_url($resource->url, PHP_URL_HOST) }}&sz=32"
      class="w-5 h-5 rounded" onerror="this.style.display='none'">
  </div>
  <p class="text-sm font-medium text-black leading-tight line-clamp-2">{{ $resource->title }}</p>
  <p class="text-xs text-gray-400 truncate">{{ parse_url($resource->url, PHP_URL_HOST) }}</p>
</div>

<main class="flex-1 flex flex-col text-gray-300">
  <!-- HEADER DEL DASHBOARD -->
  <div class="px-6 pt-8 pb-4  flex items-center justify-between">

    <!-- IZQUIERDA -->
    <div class="flex items-center gap-2 ml-0.5">

      @if ($prevFolder)
        <a href="{{ route('dashboard', ['folder' => $prevFolder->id]) }}">
          <span class="text-gray-400 cursor-pointer hover:text-black transition">
            <x-heroicon-o-chevron-left class="w-5 h-5" style="stroke-width: 2" />
          </span>
        </a>
      @else
        <span class="text-gray-200 ">
          <x-heroicon-o-chevron-left class="w-5 h-5" style="stroke-width: 2" />
        </span>
      @endif

      @if ($nextFolder)
        <a href="{{ route('dashboard', ['folder' => $nextFolder->id]) }}">
          <span class="text-gray-400 cursor-pointer hover:text-black transition">
            <x-heroicon-o-chevron-right class="w-5 h-5" style="stroke-width: 2" />
          </span>
        </a>
      @else
        <span class="text-gray-200 ">
          <x-heroicon-o-chevron-right class="w-5 h-5" style="stroke-width: 2" />
        </span>
      @endif

      <h2 class="text-sm text-black font-['Montserrat',_serif]">
        {{ $selectedFolder->name ?? 'All resources' }}
      </h2>
    </div>

    <!-- DERECHA -->
    <div class="flex items-center gap-4 mr-7">
      <button
        onclick="window.dispatchEvent(
        new CustomEvent('open-resource-modal', {
            detail: {
                folderId: {{ request('folder') ?? 'null' }},
                folderName: '{{ optional($folders->firstWhere('id', request('folder')))->name ?? '' }}'
            }
        })
    )">
        <x-heroicon-o-plus class="w-5 h-5 text-gray-400" />
      </button>
      <x-heroicon-o-adjustments-horizontal class="w-5 h-5 text-gray-400" />

      <input type="text" placeholder="Search..."
        class="border border-gray-100 rounded-lg px-3 py-1.5 text-sm focus:outline-none bg-gray-100">
    </div>

  </div>
  <!-- SVG -->
  <div class="flex-1 p-8 overflow-y-auto">

    @if ($resources->isEmpty())
      <div class="flex flex-col items-center justify-center h-full text-gray-300 -mt-20 -ml-10">
        <x-heroicon-o-folder-plus class="w-32 h-32 mb-4" style="stroke-width: 0.4" />
        <p class="text-sm font-['Montserrat',_serif] -mt-6">
          No resources yet
        </p>
      </div>
    @else
      <div id="grid-masonry" style="position: relative;">
        @foreach ($resources as $resource)
          @if ($resource->image_path)
            <div class="grid-item" style="width: 24%; margin-bottom: 16px;"
              @click="selectedResource = {
                    id: {{ $resource->id }},
                    image: '{{ asset('storage/' . $resource->image_path) }}',
                    title: '{{ $resource->title }}',
                    type: '{{ $resource->type }}',
                    description: '{{ $resource->description }}',
                    url: {{ json_encode($resource->url) }},
                    folder: '{{ optional($resource->folder)->name }}',
                    folder_id: {{ $resource->folder_id ?? 'null' }},
                    tags: {{ json_encode($resource->tags->pluck('name')) }}
                }">
              <div class="relative transition duration-300 ease-out hover:scale-[1.02] transform-gpu">
                <img src="{{ asset('storage/' . $resource->image_path) }}"
                  class="w-full object-cover block rounded-lg">
              </div>
            </div>
          @endif
        @endforeach
      </div>
    @endif

  </div>
</main>

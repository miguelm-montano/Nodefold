<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">
      Dashboard
    </h2>
  </x-slot>
  <script>
    function dashboardData() {
      return {
        selectedResource: null,
        selectedResourceId: null,
        showDeleteModal: false,
        deleteType: null,
        selectedFolder: null,
        editing: false,
        editResource: {},
        openDeleteModal(type, id) {
          this.deleteType = type
          if (type === 'folder') {
            this.selectedFolder = id
          }
          if (type === 'resource') {
            this.selectedResourceId = id
          }
          this.showDeleteModal = true
        },
        async saveResource() {
          console.log('selectedResource completo:', this.selectedResource)

          const payload = {
            title: this.editResource.title,
            type: this.editResource.type,
            description: this.editResource.description ?? null,
            url: this.editResource.url || null,
            folder_id: this.editResource.folder_id ?? null,
            tags: this.editResource.tags ?? ''
          };

          console.log('payload', payload);

          const response = await fetch(`/resources/${this.editResource.id}`, {
            method: 'PATCH',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
              'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
          });

          if (response.ok) {
            const updated = await response.json();
            this.selectedResource = {
              ...updated,
              tags: updated.tags.map(t => t.name)
            };
            this.editing = false;
          } else {
            const errors = await response.json();
            console.log('Validation errors:', errors);
          }
        }
      }
    }
  </script>

  <div x-data="dashboardData()" class="flex h-screen overflow-hidden">

    <!-- LEFT BAR -->
    <aside class="w-64 border-r p-8 flex flex-col">

      <h1 class="text-3xl font-bold mb-12 font-['Montserrat',_serif]">NAME</h1>

      <ul class="space-y-2.5 mb-10 text-sm font-['Montserrat',_serif]">
        <li class="flex items-center gap-1 "><span> <x-heroicon-o-archive-box class="w-5 h-5"
              style="stroke-width: 1" /></span> All</li>
        <li class="flex items-center gap-1 "><span> <x-heroicon-o-bookmark-slash class="w-5 h-5 -mt-0.5"
              style="stroke-width: 1" /></span>Untagged</li>
        <li class="flex items-center gap-1"><span> <x-heroicon-o-bookmark class="w-5 h-5 -mt-0.5"
              style="stroke-width: 1" /></span>All tags</li>
      </ul>

      <!-- FOLDERS SECTION -->
      <p class="text-gray-500 text-xs mb-2 font-['Montserrat',_serif]">Folders</p>

      <!-- Create new folder -->
      <div x-data="{ open: false }" class="mb-6 min-h-[2rem]">

        <!-- BUTTON NEW FOLDER  -->
        <button x-show="!open" @click="open = true; $nextTick(() => $refs.input.focus())"
          class="text-sm text-gray-500 hover:text-black font-['Montserrat',_serif]">
          + Create new folder
        </button>

        <!-- Input -->
        <form x-show="open" @submit="open = false" action="{{ route('folders.store') }}" method="POST" class="mt-2">
          @csrf

          <input x-ref="input" type="text" name="name" placeholder="Folder name"
            class="border rounded p-2 w-full text-sm" @keydown.escape="open = false" @blur="open = false" required>
        </form>

      </div>

      <!-- List folders -->
      <ul class="space-y-3 font-['Montserrat',_serif]">
        @foreach ($folders->whereNull('parent_id') as $folder)
          <li x-data="{
              openChild: false,
              open: true,
              openRename: false,
              openMenu: false
          }" class="space-y-1">

            <!-- FOLDER PADRE -->
            <div class="flex items-center justify-between group px-2  rounded-lg hover:bg-gray-100">

              <a href="{{ route('dashboard', ['folder' => $folder->id]) }}"
                class="flex items-center space-x-1 cursor-pointer select-none flex-1">

                <span>
                  <x-heroicon-o-folder-open class="w-5 h-5 -mt-0.5" style="stroke-width: 1" />
                </span>

                <span class="text-sm">{{ $folder->name }}</span>
              </a>

              <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition">

                <!-- BOTÓN + -->
                <button @click="openChild = true" class="text-gray-400 hover:text-black text-xl -mt-0.2">
                  +
                </button>

                <div class="relative">

                  <button type="button" @click="openMenu = !openMenu" class="text-gray-400 hover:text-black text-sm">
                    ⋯
                  </button>

                  <!-- MINI MENU -->
                  <div x-show="openMenu" @click.away="openMenu = false" x-cloak
                    class="absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-lg border z-50 translate-x-20">

                    <button class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 flex items-center gap-2"
                      @click="openMenu = false; openRename = true">
                      <span> <x-heroicon-o-pencil class="w-4 h-4" style="stroke-width: 1" /></span>
                      Rename
                    </button>

                    <button class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 flex items-center gap-2"
                      @click="openMenu = false; window.dispatchEvent(new CustomEvent('open-resource-modal', {
                      detail: {
                      folderId: {{ $folder->id }},
                      folderName: '{{ $folder->name }}'
                      }
                      }))
                      ">
                      <span> <x-heroicon-o-paper-clip class="w-4 h-4" style="stroke-width: 1" /></span>
                      Add resource
                    </button>

                    <hr>

                    <button
                      class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-gray-100 flex items-center gap-2"
                      @click="openMenu = false; openDeleteModal('folder', {{ $folder->id }})">
                      <span><x-heroicon-o-trash class="w-4 h-4" style="stroke-width: 1" /></span>
                      Delete folder
                    </button>

                  </div>
                </div>

              </div>

            </div>

            <!-- INPUT HIJO -->
            <div x-show="openChild" class="ml-8">
              <form action="{{ route('folders.store') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Subfolder name"
                  class="border rounded p-1 w-full text-sm" @keydown.escape="openChild = false"
                  @blur="openChild = false" required>
                <input type="hidden" name="parent_id" value="{{ $folder->id }}">
              </form>
            </div>

            <!-- HIJOS -->
            <div x-show="open">
              @foreach ($folder->children as $child)
                <div class="ml-6 flex items-center justify-between py-1 text-sm hover:bg-gray-100 rounded group">

                  <!-- IZQUIERDA CLICKEABLE -->
                  <a href="{{ route('dashboard', ['folder' => $child->id]) }}"
                    class="flex items-center space-x-1 flex-1">

                    <span>
                      <x-heroicon-o-folder class="w-5 h-5 -mt-0.5 ml-3" style="stroke-width: 1" />
                    </span>

                    <span>{{ $child->name }}</span>
                  </a>

                  <!-- BOTÓN DELETE -->
                  <button class="opacity-0 group-hover:opacity-40 transition-opacity duration-200 mr-2"
                    @click.stop="openDeleteModal('folder', {{ $child->id }})">
                    ✕
                  </button>

                </div>
              @endforeach
            </div>
          </li>
        @endforeach
      </ul>

      <x-delete-folder-modal />
      <x-resource-modal :folders="$folders" />
    </aside>

    <!-- CENTER DASHBOARD -->
    <main class="flex-1 flex flex-col text-gray-300">
      <!-- HEADER DEL DASHBOARD -->
      <div class="px-6 pt-8 pb-4  flex items-center justify-between">

        <!-- IZQUIERDA -->
        <div class="flex items-center gap-2 ml-0.5">
          <span class="text-gray-400 cursor-pointer"><x-heroicon-o-chevron-left class="w-5 h-5"
              style="stroke-width: 2" /></span>
          <span class="text-gray-400 cursor-pointer"><x-heroicon-o-chevron-right class="w-5 h-5"
              style="stroke-width: 2" /></span>

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
          <div class="flex flex-col items-center justify-center h-full text-gray-400">
            <x-heroicon-o-folder-plus class="w-24 h-24 mb-4" style="stroke-width: 0.6" />
            <p class="text-sm font-['Montserrat',_serif]">
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

    <!-- RIGHT BAR -->
    @include('dashboard.partials.right-sidebar')

  </div>
</x-app-layout>

<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">
      Dashboard
    </h2>
  </x-slot>

  <div class="flex h-[80vh]">

    <!-- LEFT BAR -->
    <aside x-data="{
        showDeleteModal: false,
        selectedFolder: null
    }"
      @open-delete.window="
        selectedFolder = $event.detail;
        showDeleteModal = true"
      class="w-64 h-screen border-r p-8 flex flex-col">

      <h1 class="text-3xl font-bold mb-12 font-['Montserrat',_serif]">LOOM</h1>

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

              <div @click="open = !open" class="flex items-center space-x-1 cursor-pointer select-none">

                <!-- Flecha -->
                <span class="text-xs transition-transform duration-200" :class="{ 'rotate-90': open }">

                </span>

                <span><x-heroicon-o-folder-open class="w-5 h-5 -mt-0.5" style="stroke-width: 1" /></span>
                <span class="text-sm">{{ $folder->name }}</span>
              </div>

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
                      @click="openMenu = false; $dispatch('open-delete', {{ $folder->id }})">
                      <span> <x-heroicon-o-trash class="w-4 h-4" style="stroke-width: 1" /></span>
                      Delete
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
                  <div class="flex items-center space-x-1">
                    <span><x-heroicon-o-folder class="w-5 h-5 -mt-0.5 ml-3" style="stroke-width: 1" /></span>
                    <span>{{ $child->name }}</span>
                  </div>

                  <form action="{{ route('folders.destroy', $child) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="opacity-0 group-hover:opacity-40 transition-opacity duration-200 mr-2">
                      ✕
                    </button>
                  </form>
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
        <div class="flex items-center gap-2 ml-4">
          <span class="text-gray-400 cursor-pointer"><x-heroicon-o-chevron-left class="w-5 h-5"
              style="stroke-width: 2" /></span>
          <span class="text-gray-400 cursor-pointer"><x-heroicon-o-chevron-right class="w-5 h-5"
              style="stroke-width: 2" /></span>

          <h2 class="text-sm text-black">
            Carpeta
          </h2>
        </div>

        <!-- DERECHA -->
        <div class="flex items-center gap-4 mr-12">
          <x-heroicon-o-magnifying-glass class="w-5 h-5 text-gray-400" />
          <x-heroicon-o-adjustments-horizontal class="w-5 h-5 text-gray-400" />

          <input type="text" placeholder="Search..."
            class="border border-gray-100 rounded-lg px-3 py-1.5 text-sm focus:outline-none bg-gray-100">
        </div>

      </div>
      <!-- SVG -->
      <div class="flex-1 flex flex-col items-center justify-center -ml-10">
        <x-heroicon-o-folder-plus class="w-32 h-32" style="stroke-width: 0.6" />
        <p class="text-sm font-['Montserrat',_serif]">Create new folder</p>
      </div>
    </main>

    <!-- RIGHT BAR -->
    <aside class="w-72 border-l p-4 hidden">
      <!-- Detalles del recurso seleccionado -->
    </aside>

  </div>
</x-app-layout>

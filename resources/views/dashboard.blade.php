<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">
      Dashboard
    </h2>
  </x-slot>

  <div class="flex h-[80vh]">

    <!-- LEFT BAR -->
    <aside class="w-64 h-screen border-r p-7 flex flex-col">

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
          <li x-data="{ openChild: false, open: true }" class="space-y-1">

            <!-- FOLDER PADRE -->
            <div class="flex items-center justify-between group px-2 py-1 rounded hover:bg-gray-100">

              <div @click="open = !open" class="flex items-center space-x-1 cursor-pointer select-none">

                <!-- Flecha -->
                <span class="text-xs transition-transform duration-200" :class="{ 'rotate-90': open }">

                </span>

                <span><x-heroicon-o-folder-open class="w-5 h-5 -mt-0.5" style="stroke-width: 1" /></span>
                <span class="text-sm">{{ $folder->name }}</span>
              </div>

              <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition">

                <!-- BOTÓN + -->
                <button @click="openChild = true" class="text-gray-400 hover:text-black text-sm">
                  +
                </button>

                <!-- DELETE -->
                <div x-data="{ open: false }" class="relative">

                  <!-- BOTÓN DELETE -->
                  <button type="button" @click="open = true" class="text-gray-400 hover:text-red-500 text-sm">
                    ✕
                  </button>

                  <!-- MODAL -->
                  <div x-show="open" x-cloak
                    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 font-['Montserrat',_serif]">

                    <div @click.away="open = false" class="bg-white p-5 rounded-xl shadow-lg w-80">

                      <h2 class="text-lg font-semibold mb-4">
                        Are you sure?
                      </h2>

                      <p class="text-sm text-gray-500 mb-6">
                        This folder and all resources will be permanently removed.
                      </p>

                      <div class="flex justify-end gap-3">

                        <!-- CANCEL -->
                        <button type="button" @click="open = false"
                          class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">
                          Cancel
                        </button>

                        <!-- DELETE FORM -->
                        <form action="{{ route('folders.destroy', $folder) }}" method="POST">
                          @csrf
                          @method('DELETE')

                          <button type="submit" class="px-3 py-1 bg-black text-white rounded hover:bg-red-600">
                            Delete
                          </button>
                        </form>

                      </div>
                    </div>
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

    </aside>

    <!-- CENTER DASHBOARD -->
    <main class="flex-1 p-6 flex items-center justify-center text-gray-300">
      <div class="flex flex-col items-center">
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

    <aside class="w-64 border-r py-8 px-6 flex flex-col">

      <h1 class="text-3xl font-bold mb-12 px-2 font-['Montserrat',_serif]">NAME</h1>

      <ul class="space-y-2.5 px-2 mb-10 text-sm font-['Montserrat',_serif]">
        <li class="flex items-center gap-1 "><span> <x-heroicon-o-archive-box class="w-5 h-5"
              style="stroke-width: 1" /></span> All</li>
        <li class="flex items-center gap-1 "><span> <x-heroicon-o-bookmark-slash class="w-5 h-5 -mt-0.5"
              style="stroke-width: 1" /></span>Untagged</li>
        <li class="flex items-center gap-1"><span> <x-heroicon-o-bookmark class="w-5 h-5 -mt-0.5"
              style="stroke-width: 1" /></span>All tags</li>
      </ul>

      <!-- FOLDERS SECTION -->
      <p class="text-gray-500 text-xs mb-2 px-2 font-['Montserrat',_serif]">Folders</p>

      <!-- Create new folder -->
      <div x-data="folderCreator()" class="mb-6 min-h-[2rem] px-2">

        <!-- BUTTON -->
        <button x-show="!open" x-transition.opacity.duration.200ms @click="openForm()"
          class="text-sm text-gray-500 hover:text-black transition font-['Montserrat',_serif]">
          + Create new folder
        </button>

        <!-- FORM -->
        <form x-show="open" x-transition.scale.origin.top.duration.150ms @submit.prevent="createFolder"
          class="mt-2 space-y-1">

          <input x-ref="input" type="text" x-model="name" placeholder="Folder name"
            class="border rounded-lg px-3 py-2 w-full text-sm focus:ring-1 focus:ring-black focus:outline-none transition"
            @keydown.escape="closeForm">

          <!-- ERROR -->
          <p x-show="error" x-transition.opacity class="text-xs text-red-500" x-text="error">
          </p>

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

      <!-- Profile Section -->
      <div class="mt-auto pt-3 border-t space-y-1 font-['Montserrat',_serif]">

        <!-- PROFILE -->
        <a href="{{ route('profile') }}"
          class="w-full px-2 py-2 text-sm hover:bg-gray-100 rounded-lg flex items-center gap-2 transition">

          <x-heroicon-s-user-circle class="w-6 h-6" />

          <span>Profile</span>
        </a>

        <!-- LOGOUT -->
        <form method="POST" action="{{ route('logout') }}">
          @csrf

          <button type="submit"
            class="w-full px-2 py-2 text-sm hover:bg-gray-100 rounded-lg flex items-center gap-2 transition text-left">

            <x-heroicon-o-arrow-left-on-rectangle class="w-6 h-6" style="stroke-width: 1" />

            <span>Logout</span>
          </button>
        </form>

      </div>

    </aside>

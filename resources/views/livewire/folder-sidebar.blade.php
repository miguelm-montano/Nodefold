<div>
  <aside class="w-64 border-r py-8 px-6 flex flex-col h-screen">

    <h1 class="text-3xl font-bold mb-12 px-2 font-['Montserrat',_serif]">Nodefold</h1>

    <ul class="space-y-3 px-2 mb-10 text-sm font-['Montserrat',_serif]">
      <li>
        <a href="{{ route('dashboard', ['filter' => 'all']) }}" class="flex items-center justify-between gap-1">
          <span class="flex items-center gap-1">
            <x-heroicon-o-archive-box class="w-5 h-5" style="stroke-width: 1" />
            All
          </span>
          <span class="text-xs text-gray-400">{{ $allCount }}</span>
        </a>
      </li>
      <li>
        <a href="{{ route('dashboard', ['filter' => 'untagged']) }}" class="flex items-center justify-between gap-1">
          <span class="flex items-center gap-1">
            <x-heroicon-o-bookmark-slash class="w-5 h-5 -mt-0.5" style="stroke-width: 1" />
            Untagged
          </span>
          <span class="text-xs text-gray-400">{{ $untaggedCount }}</span>
        </a>
      </li>
      <li>
        <a href="{{ route('dashboard', ['filter' => 'tagged']) }}" class="flex items-center justify-between gap-1">
          <span class="flex items-center gap-1">
            <x-heroicon-o-bookmark class="w-5 h-5 -mt-0.5" style="stroke-width: 1" />
            All tags
          </span>
          <span class="text-xs text-gray-400">{{ $taggedCount }}</span>
        </a>
      </li>
    </ul>

    <!-- FOLDERS SECTION -->
    <p class="text-gray-500 text-xs mb-2 px-2 font-['Montserrat',_serif]">Folders</p>

    <!-- Create new folder -->
    <div x-data="{ open: false }" class="mb-6 min-h-[2rem] px-2" @folder-created.window="open = false"
      @click.away="open = false">

      <!-- BUTTON -->
      <button x-show="!open" x-transition.opacity.duration.200ms @click="open = true"
        class="text-sm text-gray-500 hover:text-black transition font-['Montserrat',_serif]">
        + Create new folder
      </button>

      <!-- FORM -->
      <div x-show="open" x-transition>
        <livewire:create-folder />
      </div>
    </div>

    <!-- List folders -->
    <ul class="space-y-3 font-['Montserrat',_serif]">
      @foreach ($folders->whereNull('parent_id') as $folder)
        <li x-data="{
            openChild: false,
            open: true,
            openRename: false,
            openMenu: false,
            editing: false,
            name: @js($folder->name),
        
            saveRename() {
                if (this.name.trim() === '') return;
        
                fetch('/folders/{{ $folder->id }}', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name: this.name })
                });
        
                this.editing = false;
            },
        
            cancelRename() {
                this.name = @js($folder->name);
                this.editing = false;
            }
        }" class="space-y-1">

          <!-- FOLDER PADRE -->
          <div class="flex items-center justify-between group px-2 rounded-lg hover:bg-gray-100">

            <!-- IZQUIERDA -->
            <div class="flex items-center space-x-1 flex-1">

              <span>
                <x-heroicon-o-folder-open class="w-5 h-5 -mt-0.5" style="stroke-width: 1" />
              </span>

              <!-- MODO NORMAL -->
              <span x-show="!editing" x-text="name" class="text-sm cursor-pointer"
                @click="$event.preventDefault(); window.location.href='{{ route('dashboard', ['folder' => $folder->id]) }}'">
              </span>

              <!-- MODO EDICIÓN -->
              <input x-show="editing" x-ref="renameInput" x-model="name" @keydown.enter.prevent="saveRename()"
                @keydown.escape="cancelRename()" @blur="saveRename()"
                class="text-sm border rounded px-2 py-1 w-full bg-white" />
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
                    @click="openMenu = false; editing = true; $nextTick(() => $refs.renameInput.focus())">

                    <x-heroicon-o-pencil class="w-4 h-4" style="stroke-width: 1" />
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
            <span class="text-xs text-gray-400 group-hover:hidden">
              {{ $folder->resources_count + $folder->children->sum('resources_count') }}
            </span>

          </div>

          <!-- INPUT HIJO -->
          <div x-show="openChild" class="ml-8" @click.away="openChild = false">
            <livewire:create-folder :parent_id="$folder->id" />
          </div>

          <!-- HIJOS -->
          <div x-show="open">
            @foreach ($folder->children as $child)
              <div x-data="{
                  editing: false,
                  clickTimer: null,
                  name: @js($child->name),
              
                  saveRename() {
                      if (this.name.trim() === '') return;
                      fetch('/folders/{{ $child->id }}', {
                          method: 'PUT',
                          headers: {
                              'Content-Type': 'application/json',
                              'X-CSRF-TOKEN': '{{ csrf_token() }}'
                          },
                          body: JSON.stringify({ name: this.name })
                      });
                      this.editing = false;
                  },
              
                  cancelRename() {
                      this.name = @js($child->name);
                      this.editing = false;
                  }
              }"
                class="ml-6 flex items-center justify-between py-1 text-sm hover:bg-gray-100 rounded group">

                <!-- IZQUIERDA CLICKEABLE -->
                <div class="flex items-center space-x-1 flex-1">
                  <span>
                    <x-heroicon-o-folder class="w-5 h-5 -mt-0.5 ml-3" style="stroke-width: 1" />
                  </span>

                  <!-- MODO NORMAL -->
                  <span x-show="!editing" x-text="name" class="text-sm cursor-pointer"
                    @click.prevent="clearTimeout(clickTimer); clickTimer = setTimeout(() => {
                      window.location.href='{{ route('dashboard', ['folder' => $child->id]) }}'}, 250)"
                    @dblclick.prevent="clearTimeout(clickTimer); editing = true;
                      $nextTick(() => $refs.childRenameInput.focus())">
                  </span>

                  <!-- MODO EDICIÓN -->
                  <input x-show="editing" x-ref="childRenameInput" x-model="name" @keydown.enter.prevent="saveRename()"
                    @keydown.escape="cancelRename()" @blur="saveRename()"
                    class="text-sm border rounded px-2 py-1 w-full bg-white" />
                </div>

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
</div>

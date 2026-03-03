    <aside x-show="selectedResource" x-cloak
      class="w-72 border-l p-6 mt-4 flex flex-col gap-4 overflow-y-auto font-['Montserrat',_serif]">

      <!-- CERRAR -->
      <div class="flex justify-end">
        <button @click="selectedResource = null; editing = false">
          <x-heroicon-o-x-mark class="w-5 h-5 text-black" style="stroke-width: 2" />
        </button>
      </div>

      <!-- PREVIEW -->
      <div class="w-full aspect-[4/5] mt-9">

        <!-- WEB -->
        <template x-if="selectedResource?.type === 'web'">
          <div class="w-full h-full bg-gray-100 rounded-lg flex flex-col items-center justify-center gap-3 p-4">
            <img :src="`https://www.google.com/s2/favicons?domain=${new URL(selectedResource.url).hostname}&sz=64`"
              class="w-10 h-10 rounded">
            <p class="text-xs text-gray-400 text-center break-all" x-text="selectedResource.url"></p>
            <a :href="selectedResource.url" target="_blank"
              class="text-xs bg-black text-white px-4 py-2 rounded-3xl hover:bg-gray-800 transition">
              Visit site
            </a>
          </div>
        </template>

        <!-- FONT -->
        <template x-if="selectedResource?.type === 'font'">
          <div
            class="w-full h-full bg-gray-50 border border-gray-100 rounded-lg flex flex-col items-center justify-center gap-4 p-6">
            <p class="text-5xl text-black" :style="`font-family: '${selectedResource.fontName}', sans-serif`">Aa</p>
            <p class="text-xl text-black text-center leading-relaxed"
              :style="`font-family: '${selectedResource.fontName}', sans-serif`">
              ABCDEFGHIJKLM<br>abcdefghijklm<br>0123456789
            </p>
            <a x-show="selectedResource.url" :href="selectedResource.url" target="_blank"
              class="text-xs bg-black text-white px-4 py-2 rounded-3xl hover:bg-gray-800 transition mt-2">
              View font
            </a>
          </div>
        </template>

        <!-- COLOR PALETTE -->
        <template x-if="selectedResource?.type === 'color_palette'">
          <div class="w-full h-full rounded-lg overflow-hidden flex flex-col">

            <!-- FRANJAS -->
            <div class="flex w-full flex-1">
              <template x-for="color in selectedResource.color_data" :key="color">
                <div class="flex-1 h-full" :style="`background-color: #${color}`"></div>
              </template>
            </div>
          </div>
        </template>

        <!-- ICON -->
        <template x-if="selectedResource?.type === 'icon'">
          <div
            class="w-full h-full bg-gray-50 border border-gray-100 rounded-lg flex flex-col items-center justify-center gap-4 p-6">
            <img :src="selectedResource.url" class="w-24 h-24 object-contain">
            <a :href="selectedResource.url" target="_blank"
              class="text-xs bg-black text-white px-4 py-2 rounded-3xl hover:bg-gray-800 transition">
              View icon
            </a>
          </div>
        </template>

        <!-- IMAGE (y resto de tipos) -->
        <template
          x-if="selectedResource?.type !== 'web' && selectedResource?.type !== 'font' && selectedResource?.type !== 'color_palette' && selectedResource?.type !== 'icon'">
          <img :src="selectedResource?.image" class="w-full h-full rounded-lg object-cover">
        </template>

      </div>

      <!-- TÍTULO -->
      <div class="border-t">
        <p class="text-xs mb-1 font-semibold mt-3">Title</p>

        <!-- VIEW -->
        <div x-show="!editing">
          <p class="text-sm text-black" x-text="selectedResource?.title"></p>
        </div>

        <!-- EDIT -->
        <div x-show="editing">
          <input type="text" x-model="editResource.title" class="w-full border rounded px-2 py-1 text-sm">

          <div x-show="errors.title" class="mt-1">
            <p class="text-xs text-red-500" x-text="errors.title?.[0]">
            </p>
          </div>
        </div>

        <!-- DESCRIPTION -->
        <div>
          <p class="text-xs mt-5 mb-1 font-semibold">Description</p>

          <!-- VIEW -->
          <div x-show="!editing">
            <div x-show="selectedResource?.description && selectedResource.description.trim() !== ''">
              <p class="text-sm text-black" x-text="selectedResource.description"></p>
            </div>

            <div x-show="!selectedResource?.description || selectedResource.description.trim() === ''">
              <p class="text-sm text-gray-400 italic">
                No description available
              </p>
            </div>
          </div>

          <!-- EDIT -->
          <div x-show="editing">
            <textarea x-model="editResource.description" rows="2" class="w-full border rounded px-2 py-1 text-sm"
              placeholder="Add description..."></textarea>
          </div>
        </div>

        <!-- LINK -->
        <div>
          <p class="text-xs mb-1 mt-4 font-semibold">Link</p>

          <!-- VIEW -->
          <div x-show="!editing">
            <div x-show="selectedResource?.url">
              <a :href="selectedResource.url" target="_blank"
                class="block max-w-full text-sm text-blue-500 underline truncate" x-text="selectedResource.url">
              </a>
            </div>

            <div x-show="!selectedResource?.url">
              <p class="text-sm text-gray-400 italic">No link available</p>
            </div>
          </div>

          <!-- EDIT -->
          <div x-show="editing">
            <input type="text" x-model="editResource.url" class="w-full border rounded px-2 py-1 text-sm"
              placeholder="https://example.com">
          </div>
        </div>

        <!-- TAGS -->
        <div>
          <p class="text-xs mt-5 mb-2 font-semibold">Tags</p>

          <!-- VIEW -->
          <div x-show="!editing">
            <div class="flex flex-wrap gap-2">
              <template x-for="tag in selectedResource?.tags" :key="tag">
                <span class="px-2 py-1 text-xs bg-gray-200 rounded-full text-gray-700" x-text="tag">
                </span>
              </template>

              <div x-show="!selectedResource?.tags || selectedResource.tags.length === 0">
                <p class="text-sm text-gray-400 italic">No tags</p>
              </div>
            </div>
          </div>

          <!-- EDIT -->
          <div x-show="editing">
            <input type="text" x-model="editResource.tags" class="w-full border rounded px-2 py-1 text-sm"
              placeholder="tag1, tag2, tag3">
          </div>
        </div>

        <!-- FOLDER -->
        <div>
          <p class="flex items-center gap-1 text-xs mt-5 mb-2 font-semibold">
            <x-heroicon-o-folder class="w-4 h-4 -mt-0.5" style="stroke-width: 1" />
            <span>Folder</span>
          </p>

          <p class="text-sm text-black" x-text="selectedResource?.folder"></p>
        </div>

        <!-- BUTTONS -->
        <div class="mt-8 flex justify-center gap-2">

          <!-- NORMAL MODE -->
          <div x-show="!editing">
            <div class="flex gap-2">
              <button @click="startEditing()"
                class="flex items-center gap-1 px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-black text-xs font-medium rounded-3xl transition duration-200">
                <x-heroicon-o-pencil class="w-5 h-5 text-black" />
                Edit
              </button>

              <button
                class="flex items-center gap-1 px-5 py-2.5 bg-black hover:bg-red-600 text-white text-xs font-medium rounded-3xl transition duration-200"
                @click="openDeleteModal('resource', selectedResource.id)">
                <x-heroicon-o-trash class="w-5 h-5" />
                Delete
              </button>
            </div>
          </div>

          <!-- EDIT MODE -->
          <div x-show="editing">
            <div class="flex gap-2">
              <button @click="saveResource()"
                class="px-5 py-2.5 bg-black hover:bg-green-600 text-white text-xs font-medium rounded-3xl transition duration-200">
                Save
              </button>

              <button @click="cancelEditing()"
                class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-black text-xs font-medium rounded-3xl transition duration-200">
                Cancel
              </button>
            </div>
          </div>

        </div>

    </aside>

@props(['folders'])

<div x-data="{
    open: false,
    folderId: null,
    folderName: '',
    folders: @js($folders->whereNull('parent_id')->load('children')),
}" x-show="open" x-cloak x-init="window.addEventListener('open-resource-modal', event => {
    open = true;
    folderId = event.detail.folderId;
    folderName = event.detail.folderName;
});
window.addEventListener('folderCreated', event => {
    folders = event.detail.folders;
});"
  class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 font-['Montserrat',_serif]">
  <div class="absolute inset-0" @click="open = false"></div>

  <div
    class="relative bg-white w-[520px] p-6 rounded-2xl shadow-xl max-h-[90vh] overflow-y-auto font-['Montserrat',_serif]">

    <h2 class="text-lg font-semibold">
      Upload your idea
    </h2>
    <p class="mb-4 text-sm text-gray-500">
      Select, describe and upload
    </p>

    <form action="{{ route('resources.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div x-data="{ hasFile: false, fileName: '' }" class="space-y-4">

        <!-- DROPZONE -->
        <div x-data="{ hasFile: false, fileName: '' }"
          class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center bg-gray-50 hover:bg-gray-100 transition">

          <input type="file" name="image" id="fileInput" class="hidden"
            @change="hasFile = true; fileName = $event.target.files[0]?.name"
            accept="image/*,.ttf,.otf,.woff,.woff2,.jpge">

          <label for="fileInput" class="cursor-pointer block">

            <div class="flex justify-center mb-3 text-black">
              <x-heroicon-o-paper-clip class="w-8 h-8" />
            </div>

            <template x-if="!hasFile">
              <div>
                <p class="font-medium text-sm mb-1">Drop file here</p>
                <p class="text-xs text-gray-500">or click to browse</p>
                <p class="text-xs text-gray-400 mt-1">Images, fonts, icons (max 10MB)</p>
              </div>
            </template>

            <template x-if="hasFile">
              <div class="text-green-600">
                <p class="font-medium text-sm">File selected</p>
                <p class="text-xs truncate" x-text="fileName"></p>
              </div>
            </template>

          </label>
        </div>

        <!-- OR -->
        <div class="flex items-center gap-3">
          <hr class="flex-1">
          <span class="text-xs text-gray-400">OR</span>
          <hr class="flex-1">
        </div>

        <!-- URL -->
        <input type="url" name="url" placeholder="Paste a URL"
          class="w-full border rounded-lg p-3 text-sm border-gray-200 text-black">

        <!-- TYPE -->
        <div x-data="{ open: false, selected: null }" class="relative">

          <label class="text-xs font-medium text-gray-700 mb-2 block">Type</label>

          <button type="button" @click="open = !open"
            class="w-full border rounded-lg p-3 text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
              <template x-if="selected">
                <span x-html="selected.icon"></span>
              </template>
              <span x-text="selected ? selected.name : 'Select type'"></span>
            </div>
            <x-heroicon-o-chevron-down class="w-4 h-4" />
          </button>

          <div x-show="open" @click.away="open = false" x-cloak
            class="absolute mt-1 w-full bg-white border rounded-lg shadow-lg z-50">
            <div class="px-4 py-2 text-sm flex items-center gap-2 hover:bg-gray-100 cursor-pointer"
              @click="selected = { id: 'font', name: 'Font', icon: '' }; open = false">
              <x-heroicon-o-language class="w-4 h-4" /> Font
            </div>
            <div class="px-4 py-2 text-sm flex items-center gap-2 hover:bg-gray-100 cursor-pointer"
              @click="selected = { id: 'image', name: 'Image', icon: '' }; open = false">
              <x-heroicon-o-photo class="w-4 h-4" /> Image
            </div>
            <div class="px-4 py-2 text-sm flex items-center gap-2 hover:bg-gray-100 cursor-pointer"
              @click="selected = { id: 'color_palette', name: 'Color palette', icon: '' }; open = false">
              <x-heroicon-o-swatch class="w-4 h-4" /> Color palette
            </div>
            <div class="px-4 py-2 text-sm flex items-center gap-2 hover:bg-gray-100 cursor-pointer"
              @click="selected = { id: 'icon', name: 'Icon', icon: '' }; open = false">
              <x-heroicon-o-sparkles class="w-4 h-4" /> Icon
            </div>
            <div class="px-4 py-2 text-sm flex items-center gap-2 hover:bg-gray-100 cursor-pointer"
              @click="selected = { id: 'web', name: 'Web', icon: '' }; open = false">
              <x-heroicon-o-globe-alt class="w-4 h-4" /> Web
            </div>
          </div>

          <input type="hidden" name="type" :value="selected?.id" required>
        </div>

        <!-- FOLDER SELECTOR -->
        <div x-data="{ folderOpen: false, folder: null, folderError: false }" class="space-y-4">

          <div class="relative">
            <label class="text-xs font-medium text-gray-700 mb-2 block ml-1">Choose the folder</label>

            <button type="button" @click="folderOpen = !folderOpen"
              class="w-full border rounded-lg p-3 text-sm flex items-center justify-between"
              :class="folderError ? 'border-red-400' : 'border-gray-200'">
              <span :class="folderError ? 'text-red-500 text-xs' : 'text-gray-700'"
                x-text="folderError ? 'You need to select a folder first' : (folder ? folder.name : 'No folder')">
              </span>
              <x-heroicon-o-chevron-down class="w-4 h-4" />
            </button>

            <!-- DROPDOWN -->
            <div x-show="folderOpen" @click.away="folderOpen = false" x-cloak
              class="absolute mt-1 w-full bg-white border rounded-lg shadow-lg z-50 max-h-60 overflow-y-auto">

              <template x-for="parentFolder in folders" :key="parentFolder.id">
                <div>
                  <div class="px-4 py-2 text-sm flex items-center gap-2 hover:bg-gray-100 cursor-pointer"
                    @click="folder = { id: parentFolder.id, name: parentFolder.name }; folderOpen = false; folderError = false">
                    <x-heroicon-o-folder class="w-4 h-4" />
                    <span x-text="parentFolder.name"></span>
                  </div>
                  <template x-for="child in parentFolder.children" :key="child.id">
                    <div class="px-8 py-2 text-sm flex items-center gap-2 hover:bg-gray-100 cursor-pointer"
                      @click="folder = { id: child.id, name: child.name }; folderOpen = false; folderError = false">
                      <x-heroicon-o-folder class="w-4 h-4 text-gray-400" />
                      <span x-text="child.name"></span>
                    </div>
                  </template>
                </div>
              </template>

            </div>

            <input type="hidden" name="folder_id" :value="folder?.id">
          </div>

          <!-- TITLE -->
          <input type="text" name="title" placeholder="Title"
            class="w-full border rounded-lg p-3 text-sm border-gray-200" required>

          <!-- DESCRIPTION -->
          <textarea name="description" placeholder="Description (optional)"
            class="w-full border rounded-lg p-2 text-sm h-15 border-gray-200"></textarea>

          <!-- TAGS -->
          <input type="text" name="tags" placeholder="modern, free, minimalist"
            class="w-full border rounded-lg p-2 text-sm border-gray-200">

          <!-- BUTTONS -->
          <div class="flex justify-end gap-3 pt-3 mt-3">
            <button type="button" @click="open = false"
              class="px-8 py-2.5 bg-gray-100 rounded-3xl hover:bg-gray-200">
              Cancel
            </button>
            <button type="button"
              @click="if (!folder?.id) { folderError = true } else { $el.closest('form').submit() }"
              class="px-8 py-2.5 bg-black text-white rounded-3xl hover:bg-gray-800">
              Save
            </button>
          </div>

        </div>
    </form>
  </div>
</div>

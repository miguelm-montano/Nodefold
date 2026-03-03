<div x-show="showDeleteModal" x-cloak
  class="fixed inset-0 flex items-center justify-center z-50 font-['Montserrat',_serif]">

  <!-- Overlay -->
  <div class="absolute inset-0 bg-black/50" @click="showDeleteModal = false">
  </div>

  <!-- Modal -->
  <div class="relative bg-white px-16 py-6 rounded-xl shadow-lg flex flex-col items-center text-center">

    <!-- ICONO DINÁMICO -->
    <template x-if="deleteTarget?.type === 'folder'">
      <x-heroicon-o-trash class="w-14 h-14 mb-5 text-red-500" />
    </template>

    <template x-if="deleteTarget?.type === 'resource'">
      <x-heroicon-o-archive-box-x-mark class="w-14 h-14 mb-5 text-red-500" />
    </template>

    <!-- TITULO -->
    <h2 class="font-semibold">
      You want to delete this
      <span x-text="deleteTarget?.type"></span>?
    </h2>

    <!-- MENSAJE -->
    <p class="text-sm text-gray-500 mb-6">
      <template x-if="deleteTarget?.type === 'folder'">
        <span>This folder and all resources will be permanently removed.</span>
      </template>

      <template x-if="deleteTarget?.type === 'resource'">
        <span>This resource will be permanently removed.</span>
      </template>
    </p>

    <div class="flex justify-end gap-2">

      <!-- Cancel -->
      <button type="button" @click="showDeleteModal = false"
        class="px-5 py-1 bg-gray-200 hover:bg-gray-300 rounded-3xl">
        Cancel
      </button>

      <!-- FORM DINÁMICO -->
      <form x-show="deleteTarget"
        :action="deleteTarget?.type === 'resource' ?
            `/resources/${deleteTarget?.id}` :
            `/folders/${deleteTarget?.id}`"
        method="POST">

        @csrf
        @method('DELETE')

        <button type="submit" class="px-5 py-1 bg-black text-white hover:bg-red-600 rounded-3xl">
          Delete
        </button>
      </form>

    </div>
  </div>
</div>

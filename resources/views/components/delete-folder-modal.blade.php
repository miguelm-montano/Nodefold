<div x-show="showDeleteModal" x-cloak
  class="fixed inset-0 flex items-center justify-center z-50 font-['Montserrat',_serif]">
  <!-- Overlay -->
  <div class="absolute inset-0 bg-black/50" @click="showDeleteModal = false"></div>

  <!-- Modal -->
  <div class="relative bg-white px-16 py-6 rounded-xl shadow-lg flex flex-col items-center text-center">

    <span>
      <x-heroicon-o-trash class="w-14 h-14 mb-5 text-red-500" style="stroke-width: 1" />
    </span>
    <h2 class="text font-semibold ">
      You want to delete this folder?
    </h2>

    <p class="text-sma text-gray-500 mb-6">
      This folder and all resources will<br>be permanently removed.
    </p>

    <div class="flex justify-end gap-2">

      <!-- Cancel -->
      <button type="button" @click="showDeleteModal = false"
        class="px-5 py-1 bg-gray-200 hover:bg-gray-300 rounded-3xl">
        Cancel
      </button>

      <!-- Delete -->
      <form method="POST" :action="`/folders/${selectedFolder}`">
        @csrf
        @method('DELETE')

        <button type="submit" class="px-5 py-1 bg-black text-white hover:bg-red-600 rounded-3xl">
          Delete
        </button>
      </form>

    </div>

  </div>
</div>

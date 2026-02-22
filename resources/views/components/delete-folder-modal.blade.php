<div x-show="showDeleteModal" x-cloak
  class="fixed inset-0 flex items-center justify-center z-50 font-['Montserrat',_serif]">
  <!-- Overlay -->
  <div class="absolute inset-0 bg-black/50" @click="showDeleteModal = false"></div>

  <!-- Modal -->
  <div class="relative bg-white p-5 rounded-xl shadow-lg w-80">

    <h2 class="text-lg font-semibold mb-4">
      Are you sure?
    </h2>

    <p class="text-sm text-gray-500 mb-6">
      This folder and all resources will be permanently removed.
    </p>

    <div class="flex justify-end gap-3">

      <!-- Cancel -->
      <button type="button" @click="showDeleteModal = false" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">
        Cancel
      </button>

      <!-- Delete -->
      <form method="POST" :action="`/folders/${selectedFolder}`">
        @csrf
        @method('DELETE')

        <button type="submit" class="px-3 py-1 bg-black text-white rounded hover:bg-red-600">
          Delete
        </button>
      </form>

    </div>

  </div>
</div>

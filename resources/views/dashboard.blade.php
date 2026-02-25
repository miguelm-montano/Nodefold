<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">
      Dashboard
    </h2>
  </x-slot>
  <script>
    function dashboardData() {
      return {

        // STATE
        selectedResource: null,
        showDeleteModal: false,
        deleteTarget: null,
        selectedFolder: null,

        editing: false,
        editResource: {},
        errors: {},

        // DELETE
        openDeleteModal(type, id) {
          this.deleteTarget = {
            type,
            id
          };
          this.showDeleteModal = true;
        },

        // EDIT MODE
        startEditing() {
          if (!this.selectedResource) return;

          this.editing = true;

          this.editResource = {
            ...this.selectedResource,
            tags: this.selectedResource?.tags?.join(', ') ?? ''
          };
        },

        cancelEditing() {
          this.editing = false;
          this.editResource = {};
        },

        // SAVE RESOURCE
        async saveResource() {

          if (!this.editResource?.id) return;

          try {

            const payload = {
              title: this.editResource.title,
              type: this.editResource.type,
              description: this.editResource.description || null,
              url: this.editResource.url || null,
              folder_id: this.editResource.folder_id || null,
              tags: this.editResource.tags || ''
            };

            const response = await fetch(`/resources/${this.editResource.id}`, {
              method: 'PATCH',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
              },
              credentials: 'same-origin',
              body: JSON.stringify(payload)
            });

            if (!response.ok) {
              const errorData = await response.json();

              if (errorData.errors) {
                this.errors = errorData.errors;
              }

              return;
            }

            const updated = await response.json();

            this.selectedResource.title = updated.title;
            this.selectedResource.description = updated.description;
            this.selectedResource.url = updated.url;
            this.selectedResource.folder = updated.folder?.name ?? null;
            this.selectedResource.folder_id = updated.folder_id;
            this.selectedResource.tags = updated.tags.map(t => t.name);

            this.editing = false;

          } catch (error) {
            console.error('Save error:', error);
          }
        }

      }
    }
  </script>

  <div x-data="dashboardData()" class="flex h-screen overflow-hidden">

    <!-- LEFT BAR -->
    @include('dashboard.partials.left-sidebar')

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

    <x-delete-folder-modal />
    <x-resource-modal :folders="$folders" />

  </div>
</x-app-layout>

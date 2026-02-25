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

    function folderCreator() {
      return {
        open: false,
        name: '',
        error: '',

        openForm() {
          this.open = true;
          this.$nextTick(() => this.$refs.input.focus());
        },

        closeForm() {
          this.open = false;
          this.name = '';
          this.error = '';
        },

        async createFolder() {

          if (!this.name.trim()) {
            this.error = 'Folder name is required';
            return;
          }

          try {

            const response = await fetch(`/folders`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
              },
              body: JSON.stringify({
                name: this.name
              })
            });

            if (!response.ok) {
              const data = await response.json();
              this.error = data.errors?.name?.[0] ?? 'Something went wrong';
              return;
            }

            // 🔥 recarga suave solo de la página
            window.location.reload();

          } catch (e) {
            console.error(e);
          }
        }
      }
    }
  </script>

  <div x-data="dashboardData()" class="flex h-screen overflow-hidden">

    <!-- LEFT BAR -->
    @include('dashboard.partials.left-sidebar')

    <!-- CENTER GRID -->
    @include('dashboard.partials.grid')

    <!-- RIGHT BAR -->
    @include('dashboard.partials.right-sidebar')

    <x-delete-folder-modal />
    <x-resource-modal :folders="$folders" />

  </div>
</x-app-layout>

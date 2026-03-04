<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">
      Dashboard
    </h2>
  </x-slot>
  {{-- <script src="{{ asset('js/dashboard.js') }}"></script> --}}
  {{-- <script src="{{ asset('js/folder-creator.js') }}"></script> --}}

  <div x-data="{
      ...dashboardData(),
      resources: @js(
    $resources->map(
        fn($r) => [
            'id' => $r->id,
            'image' => $r->image_path ? asset('storage/' . $r->image_path) : null,
            'title' => $r->title,
            'type' => $r->type,
            'description' => $r->description,
            'url' => $r->url,
            'folder' => optional($r->folder)->name,
            'folder_id' => $r->folder_id,
            'tags' => $r->tags->pluck('name')->toArray(),
        ],
    ),
)
  }"
    x-effect="selectedResource; setTimeout(() => { if (window.msnryInstance) window.msnryInstance.layout() }, 150)"
    class="flex h-screen overflow-hidden">

    <!-- LEFT BAR -->
    <livewire:folder-sidebar />

    <!-- CENTER GRID -->
    <livewire:resource-grid :folder_id="request('folder') ? (int) request('folder') : null" :filter="request('filter')" />

    <!-- RIGHT BAR -->
    @include('dashboard.partials.right-sidebar')

    <x-delete-folder-modal />
    <x-resource-modal :folders="$folders" />

  </div>
</x-app-layout>

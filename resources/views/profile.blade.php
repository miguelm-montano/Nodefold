<x-app-layout>
  <div class="font-['Montserrat',_serif] min-h-screen grid grid-cols-2">

    <div class="bg-black flex items-start px-12 py-16">
      <p class="text-white text-3xl font-bold">Nodefold</p>
    </div>

    <div class="bg-white px-16 py-16 space-y-8 overflow-y-auto">

      <div class="flex flex-row items-center justify-between">
        <h1 class="text-3xl font-bold">Edit Your Profile</h1>
        <a href="{{ route('dashboard') }}" wire:navigate>
          <x-heroicon-o-arrow-left-on-rectangle class="w-6 h-6 hover:opacity-60 transition" style="stroke-width: 1" />
        </a>
      </div>


      <!-- Profile Info -->
      <div class="space-y-1 border-b pb-10">
        <livewire:profile.update-profile-information-form />
      </div>

      <!-- Password -->
      <div class="space-y-1 border-b pb-10">
        <livewire:profile.update-password-form />
      </div>

      <!-- Delete -->
      <div class="space-y-1">
        <livewire:profile.delete-user-form />
      </div>

    </div>
  </div>
</x-app-layout>

<div>
  <form wire:submit="createFolder" class="space-y-1">

    <input type="text" wire:model="name" placeholder="Folder name" class="border rounded-lg px-3 py-2 w-full text-sm"
      autofocus>

    @error('name')
      <p class="text-xs text-red-500">{{ $message }}</p>
    @enderror

    <button type="submit" style="position:absolute; opacity:0; pointer-events:none; width:0; height:0;"></button>
  </form>
</div>

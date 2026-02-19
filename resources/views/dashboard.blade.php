<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Dashboard
        </h2>
    </x-slot>

    <div class="flex h-[80vh]">

        <!-- LEFT BAR -->
        <aside class="w-64 border-r p-7 flex flex-col">
            
            <h1 class="text-2xl font-bold mb-8">NAME</h1>

            <ul class="space-y-2 mb-6 text-sm">
                <li>All</li>
                <li>Uncategorized</li>
                <li>Untagged</li>
                <li>All tags</li>
            </ul>

            <p class="text-gray-500 text-sm mb-2">Folders</p>

            <!-- Create new folder -->
            <div x-data="{ open: false }" class="mb-6">

            <!-- Botón -->
            <button 
                x-show="!open"
                @click="open = true; $nextTick(() => $refs.input.focus())"
                class="text-sm text-gray-600 hover:text-black">
                + Create new folder
            </button>

            <!-- Input -->
            <form 
                x-show="open"
                @submit="open = false"
                action="{{ route('folders.store') }}" 
                method="POST"
                class="mt-2">
                @csrf

                <input 
                    x-ref="input"
                    type="text" 
                    name="name" 
                    placeholder="Folder name"
                    class="border rounded p-1 w-full text-sm"
                    @keydown.escape="open = false"
                    @blur="open = false"
                    required
                >
            </form>

        </div>

            <!-- List folders -->
            <ul class="space-y-1">
                @foreach($folders as $folder)
                    <li class="flex items-center justify-between group px-4 py-1 rounded hover:bg-gray-100">

                        <!-- Nombre carpeta -->
                        <div class="flex items-center space-x-2">
                            <span>📁</span>
                            <span class="text-sm">{{ $folder->name }}</span>
                        </div>

                        <!-- Botón eliminar -->
                        <form 
                            action="{{ route('folders.destroy', $folder) }}" 
                            method="POST"
                            class="opacity-0 group-hover:opacity-100 transition">
                            @csrf
                            @method('DELETE')

                            <button 
                                type="submit"
                                class="text-gray-400 hover:text-red-500 text-sm">
                                    ✕
                            </button>
                        </form>

                    </li>
                @endforeach
            </ul>

        </aside>

        <!-- CENTER DASHBOARD -->
        <main class="flex-1 p-6 flex items-center justify-center text-gray-400">
            <div class="text-center"> 
                <div class="text-5xl mb-4">📂</div> 
                <p>Create new folder</p> 
            </div> 
        </main>

        <!-- RIGHT BAR -->
        <aside class="w-72 border-l p-4 hidden">
            <!-- Aquí aparecerán detalles cuando selecciones algo -->
        </aside>

    </div>
</x-app-layout>

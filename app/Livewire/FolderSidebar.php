<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class FolderSidebar extends Component {

    #[On('folderCreated')]
    public function refreshFolders() {}

    public function render() {
        
        $user = auth()->user();

        return view('livewire.folder-sidebar', [
            'folders' => $user->folders()
                ->with(['children' => function ($query) {
                    $query->withCount('resources');
                }, 'resources'])
                ->withCount('resources')
                ->get(),

            'allCount' => $user->resources()->count(),

            'untaggedCount' => $user->resources()
                ->doesntHave('tags')
                ->count(),

            'taggedCount' => $user->resources()
                ->has('tags')
                ->count(),
        ]);
    }
}
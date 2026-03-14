<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Folder;

class ResourceGrid extends Component {

    public ?int $folder_id = null;
    public ?string $filter = null;

    public function mount(?int $folder_id = null, ?string $filter = null) {

        $this->folder_id = $folder_id;
        $this->filter    = $filter;
    }

    #[On('folderSelected')]
    public function loadFolder(int $folder_id) {

        $this->folder_id = $folder_id;
        $this->filter = null;
    }

    public function render() {

        $user = auth()->user();
        $folders = $user->folders()
            ->with(['children' => fn($q) => $q->withCount('resources')])
            ->withCount('resources')
            ->get();

        $resources = $this->getResources($user);
        $selectedFolder = $this->folder_id ? Folder::find($this->folder_id) : null;

        [$prevFolder, $nextFolder] = $this->getNavigation($folders, $selectedFolder);

        return view('livewire.resource-grid', compact(
            'resources', 'selectedFolder', 'prevFolder', 'nextFolder', 'folders'
        ));
    }

    private function getResources($user) {

        if ($this->filter === 'untagged') {
            return $user->resources()->doesntHave('tags')->with(['folder', 'tags'])->get();
        }
        if ($this->filter === 'tagged') {
            return $user->resources()->has('tags')->with(['folder', 'tags'])->get();
        }
        if ($this->filter === 'all' || !$this->folder_id) {
            return $user->resources()->with(['folder', 'tags'])->get();
        }

        $selectedFolder = Folder::find($this->folder_id);

        if ($selectedFolder && $selectedFolder->parent_id === null) {
            $childIds = Folder::where('parent_id', $this->folder_id)
                ->where('user_id', $user->id)
                ->pluck('id');

            return $user->resources()
                ->where(fn($q) => $q->where('folder_id', $this->folder_id)
                ->orWhereIn('folder_id', $childIds))
                ->with(['folder', 'tags'])
                ->get();
        }

        return $user->resources()
            ->where('folder_id', $this->folder_id)
            ->with(['folder', 'tags'])
            ->get();
    }

    private function getNavigation($folders, $selectedFolder): array {

        if (!$selectedFolder) return [null, null];

        $allFolders = $folders->flatMap(fn($f) => collect([$f])->merge($f->children));
        $index = $allFolders->search(fn($f) => $f->id === $selectedFolder->id);

        return [
            $index > 0 ? $allFolders->get($index - 1) : null,
            $allFolders->get($index + 1),
        ];
    }
}
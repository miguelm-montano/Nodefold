<?php

namespace App\Livewire;

use Livewire\Component;

class CreateFolder extends Component
{
    public $name = '';
    public $parent_id = null;

    public function mount($parent_id = null)
    {
        $this->parent_id = $parent_id;
    }

    public function createFolder()
    {
        $this->validate([
            'name' => 'required|string|max:255'
        ]);

        auth()->user()->folders()->create([
            'name' => $this->name,
            'parent_id' => $this->parent_id,
        ]);

        $this->name = '';

        $this->dispatch('folderCreated');
    }

    public function render()
    {
        return view('livewire.create-folder');
    }
}
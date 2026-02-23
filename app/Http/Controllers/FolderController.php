<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller {

    public function index(Request $request) {
    
    $user = Auth::user();
    $folders = $user->folders;

    if ($request->has('folder')) {

        $folderId = $request->get('folder');

        $selectedFolder = Folder::where('id', $folderId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        //Parent Folder
        if ($selectedFolder->parent_id === null) {

            $childIds = Folder::where('parent_id', $folderId)
                ->where('user_id', $user->id)
                ->pluck('id');

            $resources = $user->resources()
                ->where(function ($query) use ($folderId, $childIds) {
                    $query->where('folder_id', $folderId)->orWhereIn('folder_id', $childIds);
                })->with(['folder', 'tags'])->get();
        } else {
            //Child folder resources
            $resources = $user->resources()
                ->where('folder_id', $folderId)
                ->with(['folder', 'tags'])
                ->get();
        }

    } else {

        $resources = $user->resources()
            ->whereNull('folder_id')
            ->with(['folder', 'tags'])
            ->get();

        $selectedFolder = null;
    }

        return view('dashboard', compact('folders', 'resources', 'selectedFolder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request) {
        
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'parent_id' => 'nullable|exists:folders,id'
        ]);

        if ($validated['parent_id'] ?? false) {

            $parent = Folder::where('id', $validated['parent_id'])->where('user_id', Auth::id())->firstOrFail();
        
            if ($parent->parent_id !== null) {
                abort(403, 'Only one nesting level allowed');
            }
        }

        Auth::user()->folders()->create([
            'name' => $validated['name'],
            'parent_id' => $validated['parent_id'] ?? null
        ]);

        return redirect()->back();
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(string $id) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Folder $folder) {

        if($folder->user_id !== Auth::id()) {
            abort(403, 'Not Authorized');
        }

        $validate = $request->validated([
            'name' => 'required|string|max:50'
        ]);

        $folder->update([
            'name' => $validate['name']
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Folder $folder) {

        if ($folder->user_id !== auth()->id()) {
            abort(403);
        }
    
        // Borrar archivos del storage
        foreach ($folder->resources as $resource) {
            if ($resource->image_path) {
                Storage::delete($resource->image_path);
            }
        $resource->delete();
        }
    
        // Borrar recursos de carpetas hijas
        foreach ($folder->children as $child) {
            foreach ($child->resources as $resource) {
                    if ($resource->image_path) {
                    Storage::delete($resource->image_path);
                }
                $resource->delete();
            }
            $child->delete();
        }
    
        $folder->delete();
        return redirect()->route('dashboard');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller {

    public function index() {
        
        $folders = Auth::user()->folders;

        return view('dashboard', compact('folders'));
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

        $folder->delete();

        return redirect()->back();
    }
}

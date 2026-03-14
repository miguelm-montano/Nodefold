<?php
namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FolderController extends Controller {

    public function store(Request $request) {

        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'parent_id' => 'nullable|exists:folders,id',
        ]);

        if ($validated['parent_id'] ?? false) {
            $parent = Folder::where('id', $validated['parent_id'])
                ->where('user_id', Auth::id())
                ->firstOrFail();

            if ($parent->parent_id !== null) {
                abort(403, 'Only one nesting level allowed');
            }
        }

        Auth::user()->folders()->create([
            'name' => $validated['name'],
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, Folder $folder) {

        if ($folder->user_id !== Auth::id()) {
            abort(403, 'Not Authorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $folder->update(['name' => $validated['name']]);

        return response()->json(['success' => true]);
    }

    public function destroy(Folder $folder) {
        
        if ($folder->user_id !== Auth::id()) {
            abort(403);
        }

        foreach ($folder->resources as $resource) {
            if ($resource->image_path) {
                Storage::delete($resource->image_path);
            }
            $resource->delete();
        }

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
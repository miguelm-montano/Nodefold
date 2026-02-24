<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Folder;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {

        $resources = Auth::user()->resources()->with(['folder', 'tags'])->get();

        $folders = Auth::user()->folders;

        return view('dashboard', compact('resources', 'folders'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:font,image,color_palette,icon,web',
            'description' => 'nullable|string|max:400',
            'url' => 'nullable|url|max:500',
            'folder_id' => 'nullable|exists:folders,id',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|max:10240'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('resources', 'public');
        }

        $resource = Auth::user()->resources()->create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'description' => $validated['description'] ?? null,
            'url' => $validated['url'] ?? null,
            'folder_id' => $validated['folder_id'] ?? null,
            'image_path' => $imagePath,
        ]);

        if(!empty($validated['tags'])) {
            $tagNames = explode(',', $validated['tags']);

            foreach ($tagNames as $tagName) {
                $tagName = trim(strtolower($tagName));

                if(!empty($tagName)) {
                    $tag = Tag::firstOrCreate(['name' => $tagName]);

                    $resource->tags()->attach($tag->id);
                }
            }
        }
        return redirect()->route('dashboard', [
            'folder' => $validated['folder_id']
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resource $resource) {
        
        if($resource->user_id !== Auth::id()) {
            abort(403, 'Not Authorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:font,image,color_palette,icon,web',
            'description' => 'nullable|string|max:400',
            'url' => 'nullable|url|max:500',
            'folder_id' => 'nullable|exists:folders,id',
            'tags' => 'nullable|string'
        ]);

        $resource->update([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'description' => $validated['description'] ?? null,
            'url' => $validated['url'] ?? null,
            'folder_id' => $validated['folder_id'] ?? null
        ]);

        $tagNames = collect(explode(',', $request->input('tags', '')))
            ->map(fn ($tag) => trim(strtolower($tag)))
            ->filter()
            ->unique();

        $tagIds = $tagNames->map(function ($name) {
            return Tag::firstOrCreate(['name' => $name])->id;
        });

        $resource->tags()->sync($tagIds);
            return response()->json(
            $resource->load('tags')
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource) {

        if($resource->user_id !== Auth::id()) {
            abort(403, 'Not Authorized');
        }

        $resource->delete();

        return redirect()->back();
        
    }
}

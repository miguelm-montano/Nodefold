<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Folder;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller {

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

    public function store(Request $request) {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:font,image,color_palette,icon,web',
            'description' => 'nullable|string|max:400',
            'url' => 'nullable|string|max:500',
            'folder_id' => 'nullable|exists:folders,id',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|max:10240'
        ]);

        $resource = Auth::user()->resources()->create([
            ...$validated,
            'image_path' => $this->handleImageUpload($request),
            'color_data' => $this->extractColorsFromUrl($validated['type'], $validated['url'] ?? null),
        ]);

        $resource->syncTagsFromString($validated['tags'] ?? null);

        return redirect()->route('dashboard', [
            'folder' => $validated['folder_id']
        ]);
    }

    private function handleImageUpload(Request $request): ?string {
        
        if ($request->hasFile('image')) {
            return $request->file('image')->store('resources', 'public');
        }

        return null;
    }

    private function extractColorsFromUrl(?string $type, ?string $url): ?array {

        if ($type !== 'color_palette' || empty($url)) return null;

        if (preg_match('/coolors\.co\/(?:palette\/)?([a-f0-9-]+)/i', $url, $matches)) {
            $colors = array_filter(explode('-', $matches[1]), fn($c) => strlen($c) === 6);
            return array_values($colors);
        }

        return null;
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

    public function update(Request $request, Resource $resource) {
        
            if ($resource->user_id !== Auth::id()) {
            abort(403, 'Not Authorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:font,image,color_palette,icon,web',
            'description' => 'nullable|string|max:400',
            'url' => 'nullable|string|max:500',
            'folder_id' => 'nullable|exists:folders,id',
            'tags' => 'nullable|string'
        ]);

        $resource->update($validated);

        $resource->syncTagsFromString($validated['tags'] ?? null);

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

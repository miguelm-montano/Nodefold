<?php
namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    public function index(Request $request) {

        $user = Auth::user();

        $folders = $user->folders()
            ->with(['children' => fn($q) => $q->withCount('resources')])
            ->withCount('resources')
            ->get();

        $counts = $this->getResourceCounts($user);
        $filtered = $this->getFilteredResources($request, $user);
        $navigation = $this->getFolderNavigation($folders, $filtered['selectedFolder']);

        return view('dashboard', array_merge(
            $counts,
            $filtered,
            $navigation,
            ['folders' => $folders]
        ));
    }

    private function getResourceCounts($user): array {

        return [
            'allCount' => $user->resources()->count(),
            'untaggedCount' => $user->resources()->doesntHave('tags')->count(),
            'taggedCount' => $user->resources()->has('tags')->count(),
        ];
    }

    private function getFilteredResources(Request $request, $user): array {

        $filter = $request->query('filter');

        if ($filter === 'untagged') {
            return [
                'resources' => $user->resources()->doesntHave('tags')->with(['folder', 'tags'])->get(),
                'selectedFolder' => null,
            ];
        }

        if ($filter === 'tagged') {
            return [
                'resources' => $user->resources()->has('tags')->with(['folder', 'tags'])->get(),
                'selectedFolder' => null,
            ];
        }

        if ($filter === 'all') {
            return [
                'resources' => $user->resources()->with(['folder', 'tags'])->get(),
                'selectedFolder' => null,
            ];
        }

        return $this->getFolderResources($request, $user);
    }

    private function getFolderResources(Request $request, $user): array {

        if (!$request->has('folder')) {
            return [
                'resources' => $user->resources()->whereNull('folder_id')->with(['folder', 'tags'])->get(),
                'selectedFolder' => null,
            ];
        }

        $folderId = $request->get('folder');
        $selectedFolder = Folder::where('id', $folderId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if ($selectedFolder->parent_id === null) {
            $childIds = Folder::where('parent_id', $folderId)
                ->where('user_id', $user->id)
                ->pluck('id');

            $resources = $user->resources()
                ->where(fn($q) => $q->where('folder_id', $folderId)->orWhereIn('folder_id', $childIds))
                ->with(['folder', 'tags'])
                ->get();
        } else {
            $resources = $user->resources()
                ->where('folder_id', $folderId)
                ->with(['folder', 'tags'])
                ->get();
        }

        return compact('resources', 'selectedFolder');
    }

    private function getFolderNavigation($folders, $selectedFolder): array {
        
        if (!$selectedFolder) {
            return ['prevFolder' => null, 'nextFolder' => null];
        }

        $allFolders = $folders->flatMap(fn($f) => collect([$f])->merge($f->children));
        $index = $allFolders->search(fn($f) => $f->id === $selectedFolder->id);

        return [
            'prevFolder' => $index > 0 ? $allFolders->get($index - 1) : null,
            'nextFolder' => $allFolders->get($index + 1),
        ];
    }
}
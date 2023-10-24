<?php

namespace App\Http\Controllers\Api\FolderAnimeRelation\Search;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Models\Folder;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{

    /**
     * @param SearchRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SearchRequest $request, $folderId): \Illuminate\Http\JsonResponse
    {
        $userId = Auth::id();
        /** @var Folder $folder */
        $folder = \FolderAnimeRelationService::getFolderByUserIdAndFolderId($userId, $folderId);
        $keyWord = trim($request->q);
        // アニメを検索します。
        $animes = \FolderAnimeRelationService::searchFolderAnime($userId, $folder->id, $keyWord);

        return \response()->json($animes, 200);
    }
}

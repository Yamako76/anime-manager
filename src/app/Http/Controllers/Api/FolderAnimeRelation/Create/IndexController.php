<?php

namespace App\Http\Controllers\Api\FolderAnimeRelation\Create;

use App\Http\Controllers\Controller;
use App\Http\Requests\FolderAnimeRelationRequest;
use App\Models\Anime;
use App\Models\Folder;
use App\Services\Api\FolderAnimeRelation\State\FolderAnimeRelationStateNotFoundException;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{

    /**
     * @param FolderAnimeRelationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(FolderAnimeRelationRequest $request): \Illuminate\Http\JsonResponse
    {

        $userId = Auth::id();

        /** @var Folder $folder */
        $folder = \FolderAnimeRelationService::getFolderIdByUserIdAndFolderName($userId, $request->folderName);
        if (is_null($folder)) {
            return response()->json([], 400);
        }
        $folderId = $folder->id;

        /** @var Anime $anime */
        $anime = \FolderAnimeRelationService::getAnimeIdByUserIdAndAnimeName($userId, $request->animeName);
        if (is_null($anime)) {
            return response()->json([], 400);
        }
        $animeId = $anime->id;

        // フォルダにアニメを追加します。
        try {
            \FolderAnimeRelationService::createFolderAnimeRelation($userId, $folderId, $animeId);
        } catch (FolderAnimeRelationStateNotFoundException $e) {
            \Log::error($e);
            return \response()->json([], 500);
        } catch (\Exception $e) {
            \Log::error("フォルダにアニメの追加処理中、予期せぬエラーが発生しました。調査が必要です。", $e->getTrace());
            return \response()->json([], 500);
        }
        return \response()->json([], 200);
    }
}

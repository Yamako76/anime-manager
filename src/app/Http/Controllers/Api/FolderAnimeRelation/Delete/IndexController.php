<?php

namespace App\Http\Controllers\Api\FolderAnimeRelation\Delete;

use App\Http\Controllers\Controller;
use App\Models\FolderAnimeRelation;
use App\Services\Api\FolderAnimeRelation\State\InvalidFolderAnimeRelationStateChangeException;

class IndexController extends Controller
{
    /**
     * @param $folderId
     * @param $animeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($folderId, $animeId): \Illuminate\Http\JsonResponse
    {

        $userId = \Auth::id();

        // $folderId が整数でない場合
        if (!is_numeric($folderId) || (int)$folderId != $folderId) {
            return \response()->json([], 400);
        }

        // $animeId が整数でない場合
        if (!is_numeric($animeId) || (int)$animeId != $animeId) {
            return \response()->json([], 400);
        }

        // 削除するアニメを取得します。
        /** @var FolderAnimeRelation $folderAnimeRelation */
        $folderAnimeRelation = \FolderAnimeRelationService::getFolderAnimeRelationByUserIdAndFolderIdAndAnimeId($userId, $folderId, $animeId);
        if (is_null($folderAnimeRelation)) {
            return response()->json([], 404);
        }

        // フォルダからアニメを削除します。
        try {
            $folderAnimeRelation = $folderAnimeRelation->toState()->delete($folderAnimeRelation);
        } catch (InvalidFolderAnimeRelationStateChangeException $e) {
            \Log::warning($e);
            return \response()->json([], 400);
        } catch (\Exception $e) {
            \Log::error("フォルダからアニメの削除処理中、予期せぬエラーが発生しました。調査が必要です。", $e);
            return \response()->json([], 500);
        }
        return \response()->json([], 200);
    }
}

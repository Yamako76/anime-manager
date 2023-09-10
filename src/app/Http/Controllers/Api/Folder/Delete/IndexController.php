<?php

namespace App\Http\Controllers\Api\Folder\Delete;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use App\Services\Api\Folder\State\InvalidFolderStateChangeException;

class IndexController extends Controller
{
    /**
     * @param $folderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($folderId): \Illuminate\Http\JsonResponse
    {

        $userId = \Auth::id();

        // 削除するフォルダを取得します。
        /** @var Folder $folder */
        $folder = \FolderService::getFolderByIdAndUserId($folderId, $userId);
        if (is_null($folder)) {
            return \response()->json([], 404);
        }

        // フォルダの削除処理を実行します。
        try {
            $folder = $folder->toState()->delete($folder);
        } catch (InvalidFolderStateChangeException $e) {
            \Log::warning($e);
            return \response()->json([], 400);
        } catch (\Exception $e) {
            \Log::error("フォルダの削除処理中、予期せぬエラーが発生しました。調査が必要です。", $e);
            return \response()->json([], 500);
        }

        return \response()->json([], 200);
    }
}

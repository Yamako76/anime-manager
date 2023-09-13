<?php


namespace App\Http\Controllers\Api\Folder\Update;

use App\Http\Controllers\Controller;
use App\Http\Requests\FolderRequest;
use App\Models\Folder;

class IndexController extends Controller
{
    /**
     * @param $folderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($folderId, FolderRequest $request): \Illuminate\Http\JsonResponse
    {

        $userId = \Auth::id();

        // 編集するフォルダを取得します。
        /** @var Folder $folder */
        $folder = \FolderService::getFolderByIdAndUserId($folderId, $userId);
        if (is_null($folder)) {
            return \response()->json([], 404);
        }

        // フォルダを更新します。
        try {
            \FolderService::UpdateFolderRecord($folder, $request->name);
        } catch (\Exception $e) {
            \Log::error("フォルダの編集処理中、予期せぬエラーが発生しました。調査が必要です。", $e);
            return \response()->json([], 500);
        }

        return \response()->json([], 200);
    }
}

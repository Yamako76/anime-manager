<?php

namespace App\Http\Controllers\Api\Folder\Create;

use App\Http\Controllers\Controller;
use App\Http\Requests\FolderRequest;
use App\Services\Api\Folder\State\FolderStateNotFoundException;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    /**
     * @param FolderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(FolderRequest $request): \Illuminate\Http\JsonResponse
    {
        $userId = Auth::id();

        // フォルダを作成します。
        try {
            \FolderService::createFolder($userId, $request->name);
        } catch (FolderStateNotFoundException $e) {
            \Log::error($e);
            return \response()->json([], 500);
        } catch (\Exception $e) {
            \Log::error("フォルダの作成処理中、予期せぬエラーが発生しました。調査が必要です。", $e->getTrace());
            return \response()->json([], 500);
        }

        return \response()->json([], 200);
    }
}

<?php

namespace App\Http\Controllers\Api\Folder\Create;

use App\Http\Controllers\Controller;
use App\Http\Requests\FolderRequest;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    /**
     * @param FolderRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index(FolderRequest $request): \Illuminate\Http\JsonResponse
    {
        $userId = Auth::id();

        try {
            \FolderService::CreateFolder($userId, $request->name);
        } catch (\Exception $e) {
            \Log::error("フォルダの作成処理中、予期せぬエラーが発生しました。調査が必要です。", $e);
            return \response()->json([], 500);
        }

        return \response()->json([], 200);
    }
}

<?php

namespace App\Http\Controllers\Api\Folder;

use App\Http\Controllers\Controller;
use App\Http\Requests\FolderRequest;
use App\Models\Folder;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{

    public function index(): \Illuminate\Http\JsonResponse
    {

        try {
            $folderList = Auth::user()->folders()->get();

        } catch (\Exception $e) {
            \Log::error(
                "フォルダの一覧取得の際に、予期せぬエラーが発生しました。調査が必要です。",
                $e
            );
            return \response()->json([], 500);
        }

        return \response()->json($folderList->toArray());
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        // 指定されたIDに基づいてフォルダを取得
        $folder = Folder::find($id);

        if (!$folder) {
            return response()->json([], 404);
        }

        return \response()->json($folder);
    }

    public function create(FolderRequest $request): \Illuminate\Http\JsonResponse
    {
        $userId = Auth::id();

        \FolderService::createFolderRecord($userId, $request->name);
        return \response()->json([], 201);
    }
}

<?php

namespace App\Http\Controllers\Api\Folder;

use App\Http\Controllers\Controller;
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
}

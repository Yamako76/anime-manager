<?php

namespace App\Http\Controllers\Api\Folder\Search;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{

    /**
     * @param SearchRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SearchRequest $request): \Illuminate\Http\JsonResponse
    {
        $userId = Auth::id();
        $keyWord = trim($request->q);
        // フォルダを検索します。
        $fodlers = \FolderService::searchFolder($userId, $keyWord);

        return \response()->json($fodlers, 200);
    }
}

<?php

namespace App\Http\Controllers\Api\Folder\Create;

use App\Http\Controllers\Controller;
use App\Http\Requests\FolderRequest;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(FolderRequest $request): \Illuminate\Http\JsonResponse
    {
        $userId = Auth::id();

        \FolderService::createFolderRecord($userId, $request->name);
        return \response()->json([], 201);
    }
}

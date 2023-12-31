<?php


namespace App\Http\Controllers\Api\FolderAnimeRelation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(Request $request, $folderId)
    {
        $userId = Auth::id();

        // 現在のページデータが渡されなかった場合、ぺジネーション機能を使用できないため、
        //不正なパラメータが入力されたエラーとして処理する。
        $currentPage = $request->query('page');
        if (is_null($currentPage)) {
            return \response()->json([], 400);
        }

        try {
            $sortType = !is_null($request->query('sort')) ? $request->query('sort') : 'created_at';
            $animeList = \FolderAnimeRelationService::getAnimeListByUserIdAndFolderId($userId, $folderId, $currentPage, 20, $sortType);
        } catch (\Exception $e) {
            \Log::error(
                "アニメの一覧取得の際に、予期せぬエラーが発生しました。調査が必要です。",
                $e
            );
            return \response()->json([], 500);
        }

        // そもそも存在しないページへのアクセスが行われた場合、リソースが存在しないため404を返却。
        if ($currentPage > $animeList->lastPage() ||
            $currentPage < 1) {
            return \response()->json([], 404);
        }

        return \response()->json($animeList->toArray());
    }
}

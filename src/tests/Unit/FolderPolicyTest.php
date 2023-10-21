<?php


namespace Tests\Unit;

use App\Models\Folder;
use App\Models\User;
use App\Policies\FolderPolicy;
use PHPUnit\Framework\TestCase;

class FolderPolicyTest extends TestCase
{
    /**
     * FolderPolicyのバリデーション機能テスト
     * - UserのIDとFolderのuserIdが一致する場合
     */
    public function testView_valid_user(): void
    {
        $folderPolicy = new FolderPolicy();
        $user = new User();
        $user->user_id = 1;
        $folder = new Folder();
        $folder->user_id = 1;
        $this->assertTrue($folderPolicy->view($user, $folder));
    }

    /**
     * FolderPolicyのバリデーション機能テスト
     * - UserのIDとFolderのuserIdが一致しない場合
     */
    public function testView_invalid_user(): void
    {
        $folderPolicy = new FolderPolicy();
        $user = new User();
        $user->user_id = 1;
        $folder = new Folder();
        $folder->user_id = 2;
        $this->assertFalse($folderPolicy->view($user, $folder));
    }
}

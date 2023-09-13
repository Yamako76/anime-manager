<?php

namespace App\Services\Api\Folder\State;

/**
 * このExceptionはFolderの該当のステータスが存在しないときにに発生するExceptionです。
 */
class FolderStateNotFoundException extends \RuntimeException
{
}

<?php

namespace App\Services\Api\Folder\State;

/**
 * このExceptionはフォルダのステータス変更が不正に行われたときに起こるExceptionです。
 */
class InvalidFolderStateChangeException extends \LogicException
{
}

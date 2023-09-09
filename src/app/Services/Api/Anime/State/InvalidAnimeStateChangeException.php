<?php

namespace App\Services\Api\Anime\State;

/**
 * このExceptionはアニメのステータス変更が不正に行われたときに起こるExceptionです。
 */
class InvalidAnimeStateChangeException extends \LogicException
{
}

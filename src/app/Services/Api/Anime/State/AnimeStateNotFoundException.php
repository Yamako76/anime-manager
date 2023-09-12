<?php

namespace App\Services\Api\Anime\State;

/**
 * このExceptionはアニメの該当のステータスが存在しないときにに発生するExceptionです。
 */
class AnimeStateNotFoundException extends \RuntimeException
{
}

<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 26.09.17
 */

namespace Nutnet\LaravelComments\Models;

use Actuallymab\LaravelComment\Models\Comment as OriginalComment;
use Plank\Metable\Metable;

/**
 * Class Comment
 * @package Nutnet\LaravelComments\Models
 */
class Comment extends OriginalComment
{
    use Metable;
}

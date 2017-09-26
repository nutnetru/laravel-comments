<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 26.09.17
 */

namespace Nutnet\LaravelComments\Models;

use Actuallymab\LaravelComment\Models\Comment as OriginalComment;
use Illuminate\Database\Eloquent\Builder;
use Plank\Metable\Metable;

/**
 * Class Comment
 * @package Nutnet\LaravelComments\Models
 */
class Comment extends OriginalComment
{
    use Metable;

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeApproved(Builder $builder)
    {
        return $builder->where('approved', '=', 1);
    }
}

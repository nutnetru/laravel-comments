<?php
/**
 * Created by PhpStorm.
 * User: actuallymab
 * Date: 12.06.2016
 * Time: 02:13
 */

namespace Nutnet\LaravelComments;

use Nutnet\LaravelComments\Models\Comment;

trait CanComment
{
    /**
     * @param $commentable
     * @param string $commentText
     * @param int $rate
     * @return Comment
     */
    public function comment($commentable, $commentText = '', $rate = 0)
    {
        $comment = new Comment([
            'comment'        => $commentText,
            'rate'           => ($commentable->getCanBeRated()) ? $rate : null,
            'approved'       => ($commentable->mustBeApproved() && ! $this->isAdmin()) ? false : true,
        ]);

        $commentable->comments()->save($comment);

        return $comment;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commented');
    }
}

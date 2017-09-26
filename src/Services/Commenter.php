<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 26.09.17
 */

namespace Nutnet\LaravelComments\Services;

use Nutnet\LaravelComments\Models\Comment;

class Commenter
{
    /**
     * @param $entity
     * @param $comment
     * @param array $meta
     * @return Comment
     */
    public function commentAsGuest($entity, $comment, array $meta = [])
    {
        return $this->comment($entity, $comment, null, $meta);
    }

    /**
     * @param $user
     * @param $entity
     * @param $comment
     * @param array $meta
     * @return Comment
     */
    public function comment($entity, $comment, $user = null, array $meta = [])
    {
        $rate = null;
        if (!empty($meta['rate'])) {
            $rate = $meta['rate'];
            unset($meta['rate']);
        }

        if (null !== $user) {
            $result = $user->comment($entity, $comment, $rate);
        } else {
            $result = $this->createGuestComment($entity, $comment, $rate);
        }

        $result->syncMeta($meta);

        return $result;
    }

    /**
     * @param $entity
     * @param $comment
     * @param null $rate
     * @return Comment
     */
    private function createGuestComment($entity, $comment, $rate = null)
    {
        $commentEntity = new Comment([
            'comment'        => $comment,
            'rate'           => ($entity->getCanBeRated()) ? $rate : null,
            'approved'       => $entity->mustBeApproved() ? false : true
        ]);

        $entity->comments()->save($commentEntity);

        return $commentEntity;
    }
}
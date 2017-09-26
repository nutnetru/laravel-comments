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
        if (!$this->isValidCommentable($entity)) {
            throw new \InvalidArgumentException('Commentable entity class must use Commentable trait.');
        }

        $rate = null;
        if (!empty($meta['rate'])) {
            $rate = $meta['rate'];
            unset($meta['rate']);
        }

        if (null !== $user) {
            if (!$this->isValidUser($user)) {
                throw new \InvalidArgumentException('User entity class must use CanComment trait.');
            }

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
            'approved'       => ($entity->mustBeApproved() && ! $this->isAdmin()) ? false : true
        ]);

        $entity->comments()->save($commentEntity);

        return $commentEntity;
    }

    /**
     * @param $class
     * @param $traitName
     * @return bool
     */
    private function isUseTrait($class, $traitName)
    {
        $uses = class_uses($class, true);

        return in_array($traitName, $uses);
    }

    /**
     * @param $user
     * @return bool
     */
    private function isValidUser($user)
    {
        return $this->isUseTrait(get_class($user), 'Nutnet\LaravelComments\CanComment');
    }

    /**
     * @param $entity
     * @return bool
     */
    private function isValidCommentable($entity)
    {
        return $this->isUseTrait(get_class($entity), 'Actuallymab\LaravelComment\Commentable');
    }
}
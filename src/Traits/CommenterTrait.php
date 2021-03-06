<?php
/**
 * Created by PhpStorm.
 * User: Creativminds
 * Date: 19/01/19
 * Time: 21:22
 */

namespace Creativminds\Comment\Traits;


trait CommenterTrait
{
    public function comments()
    {
        return $this->hasMany(config('comment.models.comment'));
    }

    public function isCommentApproved()
    {
        return true;
    }
}

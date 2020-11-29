<?php
namespace Creativminds\Comment\Traits;

trait HasCommentTrait
{
    public function comments()
    {
        return $this->morphMany(config('comment.models.comment'), 'commentable');
    }

    public function saveComment(array $attributes)
    {
        return $this->comments()->create($attributes);
    }

    public function deleteComments()
    {
        $this->comments()->delete();
    }
}

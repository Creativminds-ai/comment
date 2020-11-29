<?php
/**
 * Created by PhpStorm.
 * User: Creativminds
 * Date: 21/01/19
 * Time: 22:16
 */

namespace Creativminds\Comment\Test\Models;

use Illuminate\Database\Eloquent\Model;
use Creativminds\Comment\Contracts\CommentContract;
use Creativminds\Comment\Traits\HasCommentTrait;

class News extends Model
{
    protected $fillable = ['content'];
}

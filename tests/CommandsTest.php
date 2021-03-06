<?php
/**
 * Created by PhpStorm.
 * User: Creativminds
 * Date: 23/01/19
 * Time: 20:34
 */

namespace Creativminds\Comment\Test;


class CommandsTest extends TestCase
{
    public function test_clear_all()
    {
        $this->saveCommentToFirstBlog();

        $this->artisan('comment:clear');

        $this->assertTrue(is_null($this->firstComment()));
    }

    public function test_approve_all()
    {
        $comment = $this->saveCommentToFirstBlog();

        $this->assertFalse($comment->isApproved());

        $this->artisan('comment:approve');

        $comment = $this->firstComment();

        $this->assertTrue($comment->isApproved());
    }
}

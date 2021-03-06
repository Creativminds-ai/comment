<?php

namespace Creativminds\Comment\Test;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Translation\TranslationServiceProvider;
use Jenssegers\Date\Date;
use Jenssegers\Date\DateServiceProvider;
use Kalnoy\Nestedset\NestedSetServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Creativminds\Comment\CommentServiceProvider;
use Creativminds\Comment\Facades\Comment;
use Creativminds\Comment\Test\Models\Blog;
use Creativminds\Comment\Test\Models\User;

class TestCase extends BaseTestCase
{
    use WithFaker;

    protected function getPackageProviders($app)
    {
        return [
            CommentServiceProvider::class,
            NestedSetServiceProvider::class,
            DateServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Comment' => Comment::class,
            'Date' => Date::class
        ];
    }

    protected function resolveApplicationHttpKernel($app)
    {
        $app->singleton('Illuminate\Contracts\Http\Kernel', 'Creativminds\Comment\Http\Kernel');
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function setUp()
    {
        parent::setUp();

        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(realpath(__DIR__ . '/../database/migrations'));
        $this->loadMigrationsFrom(realpath(__DIR__ . '/database/migrations'));
        $this->seeding();
    }

    protected function seeding()
    {
        $this->seedUser();
        $this->seedBlog();
    }

    protected function seedUser()
    {
        User::create([
            'name' => 'Test',
            'email' => 'test@mail.ru',
            'password' => \Hash::make('secret')
        ]);
    }

    protected function seedBlog()
    {
        Blog::create([
            'content' => $this->faker->realText(500)
        ]);
    }

    protected function auth()
    {
        $user = User::first();

        return $this->actingAs($user);
    }

    protected function firstBlog()
    {
        return config('comment.models_with_comments.Blog')::first();
    }

    protected function firstUser()
    {
        return config('comment.models.user')::first();
    }

    protected function firstComment()
    {
        return config('comment.models.comment')::first();
    }

    protected function saveCommentToFirstBlog()
    {
        $blog = $this->firstBlog();

        $user = $this->firstUser();

        return $blog->saveComment([
            'name' => $this->faker->firstName,
            'email' => $this->faker->email,
            'message' => $this->faker->realText(100),
            'parent_id' => 0,
            'user_id' => $user->id
        ]);
    }

}

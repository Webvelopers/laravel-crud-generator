<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommandTest extends TestCase
{
    /**
     * CRUD Generate a Post.
     */
    public function test_crud_generator_post(): void
    {
        $this->artisan('crud:generate Post')->assertExitCode(1);
    }

    /**
     * CRUD Generate a Post with API methods.
     */
    public function test_crud_generator_comment_api(): void
    {
        $this->artisan('crud:generate Comment --api')->assertExitCode(1);
    }
}

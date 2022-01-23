<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTests extends TestCase
{
    public function test_comments_get_should_exists()
    {
        $response = $this->get('/api/comments');

        $response->assertStatus(200);
    }
    public function test_comment_add_endpoint_with_post_should_exists()
    {
        $response = $this->post('/api/comment/add');

        $response->assertStatus(200);
    }
}

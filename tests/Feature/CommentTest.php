<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTests extends TestCase
{
    use RefreshDatabase;

    public function test_comments_get_should_exists()
    {
        $response = $this->get('/api/comments');

        $response->assertStatus(200);
    }
    public function test_comment_add_endpoint_with_worng_parentId_should_return_400()
    {
        $response = $this->post('/api/comment/add',["parentId"=>"-1"]);

        $response
        ->assertStatus(200)
        ->assertJson([
            'error'=>true,
            'code'=>400,
            'message'=>"Parent"
        ]);
    }
}

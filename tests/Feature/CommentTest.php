<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

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
    public function test_comment_add_should_add_Root_Comment()
    {
        $response = $this->post('/api/comment/add',[
            "username"=>"ABC",
            "comment"=>"Test"
        ]);

        $cnt = DB::table('comments')->get()->count();
        $this->assertTrue(1 == $cnt);
    }
    public function test_comment_add_should_add_Reply_Comment()
    {
        $this->post('/api/comment/add',[
            "username"=>"ABC",
            "comment"=>"Test"
        ]);

        $firstComment = DB::table('comments')->first();

        $response = $this->post('/api/comment/add',[
            "username"=>"ABC",
            "comment"=>"Test",
            "parentId"=> strval($firstComment->id)
        ]);
        $cnt = DB::table('comments')->get()->count();
        $this->assertTrue(2 == $cnt);
        DB::table('comments')->where('path_to_parent','LIKE',$firstComment->id.',%');
    }
    public function test_comments_get_should_return_inserted_comment(){
        $this->post('/api/comment/add',[
            "username"=>"ABC",
            "comment"=>"Test"
        ]);

        $response = $this->get('/api/comments');

        $response->assertStatus(200);
        $this->assertTrue($response["total"] == 1);
    }
}

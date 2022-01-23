<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
Use \Carbon\Carbon;

class CommentController extends Controller
{
    public function index(){

    }

    public function addComment(){
        $parentId = request('parentId');
        $username = request('username');
        $comment = request('comment');
        $pathToParent = '';
        $parent_create_at = Carbon::now();
        if($parentId != null){
            var_dump($parentId);
            $parent = Comment::find($parentId);
            if($parent == null)
            {
                return array(
                    'error'=>true,
                    'code'=>400,
                    'message'=>"Parent"
                );
            }
        }
    }
}

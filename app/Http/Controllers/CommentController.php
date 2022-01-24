<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
Use \Carbon\Carbon;

class CommentController extends Controller
{
    public function index(){
        return Comment::
            orderBy("parent_create_at",'desc')->
            orderBy("path_to_parent")
            ->paginate(2);
    }

    public function addComment(){
        $parentId = request('parentId');
        $username = request('username');
        $comment = request('comment');
        $pathToParent = '';
        $parent_create_at = Carbon::now();
        //Check if $parentId is set and valid(exists)
        if($parentId != null){
            $parent = Comment::find($parentId);
            if($parent == null)
            {
                return [
                    'error'=>true,
                    'code'=>400,
                    'message'=>"Parent"
                ];
            }
            //Find grandparent for setting parent_create_at property
            print(explode(",",$parent->path_to_parent)[0]);
            $grandParent = Comment::find(explode(",",$parent->path_to_parent)[0]);
            $record = new Comment;
            $record->username = $username;
            $record->path_to_parent = "";
            $record->comment = $comment;

            //This will help us to sort related comments in querying
            $record->parent_create_at = $grandParent->created_at;
            $record->save();

            //Set the path to parent with inserted id
            $record->path_to_parent = $parent->path_to_parent.",".$record->id;
            $record->save();
            return [
                'error'=>false,
                'comment'=>$record
            ];
        }
        else{//Thi is a root comment not a reply
            $record = new Comment;
            $record->username = $username;
            $record->comment = $comment;
            $record->path_to_parent = "";
            $record->save();

            //Root is parent
            $record = Comment::find($record->id);
            $record->parent_create_at = $record->created_at;
            $record->path_to_parent = strval($record->id);
            $record->save();
            return [
                'error'=>false,
                'comment'=>$record
            ];
        }
    }
}

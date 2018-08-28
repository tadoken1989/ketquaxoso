<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;

class PostController extends Controller
{
    //  detail post
    public function detailPost($slug){
        $detail = Post::where('slug',$slug)->first();
        $all = Post::orderBy('id', 'desc')->paginate(10);
        return view('frontend.posts.detailPost',compact('detail','all'));
    }

    //all post
    public function allPost(){
        $postsAll = Post::orderBy('id', 'desc')->paginate(10);
        return view('frontend.posts.allPosts',compact('postsAll'));
    }

    //function post for tag
    public function postTag($slug){
        $postTags = Tag::where('slug',$slug)->first();
        $post= $postTags->posts;
        return view('frontend.posts.postByTag',compact('post'));
    }
}

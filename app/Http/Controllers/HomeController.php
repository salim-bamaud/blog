<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Report;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request){
        // $posts = Post::orderBy('id')->cursorPaginate(10);
        // return view('posts.index' , compact('posts'));
        return view('posts.index' , [
            'posts' => Post::latest()->filter(request(['tag' , 'search']))->cursorPaginate(10)
        ]);
    }

    public function show(Post $slug){
        return view('posts.show' , ['post' => $slug]);
    }


    // Store  post comments
    public function store_comment(Request $request , $id = null){

        $request->validate([
            'post_id' => ['required' , 'numeric'],
            'content'=> ['required'],
        ]);

        Comment::create([
            'post_id' => $request->post_id,
            'content' => $request->content,
            'user_id' => Auth::id(),
            // 'parent_id' => $request->parent_id ?? null,
            'parent_id' => $id,
        ]);

        return redirect()->back()->with('success','comment submitted successfully.');
    }

    // Store  post reports
    public function store_post_report(Request $request){
        $request->validate([
            'post_id' => ['required' , 'numeric'],
            'content' => 'required',
        ]);

        Report::create([
            'post_id' => $request->post_id,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success','report submitted successfully.');
    }
}

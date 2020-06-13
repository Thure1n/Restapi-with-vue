<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use App\Post;
class PostController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('post_api')->except('index');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::orderBy('created_at','DESC')->paginate(5);
        //return PostResource::collection($posts);
        return response([
            'status' => '1',
            'message' => 'Api key correct',
            'posts' => $posts
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = $request->isMethod('put') ? Post::findOrFail
        ($request->post_id) : new Post;
        $post->id = $request->post_id;
        $post->user_id = $request->user_id;
        $post->title = $request->title;
        $post->description = $request->description;

        if($post->save())
        {
            return new PostResource($post);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if($post->delete())
        {
            return new PostResource($post);
        }
    }
}

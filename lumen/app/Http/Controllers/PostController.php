<?php


namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{


  /**
   * Get all Posts
   * @return Array
   */
  public function index() {
    $posts = Post::all();

    return response()->json($posts, 200);
  }

  /**
   * Create a new Post
   * @param  Request $request [title, content]
   * @return Object
   */
  public function create(Request $request) {
    $post = new Post();

    $post->title = $request->title;
    $post->content = $request->content;
    $post->save();

    return response()->json($post, 201);
  }


  /**
   * Return a single Post
   * @param  int    $id
   * @return Object
   */
  public function show(int $id) {
    $post = Post::find($id);

    return response()->json($post, 200);
  }

  /**
   * Update a Post
   * @param  Request $request [title, content]
   * @param  int  $id
   * @return Object
   */
  public function update(Request $request, int $id) {
    $post = Post::find($id);

    $post->title = $request->title;
    $post->content = $request->content;

    $post->update();

    return response()->json($post, 200);
  }


  /**
   * Delete a Post
   * @param  int    $id
   * @return String
   */
  public function destroy(int $id) {
    $post = Post::find($id);
    $post->delete();

    return response()->json('Post removed', 200);
  }

}

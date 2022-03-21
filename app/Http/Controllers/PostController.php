<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\PostCategory;

use Exception;

class PostController extends Controller
{
    public function getAdd()
    {
        $postCategories = PostCategory::all();
        return view('admin.post.add', ['categories' => $postCategories]);
    }

    public function getAll()
    {
        $posts = Post::orderByDesc('id')->get();
        return view('admin.post.all', ['posts' => $posts]);
    }

    public function postAdd(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'unique:posts,name',
                'slug' => 'unique:posts,slug',
            ],
            [
                'name.unique' => 'Please choose another name',
                'slug.unique' => 'Please choose another slug',
            ]
        );
        $post = new Post();
        $post->name = $request->name;
        $post->slug = $request->slug;
        $post->keywords = $request->keywords;
        $post->category_id = $request->category_id;
        $post->content = $request->content;
        $post->description = $request->description;
        $post->status = $request->status;

        $get_image = $request->file('image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image =  $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('uploads/post', $new_image);
            $post->image = $new_image;
        } else {
            $post->image = '';
        }

        $post->save();
        return redirect('admin/post/all')->with('Notice', 'Post added successfully');
    }

    public function getInactive($id)
    {
        // DB::table('post')->where('id', $id)->update(['status' => 1]);
        $post = Post::find($id);
        $post->status = 1;
        $post->save();
        return redirect('admin/post/all')->with('Notice', 'Post disable successfully');
    }

    public function getActive($id)
    {
        // DB::table('post')->where('id', $id)->update(['status' => 0]);
        $post = Post::find($id);
        $post->status = 0;
        $post->save();
        return redirect('admin/post/all')->with('Notice', 'Post enable successfully');
    }

    public function getEdit($id)
    {
        $post = Post::find($id);
        $postCategories = PostCategory::all();
        return view('admin.post.edit', ['post' => $post, 'categories' => $postCategories]);
    }

    public function postEdit($id, Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'unique:posts,name,' . $id,
                'slug' => 'unique:posts,slug,' . $id,
            ],
            [
                'name.unique' => 'Please choose another name',
                'slug.unique' => 'Please choose another slug',
            ]
        );
        $post = Post::find($id);
        $post->name = $request->name;
        $post->slug = $request->slug;
        $post->keywords = $request->keywords;
        $post->category_id = $request->category_id;
        $post->content = $request->content;
        $post->description = $request->description;
        $post->status = $request->status;

        $get_image = $request->file('image');
        if ($get_image) {
            if ($post->image) {
                try {
                    unlink('public/uploads/post/' . $post->image);
                } catch (Exception $e) {
                }
            }
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image =  $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('uploads/post', $new_image);
            $post->image = $new_image;
        } else {
        }
        $post->save();

        return redirect('admin/post/all')->with('Notice', 'Post update successfully');
    }

    public function getDelete($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect('admin/post/all')->with('Notice', 'Post deleted successfully');
    }
}

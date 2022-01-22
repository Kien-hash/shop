<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function postAdd(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required',
        ], [
            'comment.required' => 'Nội dung bình luận không được để trống'
        ]);

        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->name = $request->name;
        $comment->product_id = $request->product_id;
        $comment->status = 1;
        $comment->parent_id = 0;
        $comment->save();

        return redirect()->back()->with('Notice', 'Bình luận của bạn đã được gửi, hãy chờ người quản trị phê duyệt và phản hồi!');
    }

    public function getInactive($id)
    {
        $comment = Comment::find($id);
        $comment->status = 1;
        $children = Comment::where('parent_id', $comment->id)->get();
        foreach ($children as $child) {
            $child->status = 1;
            $child->save();
        }
        $comment->save();
        return redirect('admin/comment/all')->with('Notice', 'Comment disable successfully');;
    }

    public function getActive($id)
    {
        $comment = Comment::find($id);
        $comment->status = 0;
        $children = Comment::where('parent_id', $comment->id)->get();
        foreach ($children as $child) {
            $child->status = 0;
            $child->save();
        }
        $comment->save();
        return redirect('admin/comment/all')->with('Notice', 'Comment enable successfully');;
    }

    public function getAll()
    {
        $comments = Comment::orderByDesc('id')->get();
        return view('admin.comment.all', ['comments' => $comments]);
    }

    public function getDelete($id)
    {
        $comment = Comment::find($id);
        $children = Comment::where('parent_id', $id)->get();

        $comment->delete();
        foreach ($children as $child) {
            $child->delete();
        }
        return redirect()->back()->with('Notice', 'Deleted successfully!');
    }

    public function postReply($id, Request $request)
    {
        $this->validate($request, [
            'comment' => 'required',
        ], [
            'comment.required' => 'Comment can not be blank!'
        ]);
        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->name = 'admin';
        $comment->product_id = $request->product_id;
        $comment->status = 0;
        $comment->parent_id = $id;
        $comment->save();

        return redirect()->back()->with('Notice', 'Replied');
    }
}

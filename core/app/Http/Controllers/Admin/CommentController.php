<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Product;
use App\Reply;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function products()
    {
        $page_title = 'Product List';
        $empty_message = 'No data found';

        $products = Product::where('status',1)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->whereHas('category', function ($query) {
            $query->where('status',1);
        })->whereHas('subcategory', function ($query) {
            $query->where('status',1);
        })->latest()->with('comments')->paginate(getPaginate());

        return view('admin.comment.index',compact('page_title','products','empty_message'));
    }

    public function comments($id)
    {
        $product = Product::findOrFail($id);
        $page_title = 'Comments';
        $comments = Comment::where('product_id',$product->id)->with(['user','replies.user'])->get();
        $empty_message = 'No data found';
        return view('admin.comment.details',compact('page_title','comments','empty_message'));
    }

    public function commentDelete(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|gt:0|integer'
        ]);

        $comment = Comment::findOrFail($request->comment_id);

        foreach ($comment->replies as $item) {
            $item->delete();
        }

        $comment->delete();

        $notify[] = ['success', 'Comment deleted successfully'];
        return back()->withNotify($notify);
    }

    public function replyDelete(Request $request)
    {
        $request->validate([
            'reply_id' => 'required|gt:0|integer'
        ]);

        $reply = Reply::findOrFail($request->comment_id);

        $reply->delete();

        $notify[] = ['success', 'Reply deleted successfully'];
        return back()->withNotify($notify);
    }
}

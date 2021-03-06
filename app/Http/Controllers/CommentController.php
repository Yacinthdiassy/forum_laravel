<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Topic;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Topic $topic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Topic $topic)
    {
        \request()->validate([
            'content' => 'required|min:5',
        ]);
        $comment = new Comment();
        $comment->content = \request('content');
        $comment->user_id = auth()->user()->id;

        $topic->comments()->save($comment);
        return redirect()->route('topics.show', $topic);
    }

    /**
     * @param Comment $commnet
     */
    public function storeCommentReply(Comment $comment)
    {
        \request()->validate([
            'replyComment' => 'required|min:3',
        ]);

        $commentReply = new Comment();
        $commentReply->content = \request('replyComment');
        $commentReply->user_id = auth()->user()->id;

        $comment->comments()->save($commentReply);
        return redirect()->back();
    }

}

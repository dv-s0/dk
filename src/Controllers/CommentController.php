<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Helpers\Response;

class CommentController
{
    // عرض جميع التعليقات
    public function index()
    {
        $comments = Comment::all();
        return Response::view('comments/index', compact('comments'));
    }

    // إرسال رد تلقائي على تعليق
    public function reply($commentId, $responseText)
    {
        $comment = Comment::find($commentId);
        if ($comment) {
            // إرسال الرد إلى فيسبوك أو المنصة
            $this->sendReplyToFacebook($comment->sender_id, $responseText);
            $comment->status = 'replied';
            $comment->save();

            return Response::json(['success' => true, 'message' => 'Replied successfully']);
        }

        return Response::json(['success' => false, 'message' => 'Comment not found'], 404);
    }

    // إرسال الرد إلى فيسبوك (افتراضي)
    private function sendReplyToFacebook($senderId, $responseText)
    {
        // استدعاء API فيسبوك لإرسال الرد
    }
}


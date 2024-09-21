<?php

namespace App\Controllers;

use App\Models\Message;
use App\Helpers\Response;

class MessageController
{
    // عرض جميع الرسائل
    public function index()
    {
        $messages = Message::all();
        return Response::view('messages/index', compact('messages'));
    }

    // إرسال رد تلقائي على رسالة
    public function reply($messageId, $responseText)
    {
        $message = Message::find($messageId);
        if ($message) {
            // إرسال الرد إلى فيسبوك أو المنصة
            $this->sendReplyToFacebook($message->sender_id, $responseText);
            $message->status = 'replied';
            $message->save();

            return Response::json(['success' => true, 'message' => 'Replied successfully']);
        }

        return Response::json(['success' => false, 'message' => 'Message not found'], 404);
    }

    // إرسال الرد إلى فيسبوك (افتراضي)
    private function sendReplyToFacebook($senderId, $responseText)
    {
        // استدعاء API فيسبوك لإرسال الرسالة
        // هنا يتم تنفيذ الكود الخاص بـ cURL للتفاعل مع API فيسبوك
    }
}


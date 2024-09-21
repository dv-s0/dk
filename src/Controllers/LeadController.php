<?php

namespace App\Controllers;

use App\Models\Lead;
use App\Models\Message;
use App\Helpers\Response;

class LeadController
{
    // تحويل رسالة إلى Lead
    public function convertToLead($messageId)
    {
        $message = Message::find($messageId);
        if ($message && $this->containsPhoneNumber($message->content)) {
            $lead = new Lead();
            $lead->phone = $this->extractPhoneNumber($message->content);
            $lead->message_id = $message->id;
            $lead->save();

            return Response::json(['success' => true, 'message' => 'Lead created successfully']);
        }

        return Response::json(['success' => false, 'message' => 'No phone number found'], 400);
    }

    // التحقق من وجود رقم هاتف في الرسالة
    private function containsPhoneNumber($text)
    {
        return preg_match('/\d{10}/', $text);
    }

    // استخراج رقم الهاتف من الرسالة
    private function extractPhoneNumber($text)
    {
        preg_match('/\d{10}/', $text, $matches);
        return $matches[0] ?? null;
    }
}

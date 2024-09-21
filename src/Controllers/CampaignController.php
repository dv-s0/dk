<?php

namespace App\Controllers;

use App\Models\Campaign;
use App\Helpers\Response;
use OpenAI\ChatGPT;

class CampaignController
{
    // عرض جميع الحملات الإعلانية
    public function index()
    {
        $campaigns = Campaign::all();
        return Response::view('campaigns/index', compact('campaigns'));
    }

    // تحليل حملة إعلانية باستخدام ChatGPT
    public function analyze($campaignId)
    {
        $campaign = Campaign::find($campaignId);
        if ($campaign) {
            $gpt = new ChatGPT();
            $analysis = $gpt->analyzeCampaign($campaign);

            return Response::json(['success' => true, 'analysis' => $analysis]);
        }

        return Response::json(['success' => false, 'message' => 'Campaign not found'], 404);
    }

    // إرسال تقرير عن الحملة
    public function sendReport($campaignId)
    {
        $campaign = Campaign::find($campaignId);
        if ($campaign) {
            $report = $this->generateReport($campaign);
            // إرسال التقرير عبر البريد الإلكتروني
        }
    }

    private function generateReport($campaign)
    {
        // هنا يتم توليد التقرير بناءً على بيانات الحملة
        return "Campaign Report for {$campaign->name}";
    }
}

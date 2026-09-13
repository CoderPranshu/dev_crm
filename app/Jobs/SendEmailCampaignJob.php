<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\EmailCampaign;
use Illuminate\Support\Facades\Mail;

class SendEmailCampaignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $campaignId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($campaignId)
    {
        $this->campaignId = $campaignId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $campaign = EmailCampaign::with('template', 'subscribers')->find($this->campaignId);

        foreach ($campaign->subscribers as $subscriber) {

            Mail::send([], [], function ($message) use ($campaign, $subscriber) {
                $message->to($subscriber->email)
                    ->subject($campaign->subject)
                    ->html($campaign->template->body);
            });

            // Update pivot sent_at timestamp
            $subscriber->pivot->sent_at = now();
            $subscriber->pivot->save();
        }

        $campaign->update(['status' => 'sent']);
    }
}

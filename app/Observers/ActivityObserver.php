<?php

namespace App\Observers;

use App\Mail\ActivityEmails;
use App\Models\Activity;
use App\Models\SiteConfiguration;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class ActivityObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Activity "created" event.
     */
    public function created(Activity $activity): void
    {
        if ($activity->status === 'draft'){
            return;
        }

        $user = $activity->user()->first();
        $email_configs_res = SiteConfiguration::where('key','like',"email.activity.".$activity->status."%")->get();

        if(isset($user->email) && !is_null($user->email)
            && $user->send_email_check()){

            $email_content = $email_configs_res->where('key','email.activity.'.$activity->status.'.content')->first();
            $email_subject = $email_configs_res->where('key','email.activity.'.$activity->status.'.subject')->first();

            $email_configs =[
                'content'=> $email_content?$email_content->value:"There has been an update on your activity: ".$activity->title,
                'subject' => $email_subject?$email_subject->value:"Activity Status update: ".$activity->id,
            ];

            try {
                Mail::to($user)->send(new ActivityEmails($activity, $user, $email_configs));
            } catch (\Exception $e) {
                Log::error('Error sending assignment email: '.$e->getMessage());
            }
        }
    }

    /**
     * Handle the Activity "updated" event.
     */
    public function updated(Activity $activity): void
    {
        // To check if there was an update on the activity status
        if (!$activity->isDirty('status')){
            return;
        }

        $user = $activity->user()->first();
        $email_configs_res = SiteConfiguration::where('key','like',"email.activity.".$activity->status."%")->get();

        if(isset($user->email) && !is_null($user->email)
            && $user->send_email_check()){
            $email_content = $email_configs_res->where('key','email.activity.'.$activity->status.'.content')->first();
            $email_subject = $email_configs_res->where('key','email.activity.'.$activity->status.'.subject')->first();

            $email_configs =[
                'content'=> $email_content?$email_content->value:"There has been an update on your activity: ".$activity->title,
                'subject' => $email_subject?$email_subject->value:"Activity Status update: ".$activity->id,
            ];

            try {
                Mail::to($user)->send(new ActivityEmails($activity, $user, $email_configs));
            } catch (\Exception $e) {
                Log::error('Error sending assignment email: '.$e->getMessage());
            }
        }
    }
}

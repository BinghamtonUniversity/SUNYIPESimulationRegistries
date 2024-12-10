<?php

namespace App\Mail;

use AllowDynamicProperties;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

///**
// * @property string $content
// * @property array $config_email
// */
class ActivityEmails extends Mailable
{
    use Queueable, SerializesModels;

    private string $content;
    private array $config_email;

    /**
    * Create a new message instance.
    *
    * @param Activity $activity
    * @param User $user
    * @param array $config_email
    */
    public function __construct(Activity $activity, User $user, Array $config_email)
    {
        $email_data = [
            'user'=>[
                'first_name'=> $user->first_name,
                'last_name'=>$user->last_name,
            ],
            'activity'=>[
                'title'=>$activity['title'],
                'description'=>$activity['description'],
                'status'=>$activity['status'],
            ],
            'contact'=>[
                'name'=>$activity['contact_name'],
                'email'=>$activity['contact_email'],
            ]
        ];

        $m = new \Mustache_Engine;
        $this->content = $m->render($config_email['content'],$email_data);
        $this->config_email = $config_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.email_raw')
            ->with(['content'=>$this->content])
            ->subject($this->config_email['subject']);

    }

}

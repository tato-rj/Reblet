<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberInvitationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $email, $project;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request, $project)
    {
        $this->name = $request->name;
        $this->project = $project;
        $this->email = $request->email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Invitation to join ' . $this->project->team->leader()->name . '\'s team')->markdown('emails.member.invite');
    }
}

<?php

namespace App\Notifications;

use App\Entities\Project;
use App\Entities\ProjectMilestone;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MyResetPassword extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     * https://laravel.com/docs/5.3/notifications#formatting-mail-messages
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
//        $projectObj = Project::where('uuid', '398ee3b0-43b6-11e8-95ad-cb924ea94f04')->firstOrFail();
//        $userObj = User::where('uuid', '2553f7a0-0ccf-11e8-bff9-d1e8efd10d99')->firstOrFail();
//        $taskSubTasks = ProjectMilestone::getCustomerTasks($projectObj->id, $userObj->id);
//        $pdf = PDF::loadView('invoice', compact('taskSubTasks','projectObj', 'userObj'));


        return (new MailMessage)
            ->success()
//            ->attachData($pdf->output(), 'filename.pdf')
//            ->attach(storage_path('app/public/pdf/vikas-dwivedi.pdf'),[
//                'as' => 'resume.pdf',
//                'mime' => 'application/pdf',
//            ])
            ->from('support@allrenos.com','Support')
            ->subject('Reset Account Password')
            ->greeting('Hi!')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', url(config('app.url').route('password.reset', $this->token, false)))
            ->line('If you did not request a password reset, no further action is required.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

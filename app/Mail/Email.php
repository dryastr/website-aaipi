<?php

namespace App\Mail;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    public $template;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($template, $data)
    {
        $this->template = $template;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     *
     * @throws Exception
     */
    public function build()
    {
        $title = $this->data['title'];
        $content = $this->data['content'];

        // Render email markdown
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject($title)
            ->markdown('emails.layout', [
                'template' => 'emails.'.$this->template,
                'content' => $content,
            ]);
    }
}

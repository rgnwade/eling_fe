<?php

namespace Modules\User\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Modules\Media\Entities\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;

class WelcomeActivate extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $activationCode;
    public $uuid;
    public $heading;
    public $text;
    public $url;
    public $link;
    private $firstName;


    public function __construct($firstName, $uuid, $activationCode)
    {
        $this->firstName = $firstName;
        $this->activationCode = $activationCode;
        $this->uuid = $uuid;
        $this->heading = trans('user::mail.welcome', ['name' => $firstName]);
        $this->text = trans('user::mail.account_created');
        $this->url = URL::to('activate/' . $uuid . '/' . $activationCode);
        $this->link = trans('user::mail.activation_link', ['url' => $this->url]);
    }

      public function build()
    {
        return $this->subject(trans('user::mail.welcome', ['name' => $this->firstName, ]))
            ->view("emails.{$this->getViewName()}", [
                'logo' => File::findOrNew(setting('storefront_mail_logo'))->path,
            ]);
    }

    private function getViewName()
    {
        return 'welcome' . (is_rtl() ? '_rtl' : '');
    }
}

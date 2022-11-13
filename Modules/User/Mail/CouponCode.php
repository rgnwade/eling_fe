<?php

namespace Modules\User\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Modules\Media\Entities\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;
use Themes\Storefront\Admin\Banner;

class CouponCode extends Mailable 
{
    use  SerializesModels;

    public function build()
    {
        $banner = Banner::findByName('storefront_coupon_email_banner');
        return $this->subject($banner->caption_1)
            ->view("emails.coupon_code", [
                'logo' => File::findOrNew(setting('storefront_mail_logo'))->path,
                'image' => $banner->image->path
            ]);
    }
}

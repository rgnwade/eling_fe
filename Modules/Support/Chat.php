<?php

namespace Modules\Support;

use Modules\Media\Entities\File;
use Modules\User\Entities\User;

class Chat
{
    /**
     * Path of the resource.
     *
     * @var string
     */
    public static function properties($user, $company)
    {
        $chat = array();
        $seller = $company->users->first();
        $user_company = $user->company;

        $chat["client_group_id"] = strval($seller->id) . "-" . strval($user->id);
        $chat["group_name"] = $company->name . " - " . $user->first_name;
        $chat["company"] = SELF::setChatUser($seller, SELF::isSeller($company));
        $chat["user"] = SELF::setChatUser($user, SELF::isSeller($user_company));
        $chat["icon"] = $company->baseImage->path;

        return $chat;
    }

    private static function setChatUser($user, $is_seller)
    {
        return array(
            "id" => $user->uuid,
            "name" => $user->first_name,
            "is_seller" =>  $is_seller
        );
    }

    private static function isSeller($company)
    {
        return $company != null && $company->is_seller;
    }

    public static function getChatAdmin()
    {
        # TODO: set cache for chatAdminList
        $admins = User::getChatAdmins();
        $defaultImage = File::findOrNew(setting('storefront_footer_logo'))->path;
        if ($admins->isNotEmpty()) {
            return $admins->map(function ($admin) use ($defaultImage) {
                return [
                    'userId' => $admin->uuid,
                    'displayName' => 'Admin-'.$admin->first_name,
                    'imageLink' => $defaultImage
                ];
            });
        } else {
            return [];
        }
    }
}

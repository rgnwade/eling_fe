<?php

namespace Modules\User\Sidebar;

use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\Group;
use Modules\Admin\Sidebar\BaseSidebarExtender;

class SidebarExtender extends BaseSidebarExtender
{
    public function extend(Menu $menu)
    {
        $menu->group(trans('admin::sidebar.system'), function (Group $group) {
            $group->item(trans('user::sidebar.users'), function (Item $item) {
                $item->weight(5);
                $item->icon('fa fa-users');
                $item->route('admin.users.index');
                $item->authorize(
                    $this->auth->hasAccess('admin.users.index') || $this->auth->hasAccess('roles.index')
                );

                // users
                $item->item(trans('user::sidebar.users'), function (Item $item) {
                    $item->weight(5);
                    $item->route('admin.users.index');
                    $item->authorize(
                        $this->auth->hasAccess('admin.users.index')
                    );
                });

                $item->item(trans('user::sidebar.verification'), function (Item $item) {
                    $item->weight(8);
                    $item->route('admin.verify.index');
                    $item->authorize(
                        $this->auth->hasAccess('admin.verify.index')
                    );
                });

                // roles
                $item->item(trans('user::sidebar.roles'), function (Item $item) {
                    $item->weight(10);
                    $item->route('admin.roles.index');
                    $item->authorize(
                        $this->auth->hasAccess('admin.roles.index')
                    );
                });



                // Activity Log
                $item->item(trans('user::sidebar.log'), function (Item $item) {
                    $item->weight(30);
                    $item->route('admin.log.index');
                    $item->authorize(
                        $this->auth->hasAccess('admin.log.index')
                    );
                });
            });
        });

        $menu->group(trans('admin::sidebar.content'), function (Group $group) {
            $group->item(trans('user::sidebar.user'), function (Item $item) {
                $item->icon('fa fa-user');
                $item->weight(30);
                $item->route('vendor.users.index');
                $item->authorize(
                    $this->auth->hasAccess('vendor.users.index')
                );
            });
        });
    }
}

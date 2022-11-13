<?php

namespace Modules\Company\Sidebar;

use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\Group;
use Modules\Admin\Sidebar\BaseSidebarExtender;

class SidebarExtender extends BaseSidebarExtender
{
    public function extend(Menu $menu)
    {
        $menu->group(trans('admin::sidebar.content'), function (Group $group) {
            $group->item(trans('company::company.companies'), function (Item $item) {
                $item->icon('fa fa-building');
                $item->weight(20);
                $item->route('admin.companies.index');
                $item->authorize(
                    $this->auth->hasAccess('admin.company.index')
                );
            });
            $group->item(trans('company::company.company'), function (Item $item) {
                $item->icon('fa fa-building');
                $item->weight(40);
                $item->route('vendor.companies.edit', $this->auth->user()->company_id);
                $item->authorize(
                    $this->auth->hasAccess('vendor.company.edit')
                );
            });
        });
    }
}

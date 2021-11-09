<?php

namespace TypiCMS\Modules\Subscriptions\Composers;

use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (Gate::denies('read subscriptions')) {
            return;
        }
        $view->sidebar->group(__('Users and roles'), function (SidebarGroup $group) {
            $group->id = 'users';
            $group->addItem(__('Subscriptions'), function (SidebarItem $item) {
                $item->id = 'subscriptions';
                $item->icon = config('typicms.subscriptions.sidebar.icon');
                $item->weight = config('typicms.subscriptions.sidebar.weight');
                $item->route('admin::index-subscriptions');
            });
        });
    }
}

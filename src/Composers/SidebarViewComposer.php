<?php

namespace TypiCMS\Modules\Subscriptions\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (Gate::denies('see-all-subscriptions')) {
            return;
        }
        $view->sidebar->group(__('Content'), function (SidebarGroup $group) {
            $group->id = 'content';
            $group->weight = 30;
            $group->addItem(__('Subscriptions'), function (SidebarItem $item) {
                $item->id = 'subscriptions';
                $item->icon = config('typicms.subscriptions.sidebar.icon');
                $item->weight = config('typicms.subscriptions.sidebar.weight');
                $item->route('admin::index-subscriptions');
                $item->append('admin::create-subscription');
            });
        });
    }
}

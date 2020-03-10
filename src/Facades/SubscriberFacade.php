<?php

namespace TypiCMS\Modules\Subscriptions\Facades;

use Illuminate\Support\Facades\Facade;

class SubscriberFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Subscriber';
    }
}

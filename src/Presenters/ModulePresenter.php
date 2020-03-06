<?php

namespace TypiCMS\Modules\Subscriptions\Presenters;

use TypiCMS\Modules\Core\Presenters\Presenter;

class ModulePresenter extends Presenter
{
    public function title()
    {
        return $this->entity->owner->first_name . ' ' . $this->entity->owner->last_name;
    }
}

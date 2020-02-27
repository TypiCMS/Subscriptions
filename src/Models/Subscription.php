<?php

namespace TypiCMS\Modules\Subscriptions\Models;

use Illuminate\Support\Carbon;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;
use TypiCMS\Modules\Subscriptions\Presenters\ModulePresenter;

class Subscription extends Base
{
    use Historable;
    use PresentableTrait;

    protected $table = 'subscriptions';

    protected $presenter = ModulePresenter::class;

    protected $guarded = ['id', 'exit'];

    protected $with = ['owner'];

    protected $appends = ['status'];

    public function owner()
    {
        return $this->morphTo();
    }

    public function getStatusAttribute()
    {
        if ($this->onTrial()) {
            return 'onTrial';
        }

        if ($this->onGracePeriod()) {
            return 'onGracePeriod';
        }

        if ($this->cancelled()) {
            return 'cancelled';
        }

        if ($this->ended()) {
            return 'ended';
        }

        if ($this->active()) {
            return 'active';
        }

        return 'inactive';
    }

    /**
     * Determine if the subscription is active.
     *
     * @return bool
     */
    protected function active()
    {
        return is_null($this->ends_at) || $this->onTrial() || $this->onGracePeriod();
    }

    /**
     * Determine if the subscription has ended and the grace period has expired.
     *
     * @return bool
     */
    protected function ended()
    {
        return $this->cancelled() && !$this->onGracePeriod();
    }

    /**
     * Determine if the subscription is within its trial period.
     *
     * @return bool
     */
    protected function onTrial()
    {
        return $this->trial_ends_at && Carbon::parse($this->trial_ends_at)->isFuture();
    }

    /**
     * Determine if the subscription is within its grace period after cancellation.
     *
     * @return bool
     */
    protected function onGracePeriod()
    {
        return $this->ends_at && Carbon::parse($this->ends_at)->isFuture();
    }

    /**
     * Determine if the subscription is recurring and not on trial.
     *
     * @return bool
     */
    protected function recurring()
    {
        return !$this->onTrial() && !$this->cancelled();
    }

    /**
     * Determine if the subscription is no longer active.
     *
     * @return bool
     */
    protected function cancelled()
    {
        return !is_null($this->ends_at);
    }
}

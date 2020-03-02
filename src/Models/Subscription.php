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

    public function getStatusAttribute(): string
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
     */
    protected function active(): bool
    {
        return is_null($this->ends_at) || $this->onTrial() || $this->onGracePeriod();
    }

    /**
     * Determine if the subscription has ended and the grace period has expired.
     */
    protected function ended(): bool
    {
        return $this->cancelled() && !$this->onGracePeriod();
    }

    /**
     * Determine if the subscription is within its trial period.
     */
    protected function onTrial(): bool
    {
        return $this->trial_ends_at && Carbon::parse($this->trial_ends_at)->isFuture();
    }

    /**
     * Determine if the subscription is within its grace period after cancellation.
     */
    protected function onGracePeriod(): bool
    {
        return $this->ends_at && Carbon::parse($this->ends_at)->isFuture();
    }

    /**
     * Determine if the subscription is recurring and not on trial.
     */
    protected function recurring(): bool
    {
        return !$this->onTrial() && !$this->cancelled();
    }

    /**
     * Determine if the subscription is no longer active.
     */
    protected function cancelled(): bool
    {
        return !is_null($this->ends_at);
    }
}

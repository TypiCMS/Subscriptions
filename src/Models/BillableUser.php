<?php

namespace TypiCMS\Modules\Subscriptions\Models;

use TypiCMS\Modules\Users\Models\User;
use Laravel\Cashier\Billable;

class BillableUser extends User
{
    use Billable;

    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'activated',
        'superuser',
        'api_token',
        'email_verified_at',
        'street',
        'number',
        'zip',
        'city',
        'country',
    ];

    public function taxPercentage()
    {
        return 21;
    }

    /**
     * Get the receiver information for the invoice.
     * Typically includes the name and some sort of (E-mail/physical) address.
     *
     * @return array An array of strings
     */
    public function getInvoiceInformation()
    {
        return [$this->first_name . ' ' . $this->last_name, $this->email, $this->street . ' ' . $this->number, $this->zip . ' ' . $this->city, $this->country];
    }

    /**
     * Get additional information to be displayed on the invoice. Typically a note provided by the customer.
     *
     * @return string|null
     */
    public function getExtraBillingInformation()
    {
        return null;
    }

    /**
     * @return string
     * @link https://docs.mollie.com/reference/v2/payments-api/create-payment#parameters
     * @example 'nl_NL'
     */
    public function getLocale()
    {
        switch (app()->getLocale()) {
            case 'fr':
                $locale = 'fr_BE';
                break;
            case 'nl':
                $locale = 'nl_BE';
                break;
            default:
                $locale = 'en_US';
                break;
        }

        return $locale;
    }
}

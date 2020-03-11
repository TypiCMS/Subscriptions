<?php

namespace TypiCMS\Modules\Subscriptions\Models;

use Laravel\Cashier\Billable;
use TypiCMS\Modules\Users\Models\User;

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
        'tax_percentage',
    ];

    public function taxPercentage()
    {
        return $this->tax_percentage;
    }

    /**
     * Get the receiver information for the invoice.
     * Typically includes the name and some sort of (E-mail/physical) address.
     */
    public function getInvoiceInformation(): array
    {
        return [$this->first_name.' '.$this->last_name, $this->email, $this->street.' '.$this->number, $this->zip.' '.$this->city, $this->country];
    }

    /**
     * Get additional information to be displayed on the invoice. Typically a note provided by the customer.
     */
    public function getExtraBillingInformation(): ?string
    {
        return null;
    }

    public function mollieCustomerFields(): array
    {
        return [
            'email' => $this->email,
            'name' => "$this->first_name $this->last_name",
            'locale' => $this->getLocale(),
            'metadata' => $this->getMetadata(),
        ];
    }

    public function getMetaData(): string
    {
        $data = [
            'street' => $this->street,
            'number' => $this->number,
            'zip' => $this->zip,
            'city' => $this->city,
            'country' => $this->country,
        ];

        return json_encode($data);
    }

    /**
     * @return string
     *
     * @see https://docs.mollie.com/reference/v2/payments-api/create-payment#parameters
     *
     * @example 'nl_NL'
     */
    public function getLocale()
    {
        switch (app()->getLocale()) {
            case 'fr':
                $locale = 'fr_FR';

                break;

            case 'nl':
                $locale = 'nl_NL';

                break;

            case 'de':
                $locale = 'de_DE';

                break;

            case 'it':
                $locale = 'it_IT';

                break;

            case 'es':
                $locale = 'es_ES';

                break;

            case 'pt':
                $locale = 'pt_PT';

                break;

            default:
                $locale = 'en_US';

                break;
        }

        return $locale;
    }
}

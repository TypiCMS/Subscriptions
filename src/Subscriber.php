<?php

namespace TypiCMS\Modules\Subscriptions;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use Money\Parser\DecimalMoneyParser;

class Subscriber
{
    public function planPriceFormat($price, $tax = 0, $currency = 'EUR', $locale = 'en_US')
    {
        if ($tax == 0) {
            $tax = auth()->user()->taxPercentage();
        }

        $amount = ((floatval($price) / 100) * $tax) + $price;
        $intAmount = $this->amountToInt($amount);

        return $this->formatAmount($intAmount, $currency, $locale);
    }

    public function amountToInt(string $amount, $currency = 'EUR')
    {
        // The DecimalMoneyParser uses a point as decimal delimiter.
        // We replace commas by dots then.
        $amount = str_replace(',', '.', $amount);

        $currencies = new ISOCurrencies();
        $moneyParser = new DecimalMoneyParser($currencies);

        return $moneyParser->parse($amount, $currency)->getAmount();
    }

    public function formatAmount(string $amount, $currency = 'EUR', $locale = 'en_US')
    {
        $money = new Money($amount, new Currency($currency));
        $currencies = new ISOCurrencies();
        $numberFormatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);

        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);

        return $moneyFormatter->format($money);
    }
}

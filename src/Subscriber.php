<?php

namespace TypiCMS\Modules\Subscriptions;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use Money\Parser\DecimalMoneyParser;
use NumberFormatter;

class Subscriber
{
    public function planPriceFormat(string $price, float $tax = 0, string $currency = 'EUR', string $locale = 'en_US')
    {
        if ($tax == 0) {
            $tax = auth()->user()->taxPercentage();
        }

        $amount = (((float) $price / 100) * $tax) + (float) $price;
        $intAmount = $this->amountToInt((string) $amount);

        return $this->formatAmount($intAmount, $currency, $locale);
    }

    private function amountToInt(string $amount, string $currency = 'EUR')
    {
        // The DecimalMoneyParser uses a point as decimal delimiter.
        // We replace commas by dots then.
        $amount = str_replace(',', '.', $amount);

        $currencies = new ISOCurrencies();
        $moneyParser = new DecimalMoneyParser($currencies);

        return $moneyParser->parse($amount, $currency)->getAmount();
    }

    private function formatAmount(string $amount, string $currency = 'EUR', string $locale = 'en_US')
    {
        $money = new Money($amount, new Currency($currency));
        $currencies = new ISOCurrencies();
        $numberFormatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);

        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);

        return $moneyFormatter->format($money);
    }
}

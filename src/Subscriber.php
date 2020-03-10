<?php

namespace TypiCMS\Modules\Subscriptions;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Money\Parser\DecimalMoneyParser;

class Subscriber
{
    public function planPriceFormat($price, $tax = 0, $currency = 'EUR')
    {
        if ($tax == 0) {
            $tax = auth()->user()->taxPercentage();
        }

        $amount = ((floatval($price) / 100) * $tax) + $price;
        $intAmount = $this->amountToInt($amount);

        return $this->formatAmount($intAmount, $currency) . ' ' . $currency;
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

    public function formatAmount(string $amount, $currency = 'EUR')
    {
        $money = new Money($amount, new Currency($currency));
        $currencies = new ISOCurrencies();

        $moneyFormatter = new DecimalMoneyFormatter($currencies);

        return $moneyFormatter->format($money);
    }


}

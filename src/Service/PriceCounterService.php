<?php


namespace App\Service;


class PriceCounterService
{
    const VAT = 0.23;


    public function sumInvoiceDetailsNettoPrice($quantity, $nettoPrice){

        return $quantity * $nettoPrice;
    }

    public function sumInvoiceDetailsBruttoPrice($quantity, $nettoPrice){

        $sumNettoPrice = $this->sumInvoiceDetailsNettoPrice($quantity, $nettoPrice);
        $vatValue = $sumNettoPrice * self::VAT;

        return $sumNettoPrice + $vatValue;
    }

}
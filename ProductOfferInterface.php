<?php

namespace App;

interface ProductOfferInterface
{
    /**
     * Calculates the price and remainder from the offer
     *
     * @param $productQuantity int
     * @return $details Array
     */
    public function CalculatePrice(int $productQuantity):Array;

}

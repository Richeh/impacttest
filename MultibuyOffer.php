<?php
namespace App;

class MultibuyOffer implements ProductOfferInterface{

    private $quantity = null;
    private $price = null;

    public function __construct( $quantity, $price ){
        $this->quantity = $quantity;
        $this->price = $price;
    }

    /**
     * Calculate the price and the remaining product to be tallied after applying this offer
     * 
     * @param $productQuantity int
     * @return $details Array
     */    
    public function CalculatePrice( int $productQuantity ):Array
    {
        $remainder = $productQuantity % $this->quantity;
        $price = ($productQuantity - $remainder) / $this->quantity * $this->price;
        //This is clumsy and I hate it.
        $details = Array(
            "price" => $price,
            "remainder" => $remainder
        );
        return $details;
    }

}
<?php 
namespace App;

class Product{
    //The unit price of this product
    public $unitPrice;
    //The product's SKU
    public $sku;
    //An array of all the offers available on this product
    public $offers = Array();

    public function __construct($sku, $price){
        $this->sku = $sku;
        $this->unitPrice = $price;
    }

    /**
     * Add a multibuy offer to the product
     * 
     * @param $quantity int
     * @param $price int
     */    
    public function AddMultibuyOffer( int $quantity, int $price ):void
    {
        $this->offers[] = new MultibuyOffer( $quantity, $price );
    }

    /**
     * Calculate the price of a quantity of this product including offers
     * 
     * @param $quantity int
     * @return $price int
     */        
    public function CalculatePrice( int $quantity ):int
    {
        $price = 0;
        foreach( $this->offers as $offer ){
            $offerResult = $offer->CalculatePrice( $quantity );
            $price += $offerResult[ "price" ];
            $quantity = $offerResult[ "remainder" ];
        }
        $price += $quantity * $this->unitPrice;
        return $price;
    }

}
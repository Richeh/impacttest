<?php

namespace App;

class Checkout implements CheckoutInterface
{
    // An array of scanned products in the current checkout
    private $scannedProducts = Array();
    // An array of available products
    private $productCatalogue = Array();

    public function __construct(){
        $this->RefreshCatalogue();
    }

    /**
     * Populates the products catalogue from the file at the given path
     *
     * @todo Move CSV key to a config file
     * 
     * @param $productCsvPath string
     */
    private function populateProducts(String $productCsvPath):void
    {
        $this->multibuyOffers = Array();
        //Kinda buried here.  It'd be nice to put them in a config.
        $productCsvKey = Array(
            "sku"   => 0,
            "price" => 1
        );

        $productRows = readEntireCsv( $productCsvPath );
        //This would make much more sense connected to a database.  Ah well.

        foreach( $productRows as $productRow ){
            $this->productCatalogue[ $productRow[ $productCsvKey["sku"] ] ] = new Product(
                $productRow[$productCsvKey["sku"]], 
                $productRow[$productCsvKey["price"]]); 
        }           
    }

    /**
     * Populates the multibuy offers in the product catalogue from the CSV at the given path
     *
     * @todo Move CSV key to a config file
     *
     * @param $offerCsvPath string
     */    
    private function populateMultibuyOffers(String $offerCsvPath):void
    {
        $multibuyCsvKey = Array(
            "sku"       => 0,
            "quantity"  => 1,
            "price"     => 2
        );
        
        $offersArray = readEntireCsv( $offerCsvPath );

        foreach( $offersArray as $offerArray ){
            $sku        = $offerArray[ $multibuyCsvKey["sku"] ];
            $quantity   = $offerArray[ $multibuyCsvKey["quantity"] ];
            $price      = $offerArray[ $multibuyCsvKey["price"] ];
            if( array_key_exists( $sku,$this->productCatalogue ) ){
                $this->productCatalogue[ $sku ]->AddMultibuyOffer( $quantity, $price );
            }
        }  
    }

    /**
     * Refreshes the catalogue and offers in memory
     *
     */
    public function RefreshCatalogue():void
    {
        $multibuyOfferCsvPath = "./csvs/multibuyOffers.csv";
        $productsCsvPath = "./csvs/prices.csv";
        $this->populateProducts($productsCsvPath);
        $this->populateMultibuyOffers($multibuyOfferCsvPath);
        //Additional offer types may be implemented and added here.  However they 
        //should be imported in the order in which they should be applied.
    }

    /**
     * Adds an item to the checkout
     *
     */
    public function scan(string $sku):void
    {
        if(!array_key_exists( $sku, $this->scannedProducts )){
            $this->scannedProducts[$sku] = 0;
        }
        $this->scannedProducts[$sku]++;
    }


    /**
     * Calculates the total price of all items in this checkout
     *
     * @return int
     */
    public function total(): int
    {
        $total = 0;
        foreach( $this->scannedProducts as $sku => $quantity ){
            if(array_key_exists( $sku, $this->productCatalogue )){
                $total += $this->productCatalogue[$sku]->CalculatePrice( $quantity );
            }
        }
        return $total;
    }

}

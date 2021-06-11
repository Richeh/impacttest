<?php 
namespace App;
require ("./functions.php");
require ("./CheckoutInterface.php");
require ("./Checkout.php");
require ("./ProductOfferInterface.php");
require ("./MultibuyOffer.php");
require ("./Product.php");

$checkout = new Checkout();
$checkout->scan("A");
$checkout->scan("A");
$checkout->scan("A");
$checkout->scan("D");
echo $checkout->total();
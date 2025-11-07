<?php

require 'src/products.php';
require 'src/delivery-charge.php';
require 'src/Basket.php';
require 'src/offers.php';

$basket = new Basket($products, $deliveryCharge, $offers);

$basket->add('R01');
$basket->add('R01');
$basket->add('R01');
$basket->add('B01');
$basket->add('B01');

echo "Total spending: $". $basket->total();

?>
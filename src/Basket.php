<?php 

class Basket{
    private $products;
    private $deliveryCharge;
    private $offers;
    private $items = [];

    public function __construct($products, $deliveryCharge, $offers = null){
        $this->products = $products;
        $this->deliveryCharge = $deliveryCharge;
        $this->offers = $offers;
    }

    public function add($productCode){
        if(!isset($this->products[$productCode])){
            throw new Exception ('Product code '.$productCode.' not found');
        }
        $this->items[] = $productCode;
    }

    public function calculateSubtotal(){
        $total = 0;
        foreach($this->items as $item){
            $total += $this->products[$item]['price'];
        }

        return $total;
    }

    public function calculateOffers(){
        $discount = 0;

        if ($this->offers && $this->offers['R01']) { 
            $itemCounts = array_count_values($this->items);
            $count = $itemCounts['R01'] ?? 0;
            $pairs = floor($count / 2);
            $discount = $pairs * ($this->products['R01']['price'] / 2); 
        } 
        return $discount;
    }

    public function calculateDelivery($price){
        $delivery = 0;
        foreach($this->deliveryCharge as $item){
            if($price >= $item['min'] && $price < $item['max']){
                $delivery = $item['charge'];
            }
        }
        return $delivery;
    }

    public function total(){
        $subTotal = $this->calculateSubtotal();
        $discount = $this->calculateOffers();
        $delivery = $this->calculateDelivery($subTotal - $discount);

        return round($subTotal - $discount + $delivery, 2);
    }
}

?>
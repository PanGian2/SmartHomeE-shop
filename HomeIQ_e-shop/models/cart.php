<?php
class Cart
{
    public $items;
    public $totalQty;
    public $totalPrice;

    public function __construct($oldCart)
    {
        // $decoded = unserialize($oldCart)
        $this->items = isset($oldCart['items']) ? unserialize($oldCart->items) : [];
        $this->totalQty = isset($oldCart['totalQty']) ? unserialize($oldCart->totalQty) : 0;
        $this->totalPrice = isset($oldCart['totalPrice']) ? unserialize($oldCart->totalPrice) : 0;
    }

    public function add($id, $price, $qty, $img, $name, $requiresInstallation, $availability)
    {
        //if id doesn't exist in the items arrays add it
        if (!array_key_exists($id, $this->items)) {
            $this->items[$id] = array(
                "id" => $id,
                "img" => $img,
                "name" => $name,
                "qty" => 0,
                "price" => $price,
                "totalPrice" => 0,
                "requiresInstallation" => $requiresInstallation,
                "availability" => $availability
            );
        }
        //update the quantity and total price of the item
        $this->items[$id]['qty'] += $qty;
        $this->items[$id]['totalPrice'] = $price *  $this->items[$id]['qty'];

        //update the total quantity and price of the cart
        $this->totalQty += $qty;
        $this->totalPrice += $this->items[$id]['totalPrice'];
    }

    public function updateQty($id, $qty, $price)
    {
        //remove the previous quantity and price from the item
        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['totalPrice'];
        //get the new quantity and total price of item
        $this->items[$id]['qty'] = $qty;
        $this->items[$id]['totalPrice'] = $price *  $this->items[$id]['qty'];
        //update the total quantity and price of the cart
        $this->totalQty += $qty;
        $this->totalPrice += $this->items[$id]['totalPrice'];
    }

    public function removeProduct($id)
    {
        //update the total quantity and price of the cart
        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['totalPrice'];
        //remove the entry of the item
        unset($this->items[$id]);
    }

    public function generateArray()
    {
        //convert items to array
        $arr = [];
        foreach ($this->items as $id => $item) {
            $arr[] = $item;
        }
        return $arr;
    }
}

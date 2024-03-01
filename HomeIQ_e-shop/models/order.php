<?php
$vendorPath = "";
$currentFile = $_SERVER['PHP_SELF'];
$currentDir = dirname($currentFile);
$vendorPath .= str_repeat('../', substr_count($currentDir, '/')) . 'HomeIQ_e-shop/vendor/';
require($vendorPath . 'autoload.php');

use MongoDB\BSON\ObjectId;

class Order
{
    private $db;
    private $user;
    private $cart;
    private $status;
    private $dateTimeOrdered;
    private $deliveryDate;


    public function __construct()
    {
        $m = new \MongoDB\Client("mongodb://localhost:27000/");
        $this->db = $m->homeIQdb->Orders;
    }

    public function getOrders()
    {
        $result = $this->db->find();
        return $result;
    }

    public function getOrderById($id)
    {
        $_id = new ObjectId($id);
        $result = $this->db->findOne(array(
            "_id" => $_id
        ));
        return $result;
    }

    public function getOrdersByUserId($id)
    {
        $result = $this->db->find(array(
            "user.userId" => (string)$id
        ));
        return $result->toArray();
    }

    public function userHasBoughtProduct($userid, $productId)
    {
        $result = $this->db->findOne(array(
            '$and' => array(
                array(
                    "user.userId" => (string)$userid
                ),
                array(
                    'cart.items.' . $productId => array(
                        '$exists' => true
                    )
                )
            )
        ));
        return $result;
    }

    public function addOrder($document)
    {
        $result = $this->db->insertOne($document);
        return $result->getInsertedId();
    }

    public function updateOrder($id, $fields)
    {
        $_id = new ObjectId($id);
        $result = $this->db->updateOne(
            [
                "_id" => $_id
            ],
            $fields
        );
        return $result->getMatchedCount();
    }
}

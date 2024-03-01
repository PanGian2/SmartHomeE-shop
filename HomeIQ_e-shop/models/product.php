<?php
$vendorPath = "";
$currentFile = $_SERVER['PHP_SELF'];
$currentDir = dirname($currentFile);
$vendorPath .= str_repeat('../', substr_count($currentDir, '/')) . 'HomeIQ_e-shop/vendor/';
require($vendorPath . 'autoload.php');

use MongoDB\BSON\ObjectId;

class Product
{
    private $db;
    private $name;
    private $description;
    private $price;
    private $availability;
    private $color;
    private $img;
    private $video;
    private $ports;
    private $type;
    private $category;
    private $hasApp;
    private $compatibility;
    private $requiresInstallation;
    private $reviews;


    public function __construct()
    {
        $m = new \MongoDB\Client("mongodb://localhost:27000/");
        $this->db = $m->homeIQdb->Products;
    }

    public function getProducts()
    {
        $result = $this->db->find();
        return $result->toArray();
    }

    public function getProductCategories()
    {
        $result = $this->db->aggregate([
            [
                '$group' => [
                    '_id' => '$category'
                ]
            ]
        ]);
        return $result->toArray();
    }

    public function getProductFilters()
    {
        $categories = $this->db->aggregate([
            ['$group' => ['_id' => '$category']],
            ['$project' => ['_id' => 0, 'category' => '$_id']]
        ])->toArray();
        $subcategories = $this->db->aggregate([
            ['$group' => ['_id' => '$subcategory']],
            ['$project' => ['_id' => 0, 'subcategory' => '$_id']]
        ])->toArray();
        $names = $this->db->aggregate([
            ['$group' => ['_id' => '$name']],
            ['$project' => ['_id' => 0, 'name' => '$_id']]
        ])->toArray();
        $manufacturers = $this->db->aggregate([
            ['$group' => ['_id' => '$manufacturer']],
            ['$project' => ['_id' => 0, 'manufacturer' => '$_id']]
        ])->toArray();
        $result = array_merge($categories, $subcategories, $names, $manufacturers);
        return $result;
    }

    public function getProductSubcategories($category)
    {
        $result = $this->db->aggregate([
            [
                '$match' => [
                    'category' => $category
                ]
            ],
            [
                '$group' => [
                    '_id' => '$subcategory',
                    'products' => ['$first' => '$$ROOT']
                ]
            ]
        ]);
        return $result->toArray();
    }

    public function getProductById($id)
    {
        $_id = new ObjectId($id);
        $result = $this->db->findOne(array(
            "_id" => $_id
        ));
        return $result;
    }

    public function getProductsBySubcategory($subcategory)
    {
        $result = $this->db->find(array(
            "subcategory" => $subcategory
        ));
        return $result->toArray();
    }

    public function getProductsByCategory($category)
    {
        $result = $this->db->find(array(
            "category" => $category
        ));
        return $result->toArray();
    }

    public function getProductsByName($name)
    {
        $result = $this->db->find(array(
            "name" => $name
        ));
        return $result->toArray();
    }

    public function getProductsByManufacturer($manufacturer)
    {
        $result = $this->db->find(array(
            "manufacturer" => $manufacturer
        ));
        return $result->toArray();
    }

    public function getProductsAvgRating($id)
    {
        $_id = new ObjectId($id);
        $query = [
            [
                '$match' => ['_id' => $_id]
            ],
            [
                '$lookup' => [
                    'from' => 'Reviews',
                    'localField' => 'reviews',
                    'foreignField' => '_id',
                    'as' => 'review'
                ]
            ],
            [
                '$unwind' => '$review'
            ],
            [
                '$group' => [
                    '_id' => '$_id',
                    'averageRating' => ['$avg' => '$review.rating']
                ]
            ],
            [
                '$project' => [
                    '_id' => 1,
                    'averageRating' => ['$round' => ['$averageRating', 2]] // Περιορισμός σε 2 δεκαδικά ψηφία
                ]
            ]
        ];
        $result = $this->db->aggregate($query);
        return $result->toArray();
    }


    public function addProduct($document)
    {
        $result = $this->db->insertOne($document);
        return $result->getInsertedId();
    }

    public function updateProduct($id, $fields)
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

    public function deleteProduct($id)
    {
        $_id = new ObjectId($id);
        $result = $this->db->deleteOne(
            [
                "_id" => $_id
            ]
        );
        return $result->getDeletedCount();
    }
}

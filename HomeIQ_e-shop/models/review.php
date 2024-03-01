<?php
$vendorPath = "";
$currentFile = $_SERVER['PHP_SELF'];
$currentDir = dirname($currentFile);
$vendorPath .= str_repeat('../', substr_count($currentDir, '/')) . 'HomeIQ_e-shop/vendor/';
require($vendorPath . 'autoload.php');

use MongoDB\BSON\ObjectId;

class Review
{
    private $db;
    private $body;
    private $rating;
    private $author;


    public function __construct()
    {
        $m = new \MongoDB\Client("mongodb://localhost:27000/");
        $this->db = $m->homeIQdb->Reviews;
    }

    public function getReviews()
    {
        $result = $this->db->find();
        return $result;
    }

    public function getReviewsById($id)
    {
        $_id = new ObjectId($id);
        $query = [
            [
                '$match' => [
                    '_id' => $_id
                ]
            ],
            [
                '$lookup' => [
                    'from' => 'Users',
                    'localField' => 'author',
                    'foreignField' => '_id',
                    'as' => 'user'
                ]
            ],
            [
                '$unwind' => '$user' // Ξεδιπλώνει τα στοιχεία του χρήστη
            ]
        ];
        $result = $this->db->aggregate($query);
        return $result->toArray();
    }

    public function addReview($document)
    {
        $result = $this->db->insertOne($document);
        return $result->getInsertedId();
    }

    public function deleteReview($id)
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

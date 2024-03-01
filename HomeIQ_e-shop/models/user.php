<?php
$vendorPath = "";
$currentFile = $_SERVER['PHP_SELF'];
$currentDir = dirname($currentFile);
$vendorPath .= str_repeat('../', substr_count($currentDir, '/')) . 'HomeIQ_e-shop/vendor/';
require($vendorPath . 'autoload.php');

use MongoDB\BSON\ObjectId;

use function MongoDB\BSON\toJSON;

enum Role: int
{
    case user = 1;
    case admin = 2;
}

class User
{
    private $db;
    private string $password;
    private string $email;
    private string $city;
    private string $address;
    private int $postalCode;
    private array $favorites;
    private Role $role;
    private bool $inNewsletter;


    public function __construct()
    {
        $m = new \MongoDB\Client("mongodb://localhost:27000/");
        $this->db = $m->homeIQdb->Users;
    }

    public function getUsers()
    {
        $result = $this->db->find();
        return $result;
    }

    public function getUserById($id)
    {
        $_id = new ObjectId($id);
        $result = $this->db->findOne(array(
            "_id" => $_id
        ));
        return $result;
    }

    public function getUserByEmail($email)
    {
        $result = $this->db->find(array(
            "email" => $email
        ));
        return $result;
    }

    public function authUser($email, $password)
    {
        $result = $this->db->findOne(array(
            "email" => $email,
        ));
        if ($result == null) {
            return false;
        }
        if (password_verify($password, $result["password"])) {
            return $result;
        } else {
            return false;
        }
    }

    public function addUser($document)
    {
        $result = $this->db->insertOne($document);
        return $result->getInsertedId();
    }

    public function updateUser($id, $fields)
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

    public function updateUserLoginHours($id, $login, $logout, $duration)
    {
        $_id = new ObjectId($id);
        $result = $this->db->updateOne(
            [
                '$and' => [
                    ["_id" => $_id],
                    ['loginHistory.loginTime' => $login],
                ],

            ],
            [
                '$set' => [
                    'loginHistory.$.logoutTime' => $logout,
                    'loginHistory.$.duration' => (int)$duration
                ]
            ]
        );
        return $result->getMatchedCount();
    }

    public function deleteUser($id)
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

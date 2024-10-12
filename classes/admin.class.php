<?php
require_once __DIR__ . '/../db.php';


class Admin
{
    public $id;
    public $role = 'Customer';
    public $firstname;
    public $lastname;
    public $birthdate;
    public $sex;
    public $phone;
    public $address;
    public $email;
    public $password;
    public $cpassword;

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    public function getAdmin()
    {
        $sql = "SELECT * FROM customer WHERE role = 'Admin' LIMIT 1;";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Use fetch() instead of fetchAll()

        return $result; // Return a single associative array
    }


    public function getAllCustomers()
    {
        $sql = "SELECT *  FROM customer WHERE role = 'Customer';";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }





}
$adminObj = new Admin();

// var_dump($adminObj->getAllCustomers());
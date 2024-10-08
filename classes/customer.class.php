<?php
require_once 'db.php';

class Customer
{
    public $id;
    public $firstname;
    public $lastname;
    public $birthdate;
    public $sex;
    public $phone;
    public $address;
    public $email;
    public $password;

    public $cpasssword;

    private $db;

    function __construct()
    {
        $this->db = new Database();
    }

    function create()
    {
        $sql = "SELECT * FROM customers WHERE email = :email;";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':email', $this->email);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                return false;
            } else {

                if ($this->password != $this->cpasssword) {
                    return false;
                }
                $sql = "INSERT INTO customers (firstname, lastname, birthdate, sex, phone, address, email, password) VALUES (:firstname, :lastname, :birthdate, :sex, :phone, :address, :email, :password);";

                $stmt = $this->db->connect()->prepare($sql);
                $stmt->bindParam(':firstname', $this->firstname);
                $stmt->bindParam(':lastname', $this->lastname);
                $stmt->bindParam(':birthdate', $this->birthdate);
                $stmt->bindParam(':sex', $this->sex);
                $stmt->bindParam(':phone', $this->phone);
                $stmt->bindParam(':address', $this->address);
                $stmt->bindParam(':email', $this->email);

                $hash = password_hash($this->password, PASSWORD_DEFAULT);
                $stmt->bindParam(':password', $hash);

                return $stmt->execute();
            }
        }
    }
}
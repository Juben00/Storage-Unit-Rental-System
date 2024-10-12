<?php
require_once __DIR__ . '/../db.php';


class Admin
{
    public $id;
    public $status = 'In-Stock';
    public $description;
    public $name;
    public $category;
    public $price;
    public $image;
    public $stock;

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

    public function addStorage()
    {
        $sql = "INSERT INTO storage (name, category, description, stock, price, status, image) VALUES (:name, :category, :description, :stock, :price, :status, :image);";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':stock', $this->stock);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':image', $this->image);

        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'Storage added successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Failed to add storage'];
        }
    }





}
$adminObj = new Admin();

// var_dump($adminObj->getAllCustomers());
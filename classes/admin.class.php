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

    public function updateStorage()
    {
        // Start the SQL query
        $sql = "UPDATE storage SET name = :name, category = :category, description = :description, stock = :stock, price = :price";

        // If a new image is provided, add it to the query
        if ($this->image) {
            $sql .= ", image = :image";
        }

        $sql .= " WHERE id = :id";

        // Prepare and bind the SQL statement
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':stock', $this->stock);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':id', $this->id);

        // If an image is provided, bind the image parameter
        if ($this->image) {
            $stmt->bindParam(':image', $this->image);
        }

        // Execute the statement and return the result
        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'Storage updated successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Failed to update storage'];
        }
    }


    public function getAllStorage()
    {
        $sql = "SELECT * FROM storage;";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function deleteStorage($id)
    {
        $sql = "DELETE FROM storage WHERE id = :id;";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'Storage deleted successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Failed to delete storage'];
        }
    }

    public function logout()
    {
        session_destroy();
        return ['status' => 'success', 'message' => 'Logged Out successfully!'];
    }





}
$adminObj = new Admin();

// var_dump($adminObj->deleteStorage(3));
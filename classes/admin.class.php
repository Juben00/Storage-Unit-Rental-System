<?php
require_once __DIR__ . '/../db.php';


class Admin
{
    public $id;
    public $status = '1';
    public $description;
    public $name;
    public $category;
    public $price;
    public $image;
    public $stock;
    public $area;

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    public function getAdmin($email)
    {
        $sql = "SELECT c.*, r.role_name FROM customer c JOIN roles r ON c.role_id = r.id WHERE r.role_name = 'Admin' AND c.email = :email LIMIT 1;";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Use fetch() instead of fetchAll()

        return $result; // Return a single associative array
    }
    public function getAllCustomers()
    {
        $sql = "SELECT c.* FROM customer c JOIN roles r ON c.role_id = r.id WHERE r.role_name = 'Customer';";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function deleteCustomer($id)
    {
        $sql = "DELETE FROM customer WHERE id = :id;";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'Customer deleted successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Failed to delete customer'];
        }
    }

    public function addStorage()
    {
        $sql = "INSERT INTO storage (name, category_id, description, area, stock, price, status_id, image) 
            VALUES (:name, :category_id, :description, :area, :stock, :price, :status_id, :image);";
        $stmt = $this->db->connect()->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':category_id', $this->category); // Ensure this is the ID from the category table
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':area', $this->area); // Ensure you have an area variable to bind
        $stmt->bindParam(':stock', $this->stock);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':status_id', $this->status); // Ensure this is the ID from the status table
        $stmt->bindParam(':image', $this->image);

        // Execute and return status
        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'Storage added successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Failed to add storage'];
        }
    }

    public function updateStorage()
    {
        $sql = "UPDATE storage SET name = :name, category_id = :category_id, price = :price, description = :description, area = :area, image = :image, stock = :stock WHERE id = :id";

        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':category_id', $this->category); // Ensure this holds the category ID
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':area', $this->area);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':stock', $this->stock);

        return $stmt->execute() ?
            ['status' => 'success', 'message' => 'Storage updated successfully'] :
            ['status' => 'error', 'message' => 'Update failed'];
    }

    public function getAllStorage()
    {
        $sql = "SELECT s.*, c.name AS category_name, st.status_name 
            FROM storage s 
            JOIN category c ON s.category_id = c.id 
            JOIN status st ON s.status_id = st.id;";

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

// var_dump($adminObj->getAllStorage());
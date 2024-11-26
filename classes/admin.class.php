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
        $sql = "INSERT INTO storage (name, category_id, description, area, price, status_id, image) 
            VALUES (:name, :category_id, :description, :area, :price, :status_id, :image);";
        $stmt = $this->db->connect()->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':category_id', $this->category); // Ensure this is the ID from the category table
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':area', $this->area); // Ensure you have an area variable to bind
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
        $sql = "UPDATE storage SET name = :name, category_id = :category_id, price = :price, description = :description, area = :area, image = :image WHERE id = :id";

        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':category_id', $this->category); // Ensure this holds the category ID
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':area', $this->area);
        $stmt->bindParam(':image', $this->image);

        return $stmt->execute() ?
            ['status' => 'success', 'message' => 'Storage updated successfully'] :
            ['status' => 'error', 'message' => 'Update failed'];
    }

    public function getAllStorage()
    {
        $sql = "SELECT s.*, c.name AS category_name, st.status_name 
            FROM storage s 
            JOIN category c ON s.category_id = c.id 
            JOIN status st ON s.status_id = st.id;"; // Include all storage items

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

    public function getPendingBooking()
    {
        $sql = "SELECT 
        c.firstname, 
        c.lastname, 
        c.email, 
        c.phone, 
        b.id AS booking_id,
        b.booking_date, 
        b.months AS 'months',
        b.start_date, 
        b.end_date, 
        b.total_amount, 
        s.name AS storage_name, 
        s.area, 
        s.price, 
        bs.status_name AS booking_status, 
        p.payment_method, 
        p.payment_date, 
        ps.status_name AS payment_status
    FROM booking b
    JOIN customer c ON b.customer_id = c.id
    JOIN storage s ON b.storage_id = s.id
    JOIN booking_status bs ON b.booking_status_id = bs.id
    LEFT JOIN payment p ON b.id = p.booking_id
    LEFT JOIN payment_status ps ON p.payment_status_id = ps.id
    WHERE bs.status_name = :status";

        $stmt = $this->db->connect()->prepare($sql);

        // Set the status value to 'Pending'
        $PENDING = 'Pending';

        // Bind the status parameter
        $stmt->bindParam(':status', $PENDING);
        $stmt->execute();

        // Fetch all results as an associative array
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function approvePendingBook($id)
    {
        try {
            // Begin a transaction
            $conn = $this->db->connect();
            $conn->beginTransaction();

            // Update booking status
            $updateBookingSql = "UPDATE booking SET booking_status_id = 2 WHERE id = :id";
            $stmt = $conn->prepare($updateBookingSql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // Update payment status
            $updatePaymentSql = "UPDATE payment SET payment_status_id = 2 WHERE booking_id = :id";
            $stmt = $conn->prepare($updatePaymentSql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // Commit the transaction
            $conn->commit();

            return [
                'status' => 'success',
                'message' => 'Booking and payment statuses updated successfully'
            ];
        } catch (Exception $e) {
            // Rollback the transaction in case of an error
            $conn->rollBack();
            error_log("Error approving booking: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }


    public function getApprovedBooking()
    {
        $sql = "SELECT 
        c.firstname, 
        c.lastname, 
        c.email, 
        c.phone, 
        b.id AS booking_id,
        b.booking_date, 
        b.months AS 'months',
        b.start_date, 
        b.end_date, 
        b.total_amount, 
        s.name AS storage_name, 
        s.area, 
        s.price, 
        bs.status_name AS booking_status, 
        p.payment_method, 
        p.payment_date, 
        ps.status_name AS payment_status
    FROM booking b
    JOIN customer c ON b.customer_id = c.id
    JOIN storage s ON b.storage_id = s.id
    JOIN booking_status bs ON b.booking_status_id = bs.id
    LEFT JOIN payment p ON b.id = p.booking_id
    LEFT JOIN payment_status ps ON p.payment_status_id = ps.id
    WHERE bs.status_name = :status";

        $stmt = $this->db->connect()->prepare($sql);

        // Set the status value to 'Approved'
        $APPROVED = 'Confirmed';

        // Bind the status parameter
        $stmt->bindParam(':status', $APPROVED);
        $stmt->execute();

        // Fetch all results as an associative array
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getClosedBooking()
    {
        $sql = "SELECT 
        c.firstname, 
        c.lastname, 
        c.email, 
        c.phone, 
        b.id AS booking_id,
        b.booking_date, 
        b.months AS 'months',
        b.start_date, 
        b.end_date, 
        b.total_amount, 
        s.name AS storage_name, 
        s.area, 
        s.price, 
        bs.status_name AS booking_status, 
        p.payment_method, 
        p.payment_date, 
        ps.status_name AS payment_status
    FROM booking b
    JOIN customer c ON b.customer_id = c.id
    JOIN storage s ON b.storage_id = s.id
    JOIN booking_status bs ON b.booking_status_id = bs.id
    LEFT JOIN payment p ON b.id = p.booking_id
    LEFT JOIN payment_status ps ON p.payment_status_id = ps.id
    WHERE bs.status_name = :status";

        $stmt = $this->db->connect()->prepare($sql);

        // Set the status value to 'Closed'
        $CLOSED = 'Closed';

        // Bind the status parameter
        $stmt->bindParam(':status', $CLOSED);
        $stmt->execute();

        // Fetch all results as an associative array
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getCustomerBookingCount()
    {
        $sql = "SELECT s.name AS storage_name, COUNT(b.id) AS booking_count
                FROM booking b
                JOIN storage s ON b.storage_id = s.id
                GROUP BY s.name";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMonthlyEarnings()
    {
        $sql = "SELECT s.id AS storage_id, s.name AS storage_name, MONTH(b.booking_date) AS month, SUM(b.total_amount) AS total_earnings
                FROM booking b
                JOIN storage s ON b.storage_id = s.id
                GROUP BY s.name, MONTH(b.booking_date)";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStorageRentDetails($storageId)
    {
        $sql = "SELECT c.firstname, c.lastname, b.start_date, b.end_date
                FROM booking b
                JOIN customer c ON b.customer_id = c.id
                WHERE b.storage_id = :storage_id";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':storage_id', $storageId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSalesData()
    {
        $sql = "SELECT MONTH(booking_date) AS month, SUM(total_amount) AS total
                FROM booking
                GROUP BY MONTH(booking_date)";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $labels = [];
        $current = [];

        foreach ($result as $row) {
            $labels[] = date('F', mktime(0, 0, 0, $row['month'], 10));
            $current[] = $row['total'];
        }

        return ['labels' => $labels, 'current' => $current];
    }

    public function getInventoryData()
    {
        $sql = "SELECT status_name, COUNT(*) AS count
                FROM storage
                JOIN status ON storage.status_id = status.id
                GROUP BY status_name";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $labels = [];
        $data = [];

        foreach ($result as $row) {
            $labels[] = $row['status_name'];
            $data[] = $row['count'];
        }

        return ['labels' => $labels, 'data' => $data];
    }

    public function logout()
    {
        session_destroy();
        return ['status' => 'success', 'message' => 'Logged Out successfully!'];
    }

    public function disableStorage($id)
    {
        $sql = "UPDATE storage SET status_id = 2 WHERE id = :id"; // Assuming '2' is the ID for 'Disabled' status
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'Storage disabled successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Failed to disable storage'];
        }
    }

    public function enableStorage($id)
    {
        $sql = "UPDATE storage SET status_id = 1 WHERE id = :id"; // Assuming '1' is the ID for 'Enabled' status
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'Storage enabled successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Failed to enable storage'];
        }
    }

    public function restrictUser($id)
    {
        $sql = "UPDATE customer SET status = 'Restricted' WHERE id = :id";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':id', $id);

        return $stmt->execute() ?
            ['status' => 'success', 'message' => 'User restricted successfully'] :
            ['status' => 'error', 'message' => 'Failed to restrict user'];
    }

    public function unrestrictUser($id)
    {
        $sql = "UPDATE customer SET status = 'Active' WHERE id = :id";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':id', $id);

        return $stmt->execute() ?
            ['status' => 'success', 'message' => 'User unrestricted successfully'] :
            ['status' => 'error', 'message' => 'Failed to unrestrict user'];
    }

}
$adminObj = new Admin();

// var_dump($adminObj->getPendingBooking());
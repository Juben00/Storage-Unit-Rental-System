<?php
require_once __DIR__ . '/../db.php';


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
    public $cpassword; // Corrected the typo from cpasssword to cpassword

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }


    public function signup()
    {
        try {
            // Check if passwords match
            if ($this->password !== $this->cpassword) {
                return ['status' => 'error', 'message' => 'Passwords do not match'];
            }

            // Check if email already exists
            $sql = "SELECT * FROM customer WHERE email = :email;";
            $stmt = $this->db->connect()->prepare($sql);
            $stmt->bindParam(':email', $this->email);

            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    return ['status' => 'error', 'message' => 'Email already exists'];
                }

                // Prepare to insert new customer
                $sql = "INSERT INTO customer (firstname, lastname, birthdate, sex, phone, address, email, password) 
                    VALUES (:firstname, :lastname, :birthdate, :sex, :phone, :address, :email, :password);";

                $stmt = $this->db->connect()->prepare($sql);
                $stmt->bindParam(':firstname', $this->firstname);
                $stmt->bindParam(':lastname', $this->lastname);
                $stmt->bindParam(':birthdate', $this->birthdate);
                $stmt->bindParam(':sex', $this->sex);
                $stmt->bindParam(':phone', $this->phone);
                $stmt->bindParam(':address', $this->address);
                $stmt->bindParam(':email', $this->email);

                // Hash the password before storing it
                $hash = password_hash($this->password, PASSWORD_DEFAULT);
                $stmt->bindParam(':password', $hash);

                // Try executing the insert statement
                if ($stmt->execute()) {
                    return ['status' => 'success', 'message' => 'Signup successful'];
                } else {
                    // Log the error for debugging
                    error_log("Insert error: " . implode(", ", $stmt->errorInfo()));
                    return ['status' => 'error', 'message' => 'Signup failed due to an internal error'];
                }
            }
        } catch (PDOException $e) {
            // Log the error and return a failure message
            error_log("PDOException: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function login()
    {
        try {
            session_start(); // Make sure session is started

            $sql = "SELECT * FROM customer WHERE email = :email;";
            $stmt = $this->db->connect()->prepare($sql);
            $stmt->bindParam(':email', $this->email);

            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    // Verify the password
                    if (password_verify($this->password, $row['password'])) {
                        session_regenerate_id(true); // Prevent session fixation attacks
                        $_SESSION['customer'] = $row; // Store user info in session
                        return ['status' => 'success', 'message' => 'Logged In successfully!'];
                    } else {
                        return ['status' => 'error', 'message' => 'Invalid Password'];
                    }
                } else {
                    return ['status' => 'error', 'message' => 'Account Doesn\'t Exist'];
                }
            } else {
                // Log the error for debugging
                error_log("Login SQL Error: " . implode(", ", $stmt->errorInfo()));
                return ['status' => 'error', 'message' => 'Database error'];
            }
        } catch (PDOException $e) {
            error_log("PDOException: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function logout()
    {
        session_destroy();
        return ['status' => 'success', 'message' => 'Logged Out successfully!'];
    }
}

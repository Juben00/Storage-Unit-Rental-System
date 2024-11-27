<?php
require_once __DIR__ . '/../db.php';


class Customer
{
    public $id;
    public $role = 2;
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

                $sql = "INSERT INTO customer (role_id, firstname, lastname, birthdate, sex, phone, address, email, password) 
                    VALUES (:role_id, :firstname, :lastname, :birthdate, :sex, :phone, :address, :email, :password);";

                $stmt = $this->db->connect()->prepare($sql);
                $stmt->bindParam(':role_id', $this->role);
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
                    return ['status' => 'success', 'message' => 'Signup successful!'];
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

            $sql = "SELECT c.*, r.role_name FROM customer c JOIN roles r ON c.role_id = r.id WHERE email = :email;";
            $stmt = $this->db->connect()->prepare($sql);
            $stmt->bindParam(':email', $this->email);

            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    // Check if the user is restricted
                    if ($row['status'] === 'Restricted') {
                        return ['status' => 'error', 'message' => 'Your account is restricted. Please contact support.'];
                    }
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

    public function getAllStorage($category = "")
    {
        $sql = "SELECT s.*, c.name AS category_name, st.status_name AS status
            FROM storage s 
            JOIN category c ON s.category_id = c.id 
            JOIN status st ON s.status_id = st.id 
            WHERE st.status_name != 'Disabled' AND (c.id LIKE CONCAT('%', :cat, '%'));";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':cat', $category);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getSingleStorage($id)
    {
        $sql = "SELECT s.*, c.name AS category_name, st.status_name 
            FROM storage s 
            JOIN category c ON s.category_id = c.id 
            JOIN status st ON s.status_id = st.id
            WHERE s.id = :id
            ;";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUserInfo($userId)
    {
        $sql = "SELECT c.*, r.role_name FROM customer c JOIN roles r ON c.role_id = r.id WHERE c.id = :id;";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam("id", $userId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function bookmarkStorage($userId, $storageId)
    {
        $sql = "INSERT INTO bookmark (customer_id, storage_id) VALUES (:customer_id, :storage_id);";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':customer_id', $userId);
        $stmt->bindParam(':storage_id', $storageId);
        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'Storage bookmarked successfully!'];
        } else {
            return ['status' => 'error', 'message' => 'Bookmark failed'];
        }
    }

    public function unbookmarkStorage($userId, $storageId)
    {
        $sql = "DELETE FROM bookmark WHERE customer_id = :customer_id AND storage_id = :storage_id;";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':customer_id', $userId);
        $stmt->bindParam(':storage_id', $storageId);
        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'Storage unbookmarked successfully!'];
        } else {
            return ['status' => 'error', 'message' => 'Unbookmark failed'];
        }
    }

    public function getBookmarkedStorage()
    {
        $sql = "SELECT s.id as id, s.*, c.name AS category_name, st.status_name 
            FROM storage s 
            JOIN category c ON s.category_id = c.id 
            JOIN status st ON s.status_id = st.id
            JOIN bookmark b ON s.id = b.storage_id
            WHERE b.customer_id = :customer_id
            ;";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':customer_id', $_SESSION['customer']['id']);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function bookStorage($customerId, $storageId, $months, $startDate, $endDate, $totalAmount, $accountNumber, $paymentMethod)
    {
        // Start the transaction
        $this->db->connect()->beginTransaction();

        try {
            // SQL for booking
            $sqlBooking = "INSERT INTO booking (customer_id, storage_id, months, start_date, end_date, total_amount, booking_status_id) 
                       VALUES (:customer_id, :storage_id, :months, :start_date, :end_date, :total_amount, :booking_status_id);";

            $stmtBooking = $this->db->connect()->prepare($sqlBooking);
            $stmtBooking->bindParam(':customer_id', $customerId);
            $stmtBooking->bindParam(':storage_id', $storageId);
            $stmtBooking->bindParam(':months', $months);
            $stmtBooking->bindParam(':start_date', $startDate);
            $stmtBooking->bindParam(':end_date', $endDate);
            $stmtBooking->bindParam(':total_amount', $totalAmount);

            // Assuming '1' is the ID for 'Pending' status in the booking_status table
            $bookingStatusId = 1;
            $stmtBooking->bindParam(':booking_status_id', $bookingStatusId);

            // Execute the booking query
            if (!$stmtBooking->execute()) {
                throw new Exception('Storage booking failed');
            }

            // Get the last inserted booking ID
            $bookingId = $this->db->connect()->lastInsertId();

            // SQL for payment
            $sqlPayment = "INSERT INTO payment (booking_id, account_number, payment_method, payment_status_id) 
                       VALUES (:booking_id, :account_number, :payment_method, :payment_status_id);";

            $stmtPayment = $this->db->connect()->prepare($sqlPayment);
            $stmtPayment->bindParam(':booking_id', $bookingId);
            $stmtPayment->bindParam(':account_number', $accountNumber);
            $stmtPayment->bindParam(':payment_method', $paymentMethod);

            // Assuming '1' is the ID for 'Pending' status in the payment_status table
            $paymentStatusId = 1;
            $stmtPayment->bindParam(':payment_status_id', $paymentStatusId);

            // Execute the payment query
            if (!$stmtPayment->execute()) {
                throw new Exception('Payment recording failed');
            }

            // If both queries succeed, commit the transaction
            $this->db->connect()->commit();

            return ['status' => 'success', 'message' => 'Storage booked and payment recorded successfully!'];

        } catch (Exception $e) {
            // Rollback the transaction if an error occurs
            $this->db->connect()->rollBack();

            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }


    public function getBookings($customerId)
    {
        $sql = "SELECT 
        b.id AS booking_id,
        b.booking_date, 
        b.months AS 'months',
        b.start_date, 
        b.end_date, 
        b.total_amount, 
        s.image,
        s.name AS storage_name, 
        s.area, 
        s.price, 
        bs.status_name AS booking_status, 
        p.payment_method, 
        p.payment_date, 
        ps.status_name AS payment_status
    FROM booking b
    JOIN storage s ON b.storage_id = s.id
    JOIN booking_status bs ON b.booking_status_id = bs.id
    JOIN payment p ON b.id = p.booking_id
    JOIN payment_status ps ON p.payment_status_id = ps.id
    WHERE b.customer_id = :customer_id
    ORDER BY b.id DESC;";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':customer_id', $customerId);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    public function getBookedDates($StorageID)
    {
        $sql = "SELECT start_date, end_date FROM booking WHERE storage_id = :storage_id;";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':storage_id', $StorageID);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getBookingDetails($bookingId)
    {
        $sql = "SELECT 
                    b.*, 
                    bs.status_name AS booking_status, 
                    p.payment_method, 
                    p.payment_status_id, 
                    ps.status_name AS payment_status 
                FROM booking b
                JOIN booking_status bs ON b.booking_status_id = bs.id
                JOIN payment p ON b.id = p.booking_id
                JOIN payment_status ps ON p.payment_status_id = ps.id
                WHERE b.id = :booking_id;";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':booking_id', $bookingId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getStorageDetails($storageId)
    {
        $sql = "SELECT 
                    s.*, 
                    s.id AS sid,
                    c.name AS category_name, 
                    st.status_name 
                FROM storage s
                JOIN category c ON s.category_id = c.id
                JOIN status st ON s.status_id = st.id
                WHERE s.id = :storage_id;";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':storage_id', $storageId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveReview($storageId, $userId, $rating, $review)
    {
        $sql = "INSERT INTO reviews (storage_id, userId, rating, review) VALUES (:storage_id, :userId, :rating, :review)";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':storage_id', $storageId);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':review', $review);
        return $stmt->execute();
    }

    public function getAvailableDates($storageId)
    {
        $sql = "SELECT start_date, end_date FROM booking WHERE storage_id = :storage_id;";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':storage_id', $storageId);
        $stmt->execute();
        $bookedDates = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $availableDates = [];
        foreach ($bookedDates as $dates) {
            $availableDates[] = [
                'start_date' => $dates['start_date'],
                'end_date' => $dates['end_date']
            ];
        }
        return $availableDates;
    }

    public function isDateRangeAvailable($storageId, $startDate, $endDate)
    {
        $sql = "SELECT COUNT(*) as count FROM booking 
                WHERE storage_id = :storage_id 
                AND ((start_date BETWEEN :start_date AND :end_date) 
                OR (end_date BETWEEN :start_date AND :end_date) 
                OR (:start_date BETWEEN start_date AND end_date) 
                OR (:end_date BETWEEN start_date AND end_date));";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':storage_id', $storageId);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':end_date', $endDate);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['count'] == 0;
    }

    public function getReviews($storageId)
    {
        $sql = "SELECT r.review, r.rating, CONCAT(c.firstname, ' ', c.lastname) AS user_name 
                FROM reviews r 
                JOIN customer c ON r.userId = c.id 
                WHERE r.storage_id = :storage_id;";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':storage_id', $storageId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveTestimonial($testimonial)
    {
        $sql = "INSERT INTO testimonials (content) VALUES (:content)";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':content', $testimonial);
        return $stmt->execute();
    }

    public function getTestimonials()
    {
        $sql = "SELECT * FROM testimonials";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
$customerObj = new Customer();

// var_dump($customerObj->getSingleStorage(3));
// session_start();
// var_dump($customerObj->getBookings($_SESSION['customer']['id']));
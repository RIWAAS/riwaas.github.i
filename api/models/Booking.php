<?php
class Booking {
    private $conn;
    private $table_name = "bookings";

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $check_in;
    public $check_out;
    public $guests;
    public $payment_method;
    public $total_amount;
    public $booking_items;
    public $status;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                SET first_name=:first_name, last_name=:last_name, email=:email, 
                    phone=:phone, check_in=:check_in, check_out=:check_out, 
                    guests=:guests, payment_method=:payment_method, 
                    total_amount=:total_amount, booking_items=:booking_items, 
                    status=:status, created_at=:created_at";

        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->check_in = htmlspecialchars(strip_tags($this->check_in));
        $this->check_out = htmlspecialchars(strip_tags($this->check_out));
        $this->guests = htmlspecialchars(strip_tags($this->guests));
        $this->payment_method = htmlspecialchars(strip_tags($this->payment_method));
        $this->total_amount = htmlspecialchars(strip_tags($this->total_amount));
        $this->booking_items = htmlspecialchars(strip_tags($this->booking_items));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));

        // Bind values
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":check_in", $this->check_in);
        $stmt->bindParam(":check_out", $this->check_out);
        $stmt->bindParam(":guests", $this->guests);
        $stmt->bindParam(":payment_method", $this->payment_method);
        $stmt->bindParam(":total_amount", $this->total_amount);
        $stmt->bindParam(":booking_items", $this->booking_items);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":created_at", $this->created_at);

        if($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->first_name = $row['first_name'];
            $this->last_name = $row['last_name'];
            $this->email = $row['email'];
            $this->phone = $row['phone'];
            $this->check_in = $row['check_in'];
            $this->check_out = $row['check_out'];
            $this->guests = $row['guests'];
            $this->payment_method = $row['payment_method'];
            $this->total_amount = $row['total_amount'];
            $this->booking_items = $row['booking_items'];
            $this->status = $row['status'];
            $this->created_at = $row['created_at'];
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                SET status=:status 
                WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
<?php
class Room {
    private $conn;
    private $table_name = "rooms";

    public $id;
    public $name;
    public $description;
    public $price;
    public $image;
    public $amenities;
    public $rating;
    public $available;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE available = 1 ORDER BY price ASC";
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
            $this->name = $row['name'];
            $this->description = $row['description'];
            $this->price = $row['price'];
            $this->image = $row['image'];
            $this->amenities = $row['amenities'];
            $this->rating = $row['rating'];
            $this->available = $row['available'];
            return true;
        }
        return false;
    }

    public function checkAvailability($check_in, $check_out) {
        $query = "SELECT COUNT(*) as count FROM bookings 
                WHERE booking_items LIKE :room_id 
                AND status != 'cancelled' 
                AND (
                    (check_in <= :check_in AND check_out > :check_in) OR
                    (check_in < :check_out AND check_out >= :check_out) OR
                    (check_in >= :check_in AND check_out <= :check_out)
                )";
        
        $stmt = $this->conn->prepare($query);
        $room_pattern = '%"id":"' . $this->id . '"%';
        $stmt->bindParam(':room_id', $room_pattern);
        $stmt->bindParam(':check_in', $check_in);
        $stmt->bindParam(':check_out', $check_out);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] == 0;
    }
}
?>
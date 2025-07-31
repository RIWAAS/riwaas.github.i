<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/Room.php';

$database = new Database();
$db = $database->getConnection();
$room = new Room($db);

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method) {
    case 'GET':
        if(isset($_GET['id'])) {
            // Get specific room
            $room->id = $_GET['id'];
            if($room->readOne()) {
                echo json_encode(array(
                    "success" => true,
                    "data" => array(
                        "id" => $room->id,
                        "name" => $room->name,
                        "description" => $room->description,
                        "price" => $room->price,
                        "image" => $room->image,
                        "amenities" => json_decode($room->amenities),
                        "rating" => $room->rating,
                        "available" => $room->available
                    )
                ));
            } else {
                http_response_code(404);
                echo json_encode(array(
                    "success" => false,
                    "message" => "Room not found."
                ));
            }
        } elseif(isset($_GET['check_availability'])) {
            // Check room availability
            $room->id = $_GET['room_id'];
            $check_in = $_GET['check_in'];
            $check_out = $_GET['check_out'];
            
            $available = $room->checkAvailability($check_in, $check_out);
            
            echo json_encode(array(
                "success" => true,
                "available" => $available
            ));
        } else {
            // Get all available rooms
            $stmt = $room->read();
            $rooms_arr = array();
            
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $room_item = array(
                    "id" => $row['id'],
                    "name" => $row['name'],
                    "description" => $row['description'],
                    "price" => $row['price'],
                    "image" => $row['image'],
                    "amenities" => json_decode($row['amenities']),
                    "rating" => $row['rating'],
                    "available" => $row['available']
                );
                array_push($rooms_arr, $room_item);
            }
            
            echo json_encode(array(
                "success" => true,
                "data" => $rooms_arr
            ));
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(array(
            "success" => false,
            "message" => "Method not allowed."
        ));
        break;
}
?>
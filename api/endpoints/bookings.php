<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/Booking.php';

$database = new Database();
$db = $database->getConnection();
$booking = new Booking($db);

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method) {
    case 'POST':
        // Create new booking
        $data = json_decode(file_get_contents("php://input"));
        
        if(!empty($data->first_name) && !empty($data->last_name) && !empty($data->email) && 
           !empty($data->phone) && !empty($data->check_in) && !empty($data->check_out) && 
           !empty($data->guests) && !empty($data->payment_method) && !empty($data->total_amount) && 
           !empty($data->booking_items)) {
            
            $booking->first_name = $data->first_name;
            $booking->last_name = $data->last_name;
            $booking->email = $data->email;
            $booking->phone = $data->phone;
            $booking->check_in = $data->check_in;
            $booking->check_out = $data->check_out;
            $booking->guests = $data->guests;
            $booking->payment_method = $data->payment_method;
            $booking->total_amount = $data->total_amount;
            $booking->booking_items = json_encode($data->booking_items);
            $booking->status = 'pending';
            $booking->created_at = date('Y-m-d H:i:s');
            
            if($booking->create()) {
                http_response_code(201);
                echo json_encode(array(
                    "success" => true,
                    "message" => "Booking created successfully.",
                    "booking_id" => $booking->id
                ));
            } else {
                http_response_code(503);
                echo json_encode(array(
                    "success" => false,
                    "message" => "Unable to create booking."
                ));
            }
        } else {
            http_response_code(400);
            echo json_encode(array(
                "success" => false,
                "message" => "Unable to create booking. Data is incomplete."
            ));
        }
        break;
        
    case 'GET':
        // Get all bookings or specific booking
        if(isset($_GET['id'])) {
            $booking->id = $_GET['id'];
            if($booking->readOne()) {
                echo json_encode(array(
                    "success" => true,
                    "data" => array(
                        "id" => $booking->id,
                        "first_name" => $booking->first_name,
                        "last_name" => $booking->last_name,
                        "email" => $booking->email,
                        "phone" => $booking->phone,
                        "check_in" => $booking->check_in,
                        "check_out" => $booking->check_out,
                        "guests" => $booking->guests,
                        "payment_method" => $booking->payment_method,
                        "total_amount" => $booking->total_amount,
                        "booking_items" => json_decode($booking->booking_items),
                        "status" => $booking->status,
                        "created_at" => $booking->created_at
                    )
                ));
            } else {
                http_response_code(404);
                echo json_encode(array(
                    "success" => false,
                    "message" => "Booking not found."
                ));
            }
        } else {
            $stmt = $booking->read();
            $bookings_arr = array();
            
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $booking_item = array(
                    "id" => $row['id'],
                    "first_name" => $row['first_name'],
                    "last_name" => $row['last_name'],
                    "email" => $row['email'],
                    "phone" => $row['phone'],
                    "check_in" => $row['check_in'],
                    "check_out" => $row['check_out'],
                    "guests" => $row['guests'],
                    "payment_method" => $row['payment_method'],
                    "total_amount" => $row['total_amount'],
                    "booking_items" => json_decode($row['booking_items']),
                    "status" => $row['status'],
                    "created_at" => $row['created_at']
                );
                array_push($bookings_arr, $booking_item);
            }
            
            echo json_encode(array(
                "success" => true,
                "data" => $bookings_arr
            ));
        }
        break;
        
    case 'PUT':
        // Update booking status
        $data = json_decode(file_get_contents("php://input"));
        
        if(!empty($data->id) && !empty($data->status)) {
            $booking->id = $data->id;
            $booking->status = $data->status;
            
            if($booking->update()) {
                echo json_encode(array(
                    "success" => true,
                    "message" => "Booking updated successfully."
                ));
            } else {
                http_response_code(503);
                echo json_encode(array(
                    "success" => false,
                    "message" => "Unable to update booking."
                ));
            }
        } else {
            http_response_code(400);
            echo json_encode(array(
                "success" => false,
                "message" => "Unable to update booking. Data is incomplete."
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
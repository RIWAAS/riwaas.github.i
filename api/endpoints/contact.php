<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$request_method = $_SERVER["REQUEST_METHOD"];

if($request_method == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    
    if(!empty($data->name) && !empty($data->email) && !empty($data->phone) && !empty($data->message)) {
        
        $to = "guesthouseriwaas@gmail.com";
        $subject = "New Contact Form Submission - Riwaa's Guest House";
        
        $message = "
        <html>
        <head>
            <title>New Contact Form Submission</title>
        </head>
        <body>
            <h2>New Contact Form Submission</h2>
            <p><strong>Name:</strong> " . htmlspecialchars($data->name) . "</p>
            <p><strong>Email:</strong> " . htmlspecialchars($data->email) . "</p>
            <p><strong>Phone:</strong> " . htmlspecialchars($data->phone) . "</p>
            <p><strong>Message:</strong></p>
            <p>" . nl2br(htmlspecialchars($data->message)) . "</p>
            <hr>
            <p><small>This message was sent from the Riwaa's Guest House website contact form.</small></p>
        </body>
        </html>
        ";
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: noreply@riwaas-guesthouse.com" . "\r\n";
        $headers .= "Reply-To: " . htmlspecialchars($data->email) . "\r\n";
        
        if(mail($to, $subject, $message, $headers)) {
            echo json_encode(array(
                "success" => true,
                "message" => "Message sent successfully!"
            ));
        } else {
            http_response_code(500);
            echo json_encode(array(
                "success" => false,
                "message" => "Failed to send message. Please try again."
            ));
        }
        
    } else {
        http_response_code(400);
        echo json_encode(array(
            "success" => false,
            "message" => "Please fill in all required fields."
        ));
    }
} else {
    http_response_code(405);
    echo json_encode(array(
        "success" => false,
        "message" => "Method not allowed."
    ));
}
?>
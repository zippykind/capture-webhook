<?php
// The code below has been written to offer an example of how the Zippykind WebHook could be captured and added
// to a mysql database table.  The code is not guaranteed to work for your use case and Zippykind doesn't offer any warranties 
// or guarantees on this code provided!

$servername = "localhost";
$username = "root";
$password = "password";

// Takes raw data from the WebHook request
$request_json = file_get_contents('php://input');

// Converts it into a PHP object
$request_data = json_decode($request_json);

// Get data
$event_name=$request_data->event_name;
$date_stamp=$request_data->date_stamp;
$hand_shake_key=$request_data->hand_shake_key;

$webhook_data=$request_data->data;
$ticket_id=$webhook_data->ticket_id;
$ext_order_id=$webhook_data->ext_order_id;
$ext_customer_number=$webhook_data->ext_customer_number;
$ext_invoice_number=$webhook_data->ext_invoice_number;
$status=$webhook_data->status;
$team_id=$webhook_data->team_id;
$driver_id=$webhook_data->driver_id;
$ticket_lat=$webhook_data->ticket_lat;
$ticket_lng=$webhook_data->ticket_lng;
$product_pickup_lat=$webhook_data->product_pickup_lat;
$product_pickup_lng=$webhook_data->product_pickup_lng;
$driver_location_lat=$webhook_data->driver_location_lat;
$driver_location_lng=$webhook_data->driver_location_lng;

// Insert data into mysql database table
try {
    $conn = new PDO("mysql:host=$servername;dbname=zippy_kind_v2", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO zippykind_webhook_data (
												event_name, 
												date_stamp, 
												ticket_id, 
												ext_order_id, 
												ext_customer_number, 
												ext_invoice_number,
												status,
												team_id,
												driver_id,
												ticket_lat,
												ticket_lng,
												product_pickup_lat,
												product_pickup_lng,
												driver_location_lat,
												driver_location_lng,
												hand_shake_key
												)
    		VALUES (
					'".$event_name."',
					'".$date_stamp."',
					'".$ticket_id."',
					'".$ext_order_id."',
					'".$ext_customer_number."',
					'".$ext_invoice_number."',
					'".$status."',
					'".$team_id."',
					'".$driver_id."',
					'".$ticket_lat."',
					'".$ticket_lng."',
					'".$product_pickup_lat."',
					'".$product_pickup_lng."',
					'".$driver_location_lat."',
					'".$driver_location_lng."',
					'".$hand_shake_key."'
					)";
    $conn->exec($sql);
    echo "New record created successfully";
}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;


// You only need to set the verification token once when you setup the WebHook, afterwhich you can remove this code.
// We just need to make sure that the server you will be sending requests to is a server that you have permission to send requests to.
/*
echo '{ "details" : { "zippy_token":"0UOogkpz871mLivfygc" }}';
*/
?>
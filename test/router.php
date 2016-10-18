<?php
$response = filter_input(INPUT_GET,"response",FILTER_VALIDATE_INT);
$method = filter_input(INPUT_SERVER,"REQUEST_METHOD");
if ( $response != null ) {
	http_response_code($response);
}
if ( $method == "POST") {
	http_response_code(201);
}
if ( $method == "PUT") {
	http_response_code(202);
}
echo json_encode(array("test"=>"route"));

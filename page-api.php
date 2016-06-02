<?php
/*
 * Template Name: WP-AFA API Page
 *
 * Important Notes:
 *
 * 1- The API just accept POST requests.
 * 2- The $_POST should have 'requestData' parameter.
 * 3- The 'requestData' should be an object in JSON format.
 * 4- 'requestData' object should contain the following.
 * - domain: string
 * - datasource: string
 * - datasegment: string
 * - params: object
 *
 */
$data = array ();
$forceDataAsArray = FALSE;

if (! sizeof ( $_POST )) {
	$data ['error'] = 'This is not a valid request!';
	wpafa_api::send_data_to_client ( $data, FALSE );
}

if (! isset ( $_POST ['requestData'] )) {
	$data ['error'] = 'No Request Data!';
	wpafa_api::send_data_to_client ( $data, FALSE );
}
$requestData = str_replace ( '\\', '', $_POST ["requestData"] );
$requestData = json_decode ( $requestData );

wpafa_api::validate_request ( $requestData );
wpafa_api::process_request ( $requestData );
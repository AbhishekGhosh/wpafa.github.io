<?php
/**
 * WP-AFA API Class
 */
class wpafa_api {
	public static function send_data_to_client($data, $isOk = true, $forceDataAsArray = false) {
		header ( 'Content-Type: application/json' );
		
		if (is_array ( $data ) && ! $forceDataAsArray) {
			$data = ( object ) $data;
		}
		
		$dataToSend = ( object ) array (
				'result' => $isOk ? 'ok' : 'not ok!',
				'theData' => $data 
		);
		echo json_encode ( $dataToSend );
		exit ();
	}
	public static function validate_request($requestData) {
		$errors = array ();
		
		if (! isset ( $requestData->domain )) {
			$errors [] = 'Domain is missing';
		}
		if (! isset ( $requestData->datasource )) {
			$errors [] = 'Data Source is missing';
		}
		if (! isset ( $requestData->datasegment )) {
			$errors [] = 'Data Segment is missing';
		}
		if (! isset ( $requestData->params )) {
			$errors [] = 'Params is missing';
		}
		
		if (sizeof ( $errors ) > 0) {
			self::send_data_to_client ( ( object ) array (
					'message' => 'invalid request',
					"details" => $errors 
			), false );
		}
	}
	public static function process_request($requestData) {
		$namespace = str_replace ( '-', '_', $operationData->domain );
		$class_name = str_replace ( '-', '_', $operationData->datasource );
		$function_name = str_replace ( '-', '_', $operationData->datasegment );
		$params = $operationData->params;
		
		if (! empty ( $namespace )) {
			$class_name = sprintf ( '%1$s\\%2$s', $namespace, $class_name );
		}
		
		if (! class_exists ( $class_name )) {
			$error = ( object ) array (
					'message' => 'data source not defined!',
					"details" => sprintf ( '%1$s%2$s%3$s', $namespace, (empty ( $namespace ) ? '' : '\\'), $class_name ) 
			);
			self::send_data_to_client ( $error, FALSE );
			return;
		}
		
		$objectinstance = new $class_name ();
		
		if (! method_exists ( $objectinstance, $function_name )) {
			$error = ( object ) array (
					'message' => 'data segment not defined!',
					"details" => sprintf ( '%1$s%2$s%3$s\\%4$s', $namespace, (empty ( $namespace ) ? '' : '\\'), $class_name, $function_name ) 
			);
			self::send_data_to_client ( $error, FALSE );
			return;
		}
		
		try {
			$data = $objectinstance->$function_name ( $params );
			self::send_data_to_client ( $data );
		} catch ( Exception $e ) {
			$error = ( object ) array (
					'message' => 'Caught exception!',
					"details" => $e->getMessage () 
			);
			self::send_data_to_client ( $error, FALSE );
		}
	}
}
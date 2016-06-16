<?php

namespace wpafaeg;

class contacts {
	public function list_data($params) {
		global $wpdb;
		$contactsTableName = sprintf ( '%1$safa_contacts', $wpdb->prefix );
		$usersTableName = sprintf ( '%1$susers', $wpdb->prefix );
		
		$results = $wpdb->get_results ( "
				SELECT
					$contactsTableName.*,
					$contactsTableName.first_name as temp_first_name,
					$contactsTableName.last_name as temp_last_name,
					$contactsTableName.email as temp_email,
					$contactsTableName.phone as temp_phone,
					false as editing_mood,
					false as is_new,
					created_by_user.display_name AS created_by,
					modified_by_user.display_name AS modified_by
				FROM
					$contactsTableName
				LEFT OUTER JOIN $usersTableName AS created_by_user ON (
					created_by_user.ID = $contactsTableName.created_by_id
				)
				LEFT OUTER JOIN $usersTableName AS modified_by_user ON (
					modified_by_user.ID = $contactsTableName.modified_by_id
				)
				" );
		
		log_to_file ( $wpdb->last_query );
		log_to_file ( $wpdb->last_error );
		
		return ( object ) array (
				"contacts_list" => $results 
		);
	}
	public function save_item($params) {
		$dataToSave = array (
				"first_name" => $params->temp_first_name,
				"last_name" => $params->temp_last_name,
				"email" => $params->temp_email,
				"phone" => $params->temp_phone,
				"modified_by_id" => get_current_user_id (),
				"modified_on" => date ( "Y-m-d H:i:s" ) 
		);
		
		global $wpdb;
		$contactsTableName = sprintf ( '%1$safa_contacts', $wpdb->prefix );
		$usersTableName = sprintf ( '%1$susers', $wpdb->prefix );
		
		if ($params->is_new) {
			$dataToSave ['created_by_id'] = $dataToSave ['modified_by_id'];
			$dataToSave ['created_on'] = $dataToSave ['modified_on'];
			
			$wpdb->insert ( $contactsTableName, $dataToSave );
			$params->id = $wpdb->insert_id;
		} else {
			$wpdb->update ( $contactsTableName, $dataToSave, array (
					'id' => $params->id 
			) );
		}
		
		$item = $wpdb->get_row ( $wpdb->prepare ( "
				SELECT
					$contactsTableName.*,
					$contactsTableName.first_name as temp_first_name,
					$contactsTableName.last_name as temp_last_name,
					$contactsTableName.email as temp_email,
					$contactsTableName.phone as temp_phone,
					false as editing_mood,
					false as is_new,
					created_by_user.display_name AS created_by,
					modified_by_user.display_name AS modified_by
				FROM
					$contactsTableName
				LEFT OUTER JOIN $usersTableName AS created_by_user ON (
					created_by_user.ID = $contactsTableName.created_by_id
				)
				LEFT OUTER JOIN $usersTableName AS modified_by_user ON (
					modified_by_user.ID = $contactsTableName.modified_by_id
				)
				WHERE $contactsTableName.id = %d
				", $params->id ) );
		if (isset ( $params->guid )) {
			$item->guid = $params->guid;
		}
		return $item;
	}
	public function delete_item($params) {
		global $wpdb;
		$contactsTableName = sprintf ( '%1$safa_contacts', $wpdb->prefix );
		$wpdb->delete ( $contactsTableName, array (
				'id' => $params->id 
		) );
		
		return $params;
	}
}
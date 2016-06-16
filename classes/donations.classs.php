<?php

namespace wpafaeg;

class donations {
	public function list_data($params) {
		global $wpdb;
		$donationsTableName = sprintf ( '%1$safa_donations', $wpdb->prefix );
		$contactsTableName = sprintf ( '%1$safa_contacts', $wpdb->prefix );
		$usersTableName = sprintf ( '%1$susers', $wpdb->prefix );
		
		$donations_list = $wpdb->get_results ( "
				SELECT
					$donationsTableName.*, 
					$donationsTableName.amount AS temp_amount,
					$donationsTableName.remarks AS temp_remarks,
					FALSE AS editing_mood,
					FALSE AS is_new,
					CONCAT($contactsTableName.first_name , ' ' , $contactsTableName.last_name) as contact_name,
					created_by_user.display_name AS created_by,
					modified_by_user.display_name AS modified_by
				FROM
					$donationsTableName
				INNER JOIN $contactsTableName ON (
					$donationsTableName.contact_id = $contactsTableName.id
				)
				LEFT OUTER JOIN $usersTableName AS created_by_user ON (
					created_by_user.ID = $donationsTableName.created_by_id
				)
				LEFT OUTER JOIN $usersTableName AS modified_by_user ON (
					modified_by_user.ID = $donationsTableName.modified_by_id
				)
				" );
		
		$contacts_list = $wpdb->get_results ( "
				SELECT
					$contactsTableName.id,
					CONCAT($contactsTableName.first_name , ' ' , $contactsTableName.last_name) as contact_name
				FROM
					$contactsTableName 
				ORDER BY $contactsTableName.first_name, $contactsTableName.last_name
				" );
		
		// Normalize Ids
		
		foreach ( $donations_list as &$donation ) {
			settype ( $donation->amount, 'float' );
			settype ( $donation->temp_amount, 'float' );
			
			$donation->temp_contact = ( object ) array (
					"id" => $donation->contact_id,
					"contact_name" => $donation->contact_name 
			);
		}
		
		foreach ( $contacts_list as &$contact ) {
			settype ( $contact->id, 'int' );
		}
		
		return ( object ) array (
				"donations_list" => $donations_list,
				"contacts_list" => $contacts_list 
		);
	}
	public function save_item($params) {
		$dataToSave = array (
				"contact_id" => $params->temp_contact->id,
				"remarks" => $params->temp_remarks,
				"amount" => $params->temp_amount,
				"date" => $params->temp_date,
				"modified_by_id" => get_current_user_id (),
				"modified_on" => date ( "Y-m-d H:i:s" ) 
		);
		
		global $wpdb;
		$donationsTableName = sprintf ( '%1$safa_donations', $wpdb->prefix );
		$contactsTableName = sprintf ( '%1$safa_contacts', $wpdb->prefix );
		$usersTableName = sprintf ( '%1$susers', $wpdb->prefix );
		
		if ($params->is_new) {
			$dataToSave ['created_by_id'] = $dataToSave ['modified_by_id'];
			$dataToSave ['created_on'] = $dataToSave ['modified_on'];
			
			$wpdb->insert ( $donationsTableName, $dataToSave );
			$params->id = $wpdb->insert_id;
		} else {
			$wpdb->update ( $donationsTableName, $dataToSave, array (
					'id' => $params->id 
			) );
		}
		
		$item = $wpdb->get_row ( $wpdb->prepare ( "
				SELECT
					$donationsTableName.*, 
					$donationsTableName.amount AS temp_amount,
					$donationsTableName.remarks AS temp_remarks,
					FALSE AS editing_mood,
					FALSE AS is_new,
					CONCAT($contactsTableName.first_name , ' ' , $contactsTableName.last_name) as contact_name,
					created_by_user.display_name AS created_by,
					modified_by_user.display_name AS modified_by
				FROM
					$donationsTableName
				INNER JOIN $contactsTableName ON (
					$donationsTableName.contact_id = $contactsTableName.id
				)
				LEFT OUTER JOIN $usersTableName AS created_by_user ON (
					created_by_user.ID = $donationsTableName.created_by_id
				)
				LEFT OUTER JOIN $usersTableName AS modified_by_user ON (
					modified_by_user.ID = $donationsTableName.modified_by_id
				)
				WHERE $donationsTableName.id = %d
				", $params->id ) );
		if (isset ( $params->guid )) {
			$item->guid = $params->guid;
		}
		return $item;
	}
	public function delete_item($params) {
		global $wpdb;
		$donationsTableName = sprintf ( '%1$safa_donations', $wpdb->prefix );
		$wpdb->delete ( $donationsTableName, array (
				'id' => $params->id 
		) );
		
		return $params;
	}
}
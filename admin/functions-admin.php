<?php

/* Add license key menu item under Appeareance. */
add_action( 'admin_menu', 'kalervo_theme_license_menu' );

/* Register option for the license. */
add_action( 'admin_init', 'kalervo_theme_register_option' );

/* Activate the license. */
add_action( 'admin_init', 'kalervo_theme_activate_license' );

/* Deactivate the license. */
add_action( 'admin_init', 'kalervo_theme_deactivate_license' );


/**
 * Add license key menu item under Appeareance.
 *
 * @since 0.1.0
 */
function kalervo_theme_license_menu() {

	add_theme_page( __( 'Theme License', 'kalervo' ), __( 'Theme License', 'kalervo' ), 'manage_options', 'kalervo-license', 'kalervo_theme_license_page' );
	
}

/**
 * Setting page for license key.
 *
 * @since 0.1.0
 */
function kalervo_theme_license_page() {
	$license 	= get_option( 'kalervo_theme_license_key' );
	$status 	= get_option( 'kalervo_theme_license_key_status' );
	?>
	<div class="wrap">
		<h2><?php _e( 'Theme License Options', 'kalervo' ); ?></h2>
		<form method="post" action="options.php">
		
			<?php settings_fields( 'kalervo_theme_license' ); ?>
			
			<table class="form-table">
				<tbody>
					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e( 'License Key', 'kalervo' ); ?>
						</th>
						<td>
							<input id="kalervo_theme_license_key" name="kalervo_theme_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<label class="description" for="kalervo_theme_license_key"><?php _e( 'Enter your license key', 'kalervo' ); ?></label>
						</td>
					</tr>
					<?php if( false !== $license ) { ?>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e( 'Activate License', 'kalervo' ); ?>
							</th>
							<td>
								<?php if( $status !== false && $status == 'valid' ) { ?>
									<span style="color:green;"><?php _e( 'Active', 'kalervo' ); ?></span>
									<?php wp_nonce_field( 'kalervo_nonce', 'kalervo_nonce' ); ?>
									<input type="submit" class="button-secondary" name="kalervo_theme_license_deactivate" value="<?php esc_attr_e( 'Deactivate License', 'kalervo' ); ?>"/>
								<?php } else {
									wp_nonce_field( 'kalervo_nonce', 'kalervo_nonce' ); ?>
									<input type="submit" class="button-secondary" name="kalervo_theme_license_activate" value="<?php esc_attr_e( 'Activate License', 'kalervo' ); ?>"/>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>	
			<?php submit_button(); ?>
		
		</form>
	<?php
}

function kalervo_theme_register_option() {
	// creates our settings in the options table
	register_setting( 'kalervo_theme_license', 'kalervo_theme_license_key', 'kalervo_theme_sanitize_license' );
}

/**
 * Gets rid of the local license status option when adding a new one.
 * @since 0.1.0
 */

function kalervo_theme_sanitize_license( $new ) {
	$old = get_option( 'kalervo_theme_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'kalervo_theme_license_key_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}

/**
 * Activate the license.
 *
 * @since 0.1.0
 */
function kalervo_theme_activate_license() {

	if( isset( $_POST['kalervo_theme_license_activate'] ) ) { 
	 	if( ! check_admin_referer( 'kalervo_nonce', 'kalervo_nonce' ) ) 	
			return; // get out if we didn't click the Activate button

		global $wp_version;

		$license = trim( get_option( 'kalervo_theme_license_key' ) );
				
		$api_params = array( 
			'edd_action' => 'activate_license', 
			'license'    => $license, 
			'item_name'  => urlencode( KALERVO_SL_THEME_NAME ) 
		);
		
		$response = wp_remote_get( add_query_arg( $api_params, KALERVO_SL_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		if ( is_wp_error( $response ) )
			return false;

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		
		// $license_data->license will be either "active" or "inactive"

		update_option( 'kalervo_theme_license_key_status', $license_data->license );

	}
}

/**
 * Deactivate the license. This will decrease the site count.
 *
 * @since 0.1.0
 */

function kalervo_theme_deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['kalervo_theme_license_deactivate'] ) ) {

		// run a quick security check 
	 	if( ! check_admin_referer( 'kalervo_nonce', 'kalervo_nonce' ) ) 	
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'kalervo_theme_license_key' ) );
			

		// data to send in our API request
		$api_params = array( 
			'edd_action'=> 'deactivate_license', 
			'license' 	=> $license, 
			'item_name' => urlencode( KALERVO_SL_THEME_NAME ) // the name of our product in EDD
		);
		
		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, KALERVO_SL_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		
		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' )
			delete_option( 'kalervo_theme_license_key_status' );

	}
}


/***********************************************
* Illustrates how to check if a license is valid
***********************************************/

function kalervo_theme_check_license() {

	global $wp_version;

	$license = trim( get_option( 'kalervo_theme_license_key' ) );
		
	$api_params = array( 
		'edd_action' => 'check_license', 
		'license' => $license, 
		'item_name' => urlencode( KALERVO_SL_THEME_NAME ) 
	);
	
	$response = wp_remote_get( add_query_arg( $api_params, KALERVO_SL_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

	if ( is_wp_error( $response ) )
		return false;

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	if( $license_data->license == 'valid' ) {
		echo 'valid'; exit;
		// this license is still valid
	} else {
		echo 'invalid'; exit;
		// this license is no longer valid
	}
}

?>
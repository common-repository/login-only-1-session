<?php
/*
 Plugin Name: Login Only 1 Session
 Description: This plug-in can limit simultaneous login.
 Author: COLORCHIPS
 Version: 1.0
 */
define( 'CCLO_CHECK_KEY' , 'cclo-key' );
 
add_action( 'auth_cookie_valid', 'cclo_check_key' , null , 2 );
function cclo_check_key( $cookie_elements, $user) {
	
	$login_key = get_user_meta( $user->ID , CCLO_CHECK_KEY , true );
	
	//check cookie,login_key
	if( $login_key != $_COOKIE[CCLO_CHECK_KEY] ) {
		//error??
		$redirect_to = wp_login_url() ;	
		wp_logout();
		wp_safe_redirect( $redirect_to );
	}
}

add_filter( 'auth_cookie', 'cclo_set_key' , null , 4 );
function cclo_set_key( $cookie, $user_id, $expiration, $scheme ){
	
	$login_key = 'i_have_a_dream_'.time();
	
	update_user_meta( $user_id , CCLO_CHECK_KEY, $login_key );
	
	setcookie( CCLO_CHECK_KEY , $login_key , $expiration, SITECOOKIEPATH );

	return $cookie;	
}

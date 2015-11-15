<?php

function addLeadConversion( $form_data ) {

 	$api_url = "http://www.rdstation.com.br/api/1.2/conversions";

	empty($form_data["email"]) ? $form_data["email"] = $form_data["your-email"] : false;
	empty($form_data["c_utmz"]) ? $form_data["c_utmz"] = $_COOKIE["__utmz"] : false;
	empty($form_data["traffic_source"]) ? $form_data["traffic_source"] = $_COOKIE["__trf_src"] : false;

	if (empty($form_data["client_id"]) && !empty($_COOKIE["rdtrk"])) {
	    preg_match("/(\w{8}-\w{4}-4\w{3}-\w{4}-\w{12})/",$_COOKIE["rdtrk"],$Matches);
	    $form_data["client_id"] = $Matches[0];
	}

	unset(
		$form_data["password"],
		$form_data["password_confirmation"],
		$form_data["senha"],
	    $form_data["confirme_senha"],
	    $form_data["captcha"],
	    $form_data["_wpcf7"],
	    $form_data["_wpcf7_version"],
	    $form_data["_wpcf7_unit_tag"],
	    $form_data["_wpnonce"],
	    $form_data["_wpcf7_is_ajax_call"],
	    $form_data["_wpcf7_locale"],
	    $form_data["your-email"]
	);

	$args = array(
        'headers' => array('Content-Type' => 'application/json'),
        'body' => json_encode($form_data)
    );

    $response = wp_remote_post( $api_url, $args );

    if (is_wp_error($response)){
    	wp_die('Erro ao enviar o formulário');
    	unset($form_data);
    }
}

function get_form_data( $cf7 ) {

	$args = array( 'post_type'=>'rdcf7_integrations', 'posts_per_page' => 100 );

	$forms = get_posts($args);

	foreach ($forms as $form) {
	    $form_id = get_post_meta($form->ID, 'form_id', true);
	    if ( $form_id == $cf7->id ) {
			$submission = WPCF7_Submission::get_instance();
			if ( $submission ) {
			 	$form_data = $submission->get_posted_data();
			}
			$form_data[ 'token_rdstation' ] = get_post_meta($form->ID, 'token_rdstation', true);
			$form_data[ 'identificador' ] 	= get_post_meta($form->ID, 'form_identifier', true);
			$form_data['form_origem']		= 'Plugin Contact Form 7';
	    	addLeadConversion($form_data);
		}
	}
}
add_action('wpcf7_mail_sent', 'get_form_data');

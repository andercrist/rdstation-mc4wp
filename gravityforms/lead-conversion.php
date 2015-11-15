<?php

function gf_add_lead_conversion( $form_data ) {

	$api_url = "http://www.rdstation.com.br/api/1.2/conversions";

	empty($form_data["c_utmz"]) ? $form_data["c_utmz"] = $_COOKIE["__utmz"] : false;
	empty($form_data["traffic_source"]) ? $form_data["traffic_source"] = $_COOKIE["__trf_src"] : false;

	if (empty($form_data["client_id"]) && !empty($_COOKIE["rdtrk"])) {
	    preg_match("/(\w{8}-\w{4}-4\w{3}-\w{4}-\w{12})/",$_COOKIE["rdtrk"],$Matches);
	    $form_data["client_id"] = $Matches[0];
	}
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

function gf_get_form_data( $entry, $form ) {
	$form_data['id'] = $form['id'];
    foreach ($entry as $item => $value) {
    	if (is_numeric($item)){
    		$form_data[$item] = $value;
    		if(filter_var($value, FILTER_VALIDATE_EMAIL)){
    			$form_data['email'] = $value;
				unset($form_data[$item]);
    		}
    	}
    }

	$args = array( 'post_type'=>'rdgf_integrations', 'posts_per_page' => 100 );

	$forms = get_posts($args);

	foreach ($forms as $form) {
	    $form_id = get_post_meta($form->ID, 'gf_form_id', true);
	    if ( $form_id == $form_data['id'] ) {
			$form_data[ 'token_rdstation' ] = get_post_meta($form->ID, 'token_rdstation', true);
			$form_data[ 'identificador' ] 	= get_post_meta($form->ID, 'gf_form_identifier', true);
			$form_data['form_origem']		= 'Plugin Gravity Forms';
	    	gf_add_lead_conversion($form_data);
		}
	}
}
add_action( 'gform_after_submission', 'gf_get_form_data', 10, 2 );

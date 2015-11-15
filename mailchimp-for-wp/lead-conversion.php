<?php

function mc4wp_add_lead_conversion( $form_data ) {

 	$api_url = "http://www.rdstation.com.br/api/1.2/conversions";

	empty($form_data["c_utmz"]) ? $form_data["c_utmz"] = $_COOKIE["__utmz"] : false;
	
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

function rdmc4wp_form_success( $number, $data_email, $data ) {
	$form_data['token_rdstation'] =  get_option("rdmc4wp-token");
	$form_data['identificador'] = get_option("rdmc4wp-identificador");
	$form_data['form_origem'] = 'Plugin MC4WP';
	$form_data['email'] = $data['EMAIL'];
	if(array_key_exists('FNAME',$data)) $form_data['nome'] = $data['FNAME'];
	mc4wp_add_lead_conversion($form_data);

}

add_action( 'mc4wp_form_success', 'rdmc4wp_form_success', 10, 3 );
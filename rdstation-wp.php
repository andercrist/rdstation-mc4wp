<?php

/*
Plugin Name: 	Integração RD Station
Plugin URI: 	https://github.com/haarieh/rdstation-mc4wp
Description: 	Integre seus formulários de contato do WordPress com o RD Station
Version: 		1.2
Author: 		Resultados Digitais
Author URI: 	http://resultadosdigitais.com.br
License: 		GPL2
License URI:	https://www.gnu.org/licenses/gpl-2.0.html

Integração RD Station is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Integração RD Station is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Integração RD Station. If not, see https://www.gnu.org/licenses/gpl-2.0.html.

*/

if ( is_admin() ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	include_once( dirname(__file__).'/contactform7/create-settings.php');
	include_once( dirname(__file__).'/gravityforms/create-settings.php');
	include_once( dirname(__file__).'/mailchimp-for-wp/RdMC4WP.php');
}

include_once( dirname(__file__).'/contactform7/lead-conversion.php');
include_once( dirname(__file__).'/gravityforms/lead-conversion.php');
include_once( dirname(__file__).'/mailchimp-for-wp/lead-conversion.php');
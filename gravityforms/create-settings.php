<?php

add_action( 'init', 'rdgf_custom_post_type' );
function rdgf_custom_post_type() {
    $labels = array(
        'name'                  => _x( 'Integrações GF', 'post_type_general_name' ),
        'singular_name'         => _x( 'Integração GF', 'post_type_singular_name' ),
        'add_new'               => _x( 'Criar integração', 'integration' ),
        'add_new_item'          => __( 'Criar Nova Integração' ),
        'edit_item'             => __( 'Editar Integração' ),
        'new_item'              => __( 'Nova Integração' ),
        'all_items'             => __( 'Todas Integrações' ),
        'view_item'             => __( 'Ver Integrações' ),
        'search_items'          => __( 'Procurar Integrações' ),
        'not_found'             => __( 'Nenhuma integração encontrada' ),
        'not_found_in_trash'    => __( 'Nenhuma integração encontrada na lixeira' ),
        'parent_item_colon'     => '',
        'menu_name'             => 'RD Station GF'
    );
    $args = array(
        'labels'                => $labels,
        'description'           => 'Integração do Gravity Forms com o RD Station',
        'public'                => true,
        'menu_position'         => 50,
        'supports'              => array( 'title' ),
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'show_in_admin_bar'     => false,
        'show_in_nav_menus'     => false,
        'publicly_queryable'    => false,
        'query_var'             => false
    );
    if (is_plugin_active('gravityforms/gravityforms.php')) register_post_type( 'rdgf_integrations', $args );
}

// Remove View Page
add_filter( 'post_row_actions', 'gf_remove_row_actions', 10, 2 );
function gf_remove_row_actions( $actions, $post ) {
  global $current_screen;
    if( $current_screen->post_type != 'rdgf_integrations' ) return $actions;
    unset( $actions['view'] );
    unset( $actions['inline hide-if-no-js'] );
    return $actions;
}

// Change Publish Button Text
add_filter( 'gettext', 'rdgf_change_publish_button', 10, 2 );
function rdgf_change_publish_button( $translation, $text ) {
    if ( 'rdgf_integrations' == get_post_type())
        if ( $text == 'Publish')
            return 'Integrar';
    return $translation;
}

// Change Default Placeholder Title
add_filter( 'enter_title_here', 'rdgf_change_default_title' );
function rdgf_change_default_title( $title ){
    $screen = get_current_screen();
    if ( 'rdgf_integrations' == $screen->post_type )
        $title = 'Dê um nome para essa integração';
    return $title;
}

// Gravity Forms Meta Box
add_action( 'add_meta_boxes', 'rdgf_form_identifier_box' );
function rdgf_form_identifier_box() {
    add_meta_box(
        'rdgf_form_identifier_box',
        'Identificador',
        'rdgf_form_identifier_box_content',
        'rdgf_integrations',
        'normal'
    );
}

function rdgf_form_identifier_box_content(){
    $identifier = get_post_meta(get_the_ID(), 'gf_form_identifier', true);
    echo '<input type="text" name="gf_form_identifier" value="'.$identifier.'">';
    echo '<span>Esse identificador irá lhe ajudar a saber o formulário de origem do lead.</span>';
}

add_action( 'save_post', 'rdgf_form_identifier_box_save' );
function rdgf_form_identifier_box_save( $post_id ) {
  $identifier = $_POST['gf_form_identifier'];
  update_post_meta( $post_id, 'gf_form_identifier', $identifier );
}

add_action( 'add_meta_boxes', 'rdgf_token_rdstation_box' );
function rdgf_token_rdstation_box() {
    add_meta_box(
        'rdgf_token_rdstation_box',
        'Token RD Station',
        'rdgf_token_rdstation_box_content',
        'rdgf_integrations',
        'normal'
    );
}

function rdgf_token_rdstation_box_content(){
    $token = get_post_meta(get_the_ID(), 'token_rdstation', true);
    echo '<input type="text" name="token_rdstation" size="32" value="'.$token.'">';
    echo '<span>Não sabe seu token? <a href="https://www.rdstation.com.br/integracoes" target="blank">Clique aqui</a></span>';
}

add_action( 'save_post', 'rdgf_token_rdstation_box_save' );
function rdgf_token_rdstation_box_save( $post_id ) {
  $token = $_POST['token_rdstation'];
  update_post_meta( $post_id, 'token_rdstation', $token );
}

add_action( 'add_meta_boxes', 'rdgf_form_id_box' );
function rdgf_form_id_box() {
    add_meta_box(
        'rdgf_form_id_box',
        'Qual formulário você deseja integrar ao RD Station?',
        'rdgf_form_id_box_content',
        'rdgf_integrations',
        'normal'
    );
}

function rdgf_form_id_box_content(){
    $form_id = get_post_meta(get_the_ID(), 'gf_form_id', true);
    $gForms = RGFormsModel::get_forms( null, 'title' );
    if( !$gForms ) :
        echo '<p>Não encontramos nenhum formulário cadastrado, entre no seu plugin de formulário de contato ou <a href="admin.php?page=gf_new_form">clique aqui para criar um novo.</a></p>';

    else : ?>
        <select name="gf_form_id">
            <option value=""> </option>
            <?php
                foreach($gForms as $gForm){
                    echo "<option value=".$gForm->id.selected( $form_id, $gForm->id, false) .">".$gForm->title."</option>";
                }
            ?>
        </select>
    <?php
    endif;
}

add_action( 'save_post', 'rdgf_form_id_box_save' );
function rdgf_form_id_box_save( $post_id ) {
  $id = $_POST['gf_form_id'];
  update_post_meta( $post_id, 'gf_form_id', $id );
}
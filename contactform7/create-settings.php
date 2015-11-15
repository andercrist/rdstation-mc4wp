<?php
add_action( 'init', 'rdcf7_custom_post_type' );
function rdcf7_custom_post_type() {
    $labels = array(
        'name'                  => _x( 'Integrações CF7', 'post_type_general_name' ),
        'singular_name'         => _x( 'Integração CF7', 'post_type_singular_name' ),
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
        'menu_name'             => 'RD Station CF7'
    );
    $args = array(
        'labels'                => $labels,
        'description'           => 'Integração do Contact Form 7 com o RD Station',
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
    if (is_plugin_active('contact-form-7/wp-contact-form-7.php')) register_post_type( 'rdcf7_integrations', $args );
}

// Remove View Page
add_filter( 'post_row_actions', 'cf7_remove_row_actions', 10, 2 );
function cf7_remove_row_actions( $actions, $post ) {
    if( get_post_type() != 'rdcf7_integrations' ) return $actions;
    unset( $actions['view'] );
    unset( $actions['inline hide-if-no-js'] );
    return $actions;
}

// Change Publish Button Text
add_filter( 'gettext', 'rdcf7_change_publish_button', 10, 2 );
function rdcf7_change_publish_button( $translation, $text ) {
    if ( 'rdcf7_integrations' == get_post_type())
        if ( $text == 'Publish')
            return 'Integrar';
    return $translation;
}

// Change Default Placeholder Title
add_filter( 'enter_title_here', 'rdcf7_change_default_title' );
function rdcf7_change_default_title( $title ){
    $screen = get_current_screen();
    if ( 'rdcf7_integrations' == $screen->post_type )
        $title = 'Dê um nome para essa integração';
    return $title;
}

// Contact Form 7 Meta Boxes
add_action( 'add_meta_boxes', 'rdcf7_form_identifier_box' );
function rdcf7_form_identifier_box() {
    add_meta_box(
        'rdcf7_form_identifier_box',
        'Identificador',
        'rdcf7_form_identifier_box_content',
        'rdcf7_integrations',
        'normal'
    );
}

function rdcf7_form_identifier_box_content(){
    $identifier = get_post_meta(get_the_ID(), 'form_identifier', true);
    echo '<input type="text" name="form_identifier" value="'.$identifier.'">';
    echo '<span>Esse identificador irá lhe ajudar a saber o formulário de origem do lead.</span>';
}

add_action( 'save_post', 'rdcf7_form_identifier_box_save' );
function rdcf7_form_identifier_box_save( $post_id ) {
  $identifier = $_POST['form_identifier'];
  update_post_meta( $post_id, 'form_identifier', $identifier );
}

add_action( 'add_meta_boxes', 'rdcf7_token_rdstation_box' );
function rdcf7_token_rdstation_box() {
    add_meta_box(
        'rdcf7_token_rdstation_box',
        'Token RD Station',
        'rdcf7_token_rdstation_box_content',
        'rdcf7_integrations',
        'normal'
    );
}

function rdcf7_token_rdstation_box_content(){
    $token = get_post_meta(get_the_ID(), 'token_rdstation', true);
    echo '<input type="text" name="token_rdstation" size="32" value="'.$token.'">';
    echo '<span>Não sabe seu token? <a href="https://www.rdstation.com.br/integracoes" target="blank">Clique aqui</a></span>';
}

add_action( 'save_post', 'rdcf7_token_rdstation_box_save' );
function rdcf7_token_rdstation_box_save( $post_id ) {
  $token = $_POST['token_rdstation'];
  update_post_meta( $post_id, 'token_rdstation', $token );
}

add_action( 'add_meta_boxes', 'rdcf7_form_id_box' );
function rdcf7_form_id_box() {
    add_meta_box(
        'rdcf7_form_id_box',
        'Qual formulário você deseja integrar ao RD Station?',
        'rdcf7_form_id_box_content',
        'rdcf7_integrations',
        'normal'
    );
}

function rdcf7_form_id_box_content(){
    $form_id = get_post_meta(get_the_ID(), 'form_id', true);
    $args = array('post_type' => 'wpcf7_contact_form', 'posts_per_page' => 100);
    $cf7Forms = get_posts( $args );

    if ( !$cf7Forms ) :
        echo '<p>Não encontramos nenhum formulário cadastrado, entre no seu plugin de formulário de contato ou <a href="admin.php?page=wpcf7-new">clique aqui para criar um novo.</a></p>';
    else : ?>
        <select name="form_id">
            <option value=""></option>
                <?php
                foreach($cf7Forms as $cf7Form) {
                    echo "<option value=".$cf7Form->ID.selected( $form_id, $cf7Form->ID, false) .">".$cf7Form->post_title."</option>";
                }
                ?>
        </select>
    <?php
    endif;
}

add_action( 'save_post', 'rdcf7_form_id_box_save' );
function rdcf7_form_id_box_save( $post_id ) {
  $id = $_POST['form_id'];
  update_post_meta( $post_id, 'form_id', $id );
}
<?php
/**
 * Classe para integrar o Rd Station com o Plugin MailChimp For Wordpress 
 *
 * @author      Haarieh <suporte@haarieh.com>
 * @copyright   2015-2015 Haarieh
 * @version     v 0.1 28/02/2013
 * @link        http://haarieh.com 
 **/ 

//Classe para manipulação de arquivos
include('FileReader.php');

class RdMC4WP {

    /**
     * Função de inicialização, centraliza a definição de filtros/ações
     */    
    public static function init() {
        add_action('admin_menu', array('RdMC4WP','adminMenu'));
        add_action( 'mc4wp_form_success', 'rdmc4wp_form_success', 10, 3 );
    }

    /**
     * Função para criar o Menu de Configurações no WordPress
     */
    public static function adminMenu() {
        add_menu_page( 'RD Station MC4WP', 'RD Station MC4WP', 6, __FILE__, array("RdMC4WP","adminRdmc4wp") );
    }

    /** 
     * Função para tratar o TPL adminRdmc4wp.tpl.
     */
    public static function adminRdmc4wp() {
        
        $templateVars['{UPDATED}'] = "";
        $erro = null;
        
        //Executar operações definidas
        if (count($_POST) > 0){
            if ($_POST['submit'] == 'Integrar') {
                if (is_null($erro)) 
                    $erro = (strlen($_POST['rdmc4wp-identificador']) > 0) ? null : 'Insira o Identificador!';
                    $erro = (strlen($_POST['rdmc4wp-token']) > 0) ? null : 'Insira o Token!';
            
                if (is_null($erro)) {
                    update_option("rdmc4wp-identificador",$_POST['rdmc4wp-identificador']);
                    update_option("rdmc4wp-token",$_POST['rdmc4wp-token']);
                }

                $templateVars['{UPDATED}'] = '<div id="message" class="updated fade"><p><strong>';
                if (is_null($erro)) {
                    $templateVars['{UPDATED}'] .= "Dados atualizados!";             
                } else {
                    $templateVars['{UPDATED}'] .= $erro;                
                }
                $templateVars['{UPDATED}'] .= "</strong></p></div>";
            }   

            
        }

        $templateVars['{RDMC4WP-TOKEN}'] = get_option("rdmc4wp-token");       
        $templateVars['{RDMC4WP-IDENTIFICADOR}'] = get_option("rdmc4wp-identificador");           

        //Ler arquivo de template usando funções do WP
        $admTplObj = new FileReader(dirname(__FILE__)."/view/adminRdmc4wp.tpl");
        $admTpl = $admTplObj->read($admTplObj->_length);
        
        //Substituir variáveis no template      
        $admTpl = strtr($admTpl,$templateVars);
        echo $admTpl;       
    }

}

add_filter('init', array('RdMC4WP','init'));
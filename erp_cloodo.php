<?php
/**
 * Plugin Name:       CRM for WPForms
 * Plugin URI:        https://worksuite.cloodo.com/
 * Description:       Lead management for WPForms
 * Version:           1.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Cloodo
 * Author URI:        https://cloodo.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       crm-4-wpf
 * Domain Path:       /languages
 */

require "app/view/ercl_alert_message.php";
require "app/ercl_wpform/ercl_wpform.php";

define('ERCL_API',"https://erp.cloodo.com/api/v3/");


function ercl_add_admin_menu(){
    add_menu_page('CRM 4 WPForms', 'CRM 4 WPForms', 'manage_options','erp-cloodo','ercl_show_plugin', plugins_url('./admin/img/icons8-request-service-24.png', __FILE__  ), 3 );
    add_submenu_page('erp-cloodo', 'Setting','Setting','manage_options','erp-cloodo-setting','ercl_cloodo_show_setting');
}
function ercl_show_plugin (){
    if(get_option('cloodo_token')){
        wp_enqueue_style('style_erp.css',plugins_url('./admin/css/style.css', __FILE__ ));
        require "app/view/ercl_show_ifame.php";
        wp_enqueue_script( 'main.js',plugins_url('./admin/js/main.js', __FILE__  ));
        wp_add_inline_script('main.js', 'var ERCL_API = '.'"'.ERCL_API.'"' ,'after');
        wp_add_inline_script('main.js', 'var get_option_token = '.'"'.get_option('cloodo_token').'"' ,'after');
    }
    else{
        require_once __DIR__ . '/includes/dashboard.php';
    }
}


function ercl_cloodo_show_setting(){
    wp_enqueue_style('style_erp.css',plugins_url('./admin/css/style.css', __FILE__ ));
    require "app/ercl_wpform/ercl_show_seting.php";
}



add_action('admin_menu', 'ercl_add_admin_menu');

/* add core cloodo active */
require_once __DIR__ . '/includes/cloodo_core.php';

add_action('cloodo_page_content',function(){
    require __DIR__ . "/includes/dashboard.php";
  });
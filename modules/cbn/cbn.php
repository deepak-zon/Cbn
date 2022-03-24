<?php

/**
 * Ensures that the module init file can't be accessed directly, only within the application.
 */
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: CBN
Description: Create custom states, systems and franchises.
Version: 1.0.0
Author: Zonvoir
Author URI: https://zonvoir.com/
Requires at least: 2.3.*
*/

define('CBN_MODULE_NAME', 'cbn');


$CI = &get_instance();

/**
 * Load the module helper
 */
$CI->load->helper(CBN_MODULE_NAME . '/cbn');

register_language_files(CBN_MODULE_NAME, [CBN_MODULE_NAME]);


hooks()->add_action('admin_init', 'cbn_module_init_menu_items');
hooks()->add_action('admin_init', 'cbn_module_init_sidebar_menu_items');
hooks()->add_filter('staff_permissions', 'bulk_offline_payments_permissions', 10, 2);


/**
 * Register activation module hook
 */
register_activation_hook(CBN_MODULE_NAME, 'cbn_module_activation_hook');

function cbn_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

function cbn_module_init_menu_items()
{
    /**
     * If the logged in user is administrator, add custom menu in Setup
     */
    if (is_admin()) {
        $CI = &get_instance();
        $CI->app_menu->add_setup_menu_item('cbn-options', [
            'collapse' => true,
            'name'     => 'CBN SETTINGS',
            'position' => 60,
        ]);

        $CI->app_menu->add_setup_children_item('cbn-options', [
            'slug'     => 'main-menu-options',
            'name'     => _l('states'),
            'href'     => admin_url('cbn/states'),
            'position' => 5,
        ]);

        $CI->app_menu->add_setup_children_item('cbn-options', [
            'slug'     => 'setup-menu-options',
            'name'     => _l('systems'),
            'href'     => admin_url('cbn/systems'),
            'position' => 10,
        ]);

        $CI->app_menu->add_setup_children_item('cbn-options', [
            'slug'     => 'setup-menu-options',
            'name'     => _l('franchises'),
            'href'     => admin_url('cbn/franchises'),
            'position' => 10,
        ]);
    }
}

function cbn_module_init_sidebar_menu_items() {
    $CI = &get_instance();
    $CI->app_menu->add_sidebar_menu_item('cbn', [
        'collapse' => true,
        'name'     => 'CBN MODULE',
        'position' => 6,
        'icon'     => 'fa fa-star-o menu-icon',
    ]);
    
    $CI->app_menu->add_sidebar_children_item('cbn', [
        'slug'     => 'main-menu-options',
        'name'     => _l('bulk_offline_payments'),
        'href'     => admin_url('cbn/bulk_offline_payments'),
        'position' => 5,
    ]);
    
    $CI->app_menu->add_sidebar_children_item('cbn', [
        'slug'     => 'main-menu-options',
        'name'     => _l('auto_billing'),
        'href'     => admin_url('cbn/auto_billing'),
        'position' => 5,
    ]);
    
    $CI->app_menu->add_sidebar_children_item('cbn', [
        'slug'     => 'main-menu-options',
        'name'     => _l('invoice_downloader'),
        'href'     => admin_url('cbn/invoice_downloader'),
        'position' => 5,
    ]);
    
    $CI->app_menu->add_sidebar_children_item('cbn', [
        'slug'     => 'main-menu-options',
        'name'     => _l('upload_reports'),
        'href'     => admin_url('cbn/upload_reports'),
        'position' => 5,
    ]);
    
    $CI->app_menu->add_sidebar_children_item('cbn', [
        'slug'     => 'main-menu-options',
        'name'     => _l('credit_notes'),
        'href'     => admin_url('cbn/credit_notes'),
        'position' => 5,
    ]);
    
    $CI->app_menu->add_sidebar_children_item('cbn', [
        'slug'     => 'main-menu-options',
        'name'     => _l('items'),
        'href'     => admin_url('cbn/items'),
        'position' => 5,
    ]);
    
    $CI->app_menu->add_sidebar_children_item('cbn', [
        'slug'     => 'main-menu-options',
        'name'     => _l('subscriptions'),
        'href'     => admin_url('cbn/subscriptions'),
        'position' => 5,
        'icon'     => 'fa fa-refresh',
    ]);
}

function bulk_offline_payments_permissions($corePermissions, $data){

   $corePermissions['bulk_offline_payments'] = [
            'name'         => _l('bulk_offline_payments'),
            'capabilities' => [
                'view'   => _l('view'),
                'create' => _l('permission_create'),
            ],
        ];
    return $corePermissions;   
}

<?php
/**
 * Plugin Name: Cascading Mega Menu for Elementor
 * Description: Unlimited-level cascading mega menu with full Elementor widget support.
 * Author: Terence Bentem
 * Version: 3.02
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'elementor/widgets/register', function( $manager ) {
    require_once __DIR__ . '/widgets/mega-menu.php';

    $manager->register( new CMM_Mega_Menu() );

});

add_action( 'wp_enqueue_scripts', function() {

    wp_register_style(
        'cmm-style',
        plugins_url( 'assets/mega.css', __FILE__ ),
        [],
        '3.02'
    );

    wp_register_script(
        'cmm-script',
        plugins_url( 'assets/mega.js', __FILE__ ),
        [],
        '3.02',
        true
    );

});

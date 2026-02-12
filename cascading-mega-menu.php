<?php
/**
 * Plugin Name:       Cascading Mega Menu for Elementor
 * Plugin URI:        https://example.com/cascading-mega-menu
 * Description:       Unlimited-level cascading mega menu with full Elementor widget support.
 * Version:           3.02
 * Author:            Terence Bentem
 * Author URI:        https://example.com
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       cascading-mega-menu
 * Requires at least: 5.0
 * Requires PHP:      7.4
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

<?php
/**
 * Plugin Name: Web Ok Honeypot Lite for CF7
 * Plugin URI:  https://github.com/samuelkobe/Web-Ok-Honeypot-Lite-for-CF7
 * Description: Lightweight honeypot spam protection for Contact Form 7. Drop-in replacement for bloated alternatives — zero config, just add [honeypot] to your form.
 * Version:     1.0.0
 * Requires at least: 6.2
 * Requires PHP: 7.4
 * Requires Plugins: contact-form-7
 * Author:      Web Ok Solutions Inc.
 * Author URI:  https://webok.ca/
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: web-ok-honeypot-lite-for-cf7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CF7_HONEYPOT_LITE_VERSION', '1.0.0' );
define( 'CF7_HONEYPOT_LITE_PATH', plugin_dir_path( __FILE__ ) );
define( 'CF7_HONEYPOT_LITE_URL', plugin_dir_url( __FILE__ ) );

// Register the [honeypot] form tag.
add_action( 'wpcf7_init', function () {
	require_once CF7_HONEYPOT_LITE_PATH . 'includes/form-tag.php';
} );

// Spam detection via the honeypot field.
add_filter( 'wpcf7_spam', function ( $spam, $submission ) {
	require_once CF7_HONEYPOT_LITE_PATH . 'includes/spam-check.php';
	return cf7hl_check_spam( $spam, $submission );
}, 10, 2 );

// Silent success — make bots think their submission went through.
add_filter( 'wpcf7_feedback_response', function ( $response, $result ) {
	require_once CF7_HONEYPOT_LITE_PATH . 'includes/spam-check.php';
	return cf7hl_maybe_fake_success( $response, $result );
}, 10, 2 );

// Tag generator button in CF7 form editor (admin only).
if ( is_admin() ) {
	add_action( 'wpcf7_admin_init', function () {
		require_once CF7_HONEYPOT_LITE_PATH . 'includes/tag-generator.php';
	} );
}

// Enqueue the hiding CSS when CF7 scripts load.
add_action( 'wpcf7_enqueue_scripts', function () {
	wp_enqueue_style(
		'web-ok-honeypot-lite-for-cf7',
		CF7_HONEYPOT_LITE_URL . 'assets/css/honeypot.css',
		[],
		CF7_HONEYPOT_LITE_VERSION
	);
} );

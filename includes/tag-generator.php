<?php
/**
 * Tag generator for the CF7 form editor toolbar.
 *
 * Adds a "honeypot" button that lets users insert [honeypot] tags
 * without typing the shortcode manually.
 *
 * @package CF7_Honeypot_Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tag_generator = WPCF7_TagGenerator::get_instance();

$tag_generator->add(
	'honeypot',
	__( 'honeypot', 'cf7-honeypot-lite' ),
	'cf7hl_tag_generator_honeypot',
	[ 'version' => '2' ]
);

/**
 * Render the tag generator dialog content.
 *
 * @param WPCF7_ContactForm $contact_form The contact form.
 * @param array             $options      Generator options.
 */
function cf7hl_tag_generator_honeypot( $contact_form, $options ) {
	$tgg = new WPCF7_TagGeneratorGenerator( $options['content'] );

	$formatter = new WPCF7_HTMLFormatter();

	$formatter->append_start_tag( 'header', [
		'class' => 'description-box',
	] );

	$formatter->append_start_tag( 'h3' );
	$formatter->append_preformatted(
		esc_html__( 'Honeypot field form-tag generator', 'cf7-honeypot-lite' )
	);
	$formatter->end_tag( 'h3' );

	$formatter->append_start_tag( 'p' );
	$formatter->append_preformatted(
		esc_html__(
			'Generates a hidden honeypot field that catches spam bots. The field is invisible to real users but gets filled in by bots, flagging the submission as spam.',
			'cf7-honeypot-lite'
		)
	);
	$formatter->end_tag( 'header' );

	$formatter->append_start_tag( 'div', [
		'class' => 'control-box',
	] );

	$formatter->call_user_func( static function () use ( $tgg ) {
		$tgg->print( 'field_type', [
			'select_options' => [
				'honeypot' => __( 'Honeypot field', 'cf7-honeypot-lite' ),
			],
		] );

		$tgg->print( 'field_name' );
	} );

	$formatter->end_tag( 'div' );

	$formatter->append_start_tag( 'footer', [
		'class' => 'insert-box',
	] );

	$formatter->call_user_func( static function () use ( $tgg ) {
		$tgg->print( 'insert_box_content' );
	} );

	$formatter->print();
}

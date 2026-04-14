<?php
/**
 * Register the [honeypot] form tag for Contact Form 7.
 *
 * @package Web_Ok_Honeypot_Lite_For_CF7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wpcf7_add_form_tag(
	'honeypot',
	'cf7hl_form_tag_handler',
	[
		'name-attr'      => true,
		'display-hidden' => true,
	]
);

/**
 * Render the honeypot field HTML.
 *
 * @param WPCF7_FormTag $tag The form tag object.
 * @return string HTML output.
 */
function cf7hl_form_tag_handler( $tag ) {
	if ( empty( $tag->name ) ) {
		return '';
	}

	$atts = [
		'type'         => 'text',
		'name'         => $tag->name,
		'value'        => '',
		'class'        => 'cf7-honeypot-field',
		'autocomplete' => 'off',
		'tabindex'     => '-1',
	];

	$id = $tag->get_id_option();
	if ( $id ) {
		$atts['id'] = $id;
	}

	$html = sprintf(
		'<span class="wpcf7-form-control-wrap cf7-honeypot-wrap" data-name="%s"><input %s /></span>',
		esc_attr( $tag->name ),
		wpcf7_format_atts( $atts )
	);

	return $html;
}

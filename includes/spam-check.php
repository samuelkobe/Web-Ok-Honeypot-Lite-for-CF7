<?php
/**
 * Spam detection — check if any honeypot field was filled.
 *
 * @package Web_Ok_Honeypot_Lite_For_CF7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check honeypot fields and flag as spam if any are filled.
 *
 * Hooked to `wpcf7_spam` filter.
 *
 * @param bool              $spam       Current spam status.
 * @param WPCF7_Submission  $submission The submission instance.
 * @return bool
 */
function cf7hl_check_spam( $spam, $submission ) {
	if ( $spam ) {
		return $spam; // Already flagged by something else.
	}

	$contact_form = $submission->get_contact_form();
	if ( ! $contact_form ) {
		return $spam;
	}

	$tags = $contact_form->scan_form_tags( [ 'type' => 'honeypot' ] );

	foreach ( $tags as $tag ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce verified upstream by CF7 before this filter runs.
		$value = isset( $_POST[ $tag->name ] ) ? sanitize_text_field( wp_unslash( $_POST[ $tag->name ] ) ) : '';

		if ( '' !== $value ) {
			$submission->add_spam_log( [
				'agent'  => 'web-ok-honeypot-lite-for-cf7',
				'reason' => sprintf(
					'Honeypot field "%s" was filled.',
					$tag->name
				),
			] );
			return true;
		}
	}

	return $spam;
}

/**
 * Override the spam response so bots see a fake success message.
 *
 * Hooked to `wpcf7_feedback_response` filter.
 *
 * @param array  $response The response array sent to the browser.
 * @param string $result   The submission result status.
 * @return array
 */
function cf7hl_maybe_fake_success( $response, $result ) {
	if ( empty( $result['status'] ) || 'spam' !== $result['status'] ) {
		return $response;
	}

	$submission = WPCF7_Submission::get_instance();
	if ( ! $submission ) {
		return $response;
	}

	// Only fake success if our plugin flagged the spam.
	$spam_log = $submission->get_spam_log();
	$our_catch = false;

	foreach ( $spam_log as $entry ) {
		if ( isset( $entry['agent'] ) && 'web-ok-honeypot-lite-for-cf7' === $entry['agent'] ) {
			$our_catch = true;
			break;
		}
	}

	if ( ! $our_catch ) {
		return $response;
	}

	$contact_form = $submission->get_contact_form();

	$response['status']  = 'mail_sent';
	$response['message'] = $contact_form
		? $contact_form->message( 'mail_sent_ok' )
		: __( 'Thank you for your message. It has been sent.', 'web-ok-honeypot-lite-for-cf7' );

	return $response;
}

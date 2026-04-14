<?php
/**
 * Spam detection — check if any honeypot field was filled.
 *
 * @package CF7_Honeypot_Lite
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
		$value = isset( $_POST[ $tag->name ] ) ? $_POST[ $tag->name ] : '';

		if ( '' !== $value ) {
			$submission->add_spam_log( [
				'agent'  => 'cf7-honeypot-lite',
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
		if ( isset( $entry['agent'] ) && 'cf7-honeypot-lite' === $entry['agent'] ) {
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
		: __( 'Thank you for your message. It has been sent.', 'cf7-honeypot-lite' );

	return $response;
}

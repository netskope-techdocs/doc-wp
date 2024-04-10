<?php
namespace eazyDocsPro\Frontend\Assistant;

class Mailer {
	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'feedback_mail' ] );
	}

	function feedback_mail() {

		$admin_email = ezd_get_opt('assistant_tab_settings');
		$admin_email = $admin_email['assistant_contact_mail'] ?? get_option( 'admin_email' );

		if ( isset( $_POST['eazydocs_assistant_submit'] ) ) {
			$author  = ! empty( $_POST['eazydocs_assistant_name'] ) ? sanitize_text_field( $_POST['eazydocs_assistant_name'] ) : '';
			$subject = ! empty( $_POST['eazydocs_assistant_subject'] ) ? sanitize_text_field( $_POST['eazydocs_assistant_subject'] ) : '';
			$email   = ! empty( $_POST['eazydocs_assistant_email'] ) ? sanitize_email( $_POST['eazydocs_assistant_email'] ) : '';
			$message = ! empty( $_POST['eazydocs_assistant_comment'] ) ? sanitize_text_field( $_POST['eazydocs_assistant_comment'] ) : '';

			if ( ! is_user_logged_in() ) {
				$email = ! empty( $_POST['eazydocs_assistant_email'] ) ? sanitize_email( $_POST['eazydocs_assistant_email'] ) : '';

				if ( ! $email ) {
					wp_send_json_error( __( 'Please enter a valid email address.', 'eazydocs-pro' ) );
				}
			} else {
				$email = wp_get_current_user()->user_email;
			}

			if ( empty( $subject ) ) {
				wp_send_json_error( __( 'Please provide a subject line.', 'eazydocs-pro' ) );
			}

			if ( empty( $message ) ) {
				wp_send_json_error( __( 'Please provide the message details.', 'eazydocs-pro' ) );
			}

			$wp_email = 'wordpress@' . preg_replace( '#^www\.#', '', strtolower( $_SERVER['SERVER_NAME'] ) );
			$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

			$email_to = $admin_email;
			$subject  = sprintf( __( '[%1$s] New EazyDocs Pro Query: "%2$s"', 'eazydocs-pro' ), $blogname, $subject );

			$email_body = sprintf( __( 'New Message From EazyDocs Pro Assistant. Source: %s', 'eazydocs-pro' ), $wp_email ) . "\r\n";
			$email_body .= sprintf( __( 'From: %s', 'eazydocs-pro' ), $email ) . "\r\n";
			$email_body .= sprintf( __( 'Message: %s', 'eazydocs-pro' ), "\r\n" . $message ) . "\r\n\r\n";

			$from     = "From: \"${author}\" <${wp_email}>";
			$reply_to = "Reply-To: \"${email}\" <${email}>";

			$message_headers = "${from}\n" . 'Content-Type: text/plain; charset ="' . get_option( 'blog_charset' ) . "\"\n";
			$message_headers .= $reply_to . "\n";

			wp_mail( $email_to, wp_specialchars_decode( $subject ), $email_body, $message_headers );
		}
	}
}
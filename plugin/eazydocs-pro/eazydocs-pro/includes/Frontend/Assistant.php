<?php

namespace eazyDocsPro\Frontend;

class Assistant {

	public function __construct() {
		add_action( 'eazydocs_assistant', [ $this, 'render_assistant' ] );
		$this->contact_support();
	}

	public function contact_support() {
		new Assistant\Mailer();
	}

	public function render_assistant() {
		$ed_options                 = get_option( 'eazydocs_settings' ); // prefix of framework
		$assistant_visibility       = $ed_options['assistant_visibility'] ?? '1';

		if ( $assistant_visibility  == '1' ) :
			$open_icon_url          = ! empty ( $ed_options['assistant_open_icon']['url'] ) ? $ed_options['assistant_open_icon']['url'] : EAZYDOCSPRO_ASSETS . '/images/frontend/chat.svg';;
			$close_icon_url         = ! empty ( $ed_options['assistant_close_icon']['url'] ) ? $ed_options['assistant_close_icon']['url'] : EAZYDOCSPRO_ASSETS . '/images/frontend/close.svg';;

			$kb_visibility          = $ed_options['assistant_tab_settings']['kb_visibility'] ?? '1';
			$kb_search              = $ed_options['assistant_tab_settings']['assistant_search'] ?? '1';
			$kb_breadcrumb          = $ed_options['assistant_tab_settings']['assistant_breadcrumb'] ?? '1';

			$kb_heading             = $ed_options['assistant_tab_settings']['kb_label'] ?? __( 'Knowledge Base', 'eazydocs-pro' );
			$docs_not_found         = $ed_options['assistant_tab_settings']['docs_not_found'] ?? __( 'No Posts Found', 'eazydocs-pro' );
			$kb_search_placeholder  = $ed_options['assistant_tab_settings']['kb_search_placeholder'] ?? __( 'Search..', 'eazydocs-pro' );

			$kb_contact             = $ed_options['assistant_tab_settings']['contact_visibility'] ?? '1';
			$contact_heading        = $ed_options['assistant_tab_settings']['contact_label'] ?? __( 'Contact', 'eazydocs-pro' );

			$head_spacing           = ! empty ( $kb_visibility != '1' || $kb_contact != '1' ) ? 'chatbox-header-top-padding' : '';

			$kb_block               = ! empty ( $kb_contact != '1' ) ? 'kb-body-block' : '';
			$contact_block          = ! empty ( $kb_visibility != '1' ) ? 'contact-body-block' : '';
			$no_kb_search           = ! empty ( $kb_search != '1' ) ? 'kb-body-no-search' : '';
			$kb_body_height         = ! empty ( $kb_contact == '1' && $kb_visibility == '1' ) ? 'kb-body-height' : '';

            // CONTACT INPUT
			$contact_fullname       = $ed_options['assistant_tab_settings']['contact_fullname'] ?? __( 'Full Name', 'eazydocs-pro' );
			$contact_mail           = $ed_options['assistant_tab_settings']['contact_mail'] ?? 'name@example.com';
			$contact_subject        = $ed_options['assistant_tab_settings']['contact_subject'] ?? __( 'Subject', 'eazydocs-pro' );
			$contact_message        = $ed_options['assistant_tab_settings']['contact_message'] ?? __( 'Write Your Message', 'eazydocs-pro' );
			$contact_submit         = $ed_options['assistant_tab_settings']['contact_submit'] ?? __( 'Send Message', 'eazydocs-pro' );

			if ( $kb_visibility == '1' || $kb_contact == '1' ) :

            $kb_visibility_by = $ed_options['assistant_visibility_by'] ?? '';
            
            switch ( $kb_visibility_by ) {
                case 'pages':

                    $assistant_pages = $ed_options['assistant_pages'] ?? '';
                   
                    if ( is_array( $assistant_pages ) && ! empty( $assistant_pages ) ) {                        
                        if ( ! in_array(get_the_ID(), $assistant_pages ) ) {
                            return true;
                        }
                    } else {
                        return false;
                    }
                    break;

                case 'post_type':    
                    $assistant_post_types = $ed_options['assistant_post_types'] ?? '';    
                    if ( is_array( $assistant_post_types ) && ! empty( $assistant_post_types ) ) {        
                        if ( ! in_array(get_post_type(get_the_ID()), $assistant_post_types ) ) {
                            return true;
                        }
                    } else {
                        return false;
                    }
                    break;   
                        
                case 'global':
                    break;
            }  
                 
            ?>
            <div class="eazydocs-assistant-wrapper">
                <div class="chatbox-wrapper <?php echo esc_attr( $kb_body_height ); ?>">
                    <div class="chatbox-header <?php echo esc_attr( $head_spacing ); ?>">
                        <?php if ( $kb_visibility == '1' && $kb_contact == '1' ) : ?>
                        <div class="chatbox-tab">
                            <?php if ( $kb_visibility == '1' ) : ?>
                            <a href="#" tab-link="kbase" class="chatbox-kbase active">
                                <?php echo esc_html( $kb_heading ); ?>
                            </a>
                            <?php endif;

                                                if ( $kb_contact == '1' ) : ?>
                            <a href="#" tab-link="contact" class="chatbox-contact">
                                <?php echo esc_html( $contact_heading ); ?>
                            </a>
                            <?php endif; ?>
                        </div>
                        <?php endif;

                                        if ( $kb_visibility == '1' && $kb_search == '1' ) : ?>
                        <div class="search-box">
                            <form action="#">
                                <input type="search" name="s" id="wp-spotlight-chat-search"
                                    placeholder="<?php echo esc_attr( $kb_search_placeholder ); ?>">
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="chatbox-body">
                        <?php if ( $kb_visibility == '1' ) : ?>
                        <div id="chatbox-search-results">
                            <div class="chatbox-posts <?php echo esc_attr( $kb_block . ' ' . $no_kb_search ); ?>" tab-data="post">
                                <?php
                                                    $query = new \WP_Query( [
                                                        'post_type'      => 'docs',
                                                        'posts_per_page' => 12,
                                                        'order'          => 'random',
                                                    ]);
                                                    if ( $query->have_posts() ):
                                                        while ( $query->have_posts() ):
                                                            $query->the_post();
                                                            ?>
                                <div class="post-item">
                                    <?php if ( $kb_breadcrumb == '1' ) : ?>
                                    <nav aria-label="breadcrumb">
                                        <?php eazydocs_breadcrumbs(); ?>
                                    </nav>
                                    <?php endif; ?>
                                    <h2><a href="<?php echo get_the_permalink( get_the_ID() ); ?>"><?php the_title(); ?></a></h2>
                                    <p><?php ezd_limit_letter( get_the_excerpt(), 80 ); ?></p>
                                </div>
                                <?php
                                                        endwhile;
                                                        wp_reset_postdata();
                                                    else: ?>
                                <div class="docs-not-found">
                                    <?php echo esc_html( $docs_not_found ); ?>
                                </div>
                                <?php
                                                    endif;
                                                    ?>
                            </div>
                        </div>
                        <?php
                                        endif;

                                        if ( $kb_contact == '1' ) : ?>
                        <div class="chatbox-form <?php echo esc_attr( $contact_block ); ?>" tab-data="contact">
                            <div class="chatbox-form-wrapper">
                                <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8');
            ; ?>" method="post" class="chatbox-form">
                                    <input type="text" name="eazydocs_assistant_name" id="chatc-name"
                                        placeholder="<?php echo esc_attr($contact_fullname); ?>" required>
                                    <input type="email" name="eazydocs_assistant_email" id="chatc-email"
                                        placeholder="<?php echo esc_attr($contact_mail); ?>" required>
                                    <input type="text" name="eazydocs_assistant_subject" id="chatc-subject"
                                        placeholder="<?php echo esc_attr($contact_subject); ?>" required>
                                    <textarea name="eazydocs_assistant_comment" cols="30" rows="8"
                                        placeholder="<?php echo esc_attr($contact_message); ?>"></textarea>
                                    <input type="submit" name="eazydocs_assistant_submit"
                                        value="<?php echo esc_attr($contact_submit); ?>">
                                </form>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="chat-toggle">
                    <a href="#">
                        <img class="wp-spotlight-chat" src="<?php echo esc_url( $open_icon_url ); ?>"
                            alt="<?php esc_attr_e( 'Chat Icon', 'eazydocs-pro' ) ?>">
                        <img class="wp-spotlight-hide" src="<?php echo esc_url( $close_icon_url ); ?>"
                            alt="<?php esc_attr_e( 'Close Icon', 'eazydocs-pro' ) ?>">
                    </a>
                </div>
            </div>
            <?php
			endif;
		endif;
	}
}
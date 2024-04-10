<?php
namespace EazyDocsPro\Frontend;

/**
* Class Frontend_Actions
 * @package EazyDocsPro\Frontend
 */
class Frontend_Actions {
	function __construct(){
		add_filter( 'before_docs_column_wrapper', [ $this, 'before_docs_column' ] );
		add_action( 'eazydocs_masonry_wrap', [ $this, 'eazydocs_masonry_wrap' ], 99, 2 );
		add_action( 'eazydocs_fronted_submission', [ $this, 'eazydocs_fronted_submission' ], 99, 2 );
		add_action( 'eazydocs_fronted_editing', [ $this, 'eazydocs_fronted_editing' ] );
		add_action( 'eazydocs_docs_contributor', [ $this, 'eazydocs_docs_contributor' ] );
	}
        
	/**
     * Docs archive page column
	 *
	 * @param $col
	*/
	public function before_docs_column($col){ ?>
        <div class="ezd-lg-col-<?php echo $col; ?> ezd-grid-column-full">
    <?php }

	/**
	 * Masonry wrapper for docs column
	*/
	public function eazydocs_masonry_wrap($masonry = '', $col = ''){
	    if ( $masonry == 'masonry'){
         echo 'ezd-massonry-col='.$col;
        }
    }
    
    /**
     *  Doc Frontend Editing
     */
    public function eazydocs_fronted_editing($edit_id){
        $frontend_edit          = ezd_get_opt('frontend_edit_switcher') ?? '';
        $doc_edit_btn_text      = ezd_get_opt('frontend_edit_btn_text') ?? esc_html__('Edit', 'eazydocs-pro');

        if ( $frontend_edit == 1 ) {

            if ( is_user_logged_in() ) {
                $edit_doc_url = get_edit_post_link($edit_id) .'&ezd_edit_doc=yes';
            } else {                
                $add_user_page_id = ezd_get_opt( 'docs_frontend_login_page' );
                $add_user_page_id = get_permalink( $add_user_page_id );

                $edit_doc_url =  $add_user_page_id . '?ezd_edit_doc=yes';
            }
            
            echo '<a href="'.$edit_doc_url.'&post_id='.$edit_id.'&_wpnonce='.wp_create_nonce($edit_id).'" class="secondary-btn"><i class="icon_pencil-edit"></i> '. $doc_edit_btn_text. '</a>';
        }
    }

    /**
     *  Doc Frontend submission
     */
    public function eazydocs_fronted_submission( $doc_id, $order ){
        $frontend_add           = ezd_get_opt('frontend_add_switcher') ?? '';
        $doc_add_btn_text       = ezd_get_opt('frontend_add_btn_text') ?? esc_html__('Add Doc', 'eazydocs-pro');

        if ( $frontend_add == 1 ) {

            if ( is_user_logged_in() ) {
                $new_doc_url = admin_url('/post-new.php?post_type=docs&add_new_doc=yes').'&ezd_doc_parent='.$doc_id.'&ezd_doc_order='.$order;
            } else {                
                $add_user_page_id = ezd_get_opt( 'docs_frontend_login_page' );
                $add_user_page_id = get_permalink( $add_user_page_id );

                $new_doc_url =  $add_user_page_id . '?add_new_doc=yes';
            }
            echo '<a href="'.$new_doc_url.'&post_id='.$doc_id.'&_wpnonce='.wp_create_nonce($doc_id).'" class="add"><i class="icon_plus_alt2"></i> '. $doc_add_btn_text. '</a>';
        }
    }

    /**
     * Doc Contributors
     * @param $doc_id
    */
    public function eazydocs_docs_contributor($doc_id){

        $options                        = get_option( 'eazydocs_settings' );
        $contributor_visibility         = $options['is_doc_contribution'] ?? '';
        $contributor_meta_title         = ! empty( $options['contributor_meta_title'] ) ? $options['contributor_meta_title'] : __( 'Contributors', 'eazydocs' );
        $meta_dropdown_title            = ! empty( $options['contributor_meta_dropdown_title'] ) ? $options['contributor_meta_dropdown_title'] : __( 'Manage Contributors', 'eazydocs' );
        $contributor_meta_search        = ! empty( $options['contributor_meta_search'] ) ? $options['contributor_meta_search'] : '';
        $contributor_meta_visibility    = $options['contributor_meta_visibility'] ?? '';
 
        if ( ezd_is_promax() ) :
            if( ! empty( $contributor_visibility ) ) :
                ?>
                <span class="views sep contributed_users">
                    <span class="ezdoc_contributed_user_avatar">
                        <span class="contributed_user_list">
                            <?php
                            echo esc_html( $contributor_meta_title );
                            do_action('ezd_doc_contributor', $doc_id);
                            
                            $current_doc_author         = get_the_author_meta( 'ID' );
                            $ezd_doc_contributor_list   = get_post_meta($doc_id, 'ezd_doc_contributors', true);
                            $ezd_doc_contributors       = rtrim($ezd_doc_contributor_list, ',');
                            $ezd_doc_contributors       = explode(',', $ezd_doc_contributors);
                            $ezd_doc_contributors       = array_unique($ezd_doc_contributors);
                            ?>
                            <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" title="<?php echo get_the_author_meta('display_name') ?? ''; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom">
                                <?php echo get_avatar( get_the_author_meta('ID'), '24' ); ?>
                            </a>

                            <?php
                            foreach ( $ezd_doc_contributors as $ezd_doc_contributor ) :
                                $available_user = get_user_by('id', $ezd_doc_contributor);
                                if ( ! empty($available_user->user_login) && empty($available_user->ID == $current_doc_author) ) :
                                    ?>
                                    <a href="<?php echo get_author_posts_url($ezd_doc_contributor); ?>" title="<?php echo $available_user->display_name ?? ''; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom">
                                        <?php echo get_avatar($available_user, '24'); ?>
                                    </a>
                                    <?php
                                endif;
                            endforeach;
                            echo '</span>';

                            if ( current_user_can('install_plugins') ) :
                                ?>
                                <div class="ezdoc_contributed_users">
                                    <i class="arrow_carrot-down"></i>
                                    <div class="doc_users_dropdown ezd-shadow-lg">
                                        <h5 class="title"> <?php echo esc_html( $meta_dropdown_title ); ?> </h5>
                                        
                                        <?php
                                        if ( $contributor_meta_search == 1 ) :
                                            ?>
                                            <form action="#" method="POST">
                                                <input type="text" name="ezd_contributor_search" id="ezd-contributor-search" placeholder="<?php esc_attr_e( 'Search By Email or Name', 'eazydocs' ); ?>">
                                            </form>
                                            <?php 
                                        endif;
                                        ?>

                                        <div class="doc_dropdown_users_list" id="added_contributors">
                                            <?php $available_user = get_user_by('id', $current_doc_author); ?>
                                            <ul class="users_wrap_item <?php echo esc_attr('user-'.$current_doc_author); ?>" id="<?php echo esc_attr('user-'.$current_doc_author); ?>">
                                                <li>
                                                    <a href='<?php echo get_author_posts_url($current_doc_author); ?>'>
                                                        <?php echo get_avatar($available_user, '35'); ?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href='<?php echo get_author_posts_url($current_doc_author); ?>'>
                                                        <?php echo $available_user->display_name ?? ''; ?>
                                                    </a>
                                                    <span> <?php echo $available_user->user_email ?? ''; ?> </span>
                                                </li>
                                                <li></li>
                                            </ul>

                                            <?php
                                            foreach ( $ezd_doc_contributors as $ezd_doc_contributor ) :
                                                $available_user = get_user_by('id', $ezd_doc_contributor);
                                                if ( ! empty( $available_user->user_login) && empty($available_user->ID == $current_doc_author ) ) :
                                                    ?>
                                                    <ul class="users_wrap_item <?php echo esc_attr('user-'.$ezd_doc_contributor); ?>"
                                                        id="<?php echo esc_attr('user-'.$ezd_doc_contributor); ?>">
                                                        <li>
                                                            <a href='<?php echo get_author_posts_url($ezd_doc_contributor); ?>'>
                                                                <?php echo get_avatar($ezd_doc_contributor, '35'); ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href='<?php echo get_author_posts_url($ezd_doc_contributor); ?>'>
                                                                <?php echo $available_user->display_name ?? ''; ?>
                                                            </a>
                                                            <span> <?php echo $available_user->user_email ?? ''; ?> </span>
                                                        </li>
                                                        <li>
                                                            <a data_name="<?php echo $available_user->display_name ?? ''; ?>" class="test circle-btn ezd_contribute_delete" data-contributor-delete="<?php echo esc_attr($ezd_doc_contributor); ?>" data-doc-id="<?php echo esc_attr($doc_id); ?>">
                                                                &times;
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <?php
                                                endif;
                                            endforeach;
                                            ?>
                                        </div>

                                        <div class="doc_dropdown_users_list" id="to_add_contributors" data-page="1">
                                            <?php
                                            $current_doc_author     = get_the_author_meta( 'ID' );
                                            $ezd_exclude_users      = get_post_meta($doc_id, 'ezd_doc_contributors', true);
                                            $ezd_exclude_users      = rtrim($ezd_exclude_users, ',');
                                            $ezd_exclude_users      = $current_doc_author.','.$ezd_exclude_users;
                                            $all_users              = get_users(['exclude'  => $ezd_exclude_users]);

                                            // set pagination on scroll
                                            if ( ezd_get_opt('contributor_load_more') == '1' ) {
                                                $users_to_add = ezd_get_opt('contributor_load_per_scroll', 3);
                                            } else {
                                                $users_to_add = ezd_get_opt('contributor_to_add', 3);
                                            }

                                            $page                   = 1;
                                            $total_users            = count($all_users);
                                            $users_per_page         = $users_to_add;
                                            $total_pages            = ceil($total_users / $users_per_page);
                                            $offset                 = ($page - 1) * $users_per_page;
                                            $all_users              = array_slice($all_users, $offset, $users_per_page);
                                            $to_add_users           = [];

                                            foreach( $all_users as $add_contributor ) :
                                                $available_user     = get_user_by( 'id', $add_contributor );
                                                $to_add_users[]     = $add_contributor->ID;
                                                ?>
                                                <ul class="users_wrap_item <?php echo esc_attr('to-add-user-'.$add_contributor->ID); ?>"
                                                    id="<?php echo esc_attr('to-add-user-'.$add_contributor->ID); ?>">
                                                    <li>
                                                        <a data_name="<?php echo get_the_author_meta( 'display_name', $add_contributor->ID ); ?>" href='<?php echo get_author_posts_url($add_contributor->ID); ?>'>
                                                            <?php echo get_avatar($add_contributor, '35'); ?>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href='<?php echo get_author_posts_url($add_contributor->ID); ?>'>
                                                            <?php echo get_the_author_meta( 'display_name', $add_contributor->ID ); ?>
                                                        </a>
                                                        <span> <?php echo get_the_author_meta( 'user_email', $add_contributor->ID ); ?> </span>
                                                    </li>
                                                    <li>
                                                        <a data_name="<?php echo get_the_author_meta( 'display_name', $add_contributor->ID ); ?>" class="circle-btn ezd_contribute_add"
                                                            data-contributor-add="<?php echo esc_attr($add_contributor->ID); ?>" data-doc-id="<?php echo esc_attr($doc_id); ?>">
                                                            &plus;
                                                        </a>
                                                    </li>
                                                </ul>
                                                <?php 
                                            endforeach;
                                            ?>
                                        </div>
                                        <div class="loading-info" style="display: none;">
                                            <span> <?php echo esc_html__( 'Loading...', 'eazydocs' ); ?> </span>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                endif;
                            ?>
                        </span>
                    </span>
                    <?php
                    endif;
                endif;
                
                if ( ezd_is_promax() && ezd_get_opt('contributor_load_more') == 1 && ! empty ( $all_users ) ) :
                    if ( ! empty( $contributor_visibility ) ) :

                    $cleaned_string = preg_replace('/,+/', ',', $ezd_exclude_users);
                    $cleaned_string = trim($cleaned_string, ','); // Remove leading and trailing commas

                    $exploded_array = explode(',', $cleaned_string);
                    $unique_array   = array_unique($exploded_array);
                    $updated_string = implode(',', $unique_array);
                    
                    $updated_array  = explode(',', $updated_string);
                    $merged_array   = array_merge($to_add_users, $updated_array);
                    $merged_users   = implode(',', $merged_array);    
                    ?>  

                    <script type="text/javascript">
                    ;(function($) {
                        $(document).ready(function() {

                        // Contributor [ Delete ] 
                        function ezd_contribute_delete() {
                            $('.ezd_contribute_delete').click(function(e) {
                                e.preventDefault();

                                let contributor_id = $(this).attr('data-contributor-delete');
                                let data_doc_id = $(this).attr('data-doc-id');
                                let user_name = $(this).attr('data_name');

                                $.ajax({
                                    url: eazydocs_ajax_search.ajax_url,
                                    method: 'POST',
                                    data: {
                                        action: 'ezd_doc_contributor',
                                        contributor_delete: contributor_id,
                                        data_doc_id: data_doc_id
                                    },
                                    beforeSend: function() {
                                        $('.ezd_contribute_delete[data-contributor-delete=' +
                                            contributor_id + ']').html(
                                            '<span class="spinner-border ezd-contributor-loader"><span class="visually-hidden">Loading...</span></span>'
                                        )
                                    },
                                    success: function(response) {
                                        $('#to_add_contributors').append(response)
                                        $('#user-' + contributor_id).remove();
                                        $('.to-add-user-' + contributor_id).not(':last').remove();

                                        $('.ezdoc_contributed_user_avatar a[data-bs-original-title="' +
                                            user_name + '"]').remove();
                                        ezd_contributor_add();
                                    },
                                    error: function() {
                                        console.log('Oops! Something wrong, try again!')
                                    }
                                });
                            });
                        }

                        // Contributor [ Add ] 
                        function ezd_contributor_add() {
                            $('.ezd_contribute_add').click(function(e) {

                                e.preventDefault();
                                let contributor_add = $(this).attr('data-contributor-add');
                                let data_doc_id = $(this).attr('data-doc-id');

                                let user_img = $(this).parent().parent().find('img').attr('src');
                                let user_name = $(this).attr('data_name');
                                let user_url = $(this).parent().parent().find('a').attr('href');

                                $.ajax({
                                    url: eazydocs_ajax_search.ajax_url,
                                    method: 'POST',
                                    data: {
                                        action: 'ezd_doc_contributor',
                                        contributor_add: contributor_add,
                                        data_doc_id: data_doc_id
                                    },
                                    beforeSend: function() {
                                        $('.ezd_contribute_add[data-contributor-add=' +
                                            contributor_add + ']').html(
                                            '<span class="spinner-border ezd-contributor-loader"><span class="visually-hidden">Loading...</span></span>'
                                        )
                                    },
                                    success: function(response) {
                                        $('#added_contributors').append(response);
                                        $('#to-add-user-' + contributor_add).remove();

                                        $('.user-' + contributor_add).not(':last').remove();

                                        $('.contributed_user_list').append('<a title="' + user_name +
                                            '" href="' + user_url +
                                            '" data-bs-toggle="tooltip" data-bs-placement="bottom"><img width="24px" src="' +
                                            user_img + '"></a>');
                                        $('.contributed_user_list a[data-bs-original-title="' +
                                            user_name + '"]').remove();

                                        $('[data-bs-toggle="tooltip"]').tooltip();

                                        ezd_contribute_delete();

                                    },
                                    error: function() {
                                        console.log('Oops! Something wrong, try again!')
                                    }
                                });
                            });
                        }

                        var canBeLoaded = true, // this param allows to initiate the AJAX call only if necessary
                            bottomOffset = 2000; // the distance (in px) from the page bottom when you want to load more posts
 
                            $(".doc_users_dropdown").on('mousewheel DOMMouseScroll', function() {

                                var data = {
                                    'action': 'load_more_contributors',
                                    'page': eazydocs_ajax_search.current_page,
                                    'exclude': [<?php echo $merged_users; ?>],
                                    'loaditems': <?php echo ezd_get_opt('contributor_load_per_scroll', 3); ?>
                                };
                                console.log(eazydocs_ajax_search.current_page);

                                if ($(".doc_users_dropdown").scrollTop() > ($(".doc_users_dropdown").height() -
                                        bottomOffset) && canBeLoaded == true) {
                                    $.ajax({
                                        url: eazydocs_ajax_search.ajax_url,
                                        data: data,
                                        type: 'POST',
                                        beforeSend: function(xhr) {
                                            canBeLoaded = false;
                                            $(".loading-info").show();
                                        },
                                        success: function(data) {
                                            if (data) {
                                                $(".doc_users_dropdown").find('#to_add_contributors')
                                                    .append(data); // where to insert posts
                                                canBeLoaded =
                                                    true; // the ajax is completed, now we can run it again
                                                eazydocs_ajax_search.current_page++;
                                                ezd_contributor_add();
                                            }
                                            $(".loading-info").hide();
                                        }
                                    });
                                }
                            });
                        });
                    })(jQuery);
                    </script>
                <?php
            endif;
        endif;
    }
}
// end
<?php
function docy_acf_block_subscribe($block){
    $uid = $block['id'];
    $sectoon_bg = get_field( 'sec_bg_color' );
    $sectoon_margin = get_field( 'ss_margin_top' );
    ?>
    <style>
        .doc_subscribe_inner{
            <?php if( $sectoon_bg ): ?>
            background: <?php echo esc_attr( $sectoon_bg ); ?>;
            <?php endif; ?>

            <?php if( $sectoon_margin ): ?>
            margin-top: <?php echo esc_attr( $sectoon_margin ); ?>px;
            <?php endif; ?>
        }
    </style>
    <div class="container">
        <div class="<?php echo $uid; ?> doc_subscribe_inner">
            <?php
            docy_el_image(get_field('docy_subs_shape1'), 'docy curve shape top', 'one');
            docy_el_image(get_field('docy_subs_shape2'), 'docy curve shape bottom', 'two');
            if ( get_field('docy_subs_title') ) : ?>
                <div class="text wow fadeInLeft" data-wow-delay="0.2s">
                    <?php echo sprintf( '<h2 class="title"> %2$s </h2>', get_field('docy_subs_title'), nl2br(get_field('docy_subs_title')) ) ?>
                </div>
            <?php endif; ?>
            <form action="#" class="doc_subscribe_form wow fadeInRight mailchimp" data-wow-delay="0.4s"
                  method="post">
                <div class="form-group">
                    <div class="input-fill">
                        <input type="email" name="EMAIL" id="email" class="memail" placeholder="<?php echo esc_attr(get_field('docy_email_plc')) ?>">
                    </div>
                    <?php if ( get_field('docy_btn_label') ) : ?>
                        <button type="submit" class="submit_btn"><?php echo esc_html(get_field('docy_btn_label')) ?></button>
                    <?php endif ?>
                    <p class="mchimp-errmessage" style="display: none;"></p>
                    <p class="mchimp-sucmessage" style="display: none;"></p>
                </div>
                <?php echo !empty(get_field('docy_form_btm')) ? wp_kses_post(get_field('docy_form_btm')) : ''; ?>
            </form>
        </div>
    </div>

        <script>
            ;(function($){
                "use strict";
                $(document).ready(function () {

                    $(".mailchimp").ajaxChimp({
                        callback: mailchimpCallback,
                        url:
                            "<?php echo esc_js(get_field('docy_action_url')) ?>", //Replace this with your own mailchimp post URL. Don't remove the "". Just paste the url inside "".
                    });
                    $(".memail").on("focus", function () {
                        $(".mchimp-errmessage").fadeOut();
                        $(".mchimp-sucmessage").fadeOut();
                    });
                    $(".memail").on("keydown", function () {
                        $(".mchimp-errmessage").fadeOut();
                        $(".mchimp-sucmessage").fadeOut();
                    });
                    $(".memail").on("click", function () {
                        $(".memail").val("");
                    });

                    function mailchimpCallback(resp) {
                        if (resp.result === "success") {
                            $(".mchimp-errmessage").html(resp.msg).fadeIn(1000);
                            $(".mchimp-sucmessage").fadeOut(500);
                        } else if (resp.result === "error") {
                            $(".mchimp-errmessage").html(resp.msg).fadeIn(1000);
                        }
                    }
                });
            })(jQuery)
        </script>
    <?php
}
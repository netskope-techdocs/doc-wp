<?php

?>
<nav class="dsd-menubard">

	<span class="dsd-logo">
		<img src="<?php echo DOCY_DIR_IMG.'/logo_sticky_retina.png'; ?>" alt="<?php echo esc_attr( $theme->name ); ?>">
		<?php printf( '<span class="v">%s</span>', $theme->version ); ?>
	</span>

    <ul class="dsd-menu">
        <li class="<?php docy_helper()->active_tab('docy'); ?>">
            <a href="">
                <span><?php esc_html_e( 'Dashboard', 'docy' ); ?></span>
            </a>
        </li>
        <li class="">
            <a href="">
                <span><?php esc_html_e( 'Install Plugins', 'docy' ); ?></span>
            </a>
        </li>
        <li class="">
            <a href="">
                <span><?php esc_html_e( 'Import Demo', 'docy' ); ?></span>
            </a>
        </li>
        <li class="">
            <a href="">
                <span><?php esc_html_e( 'Support', 'docy' ); ?></span>
            </a>
        </li>
        <li>
            <a href="https://helpdesk.spider-themes.net/docs/docy-wordpress-theme/getting-started/" target="_blank">
                <i class="icon-md-help-circle"></i>
                <span><?php esc_html_e( 'Documentations', 'docy' ); ?></span>
            </a>
        </li>
    </ul>

</nav> <!-- /.dsd-menubard -->
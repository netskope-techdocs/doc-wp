<?php
 namespace EasyDocs\Admin\Analytics;
/**
 * EasyDocs Analytics
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>
<div class="wrap ezd-analytics ezd_doc_builder">
    <div class="easydocs-sidebar-menu">
        <div class="tab-container">
            <div class="dd tab-menu short">
                <ol class="easydocs-navbar dd-list">
                    <li class="easydocs-navitem dd-item dd3-item is-active active" data-rel="analytics-overview" data-id="1">
                        <div class="title">
                            <span class="dashicons dashicons-dashboard"></span>
                            <?php esc_html_e('Overview', 'eazydocs-pro' ); ?>
                        </div>
                    </li>
                    <li class="easydocs-navitem dd-item dd3-item" data-rel="analytics-views" data-id="2">
                        <div class="title">
                            <span class="dashicons dashicons-welcome-view-site"></span>
                            <?php esc_html_e('Views', 'eazydocs-pro' ); ?>
                        </div>
                    </li>
                    <li class="easydocs-navitem dd-item dd3-item" data-rel="analytics-feedback" data-id="3">
                        <div class="title">
                            <span class="dashicons dashicons-feedback"></span>
                            <?php esc_html_e('Feedback', 'eazydocs-pro' ); ?>
                        </div>
                    </li>
                    <li class="easydocs-navitem dd-item dd3-item" data-rel="analytics-search" data-id="4">
                        <div class="title">
                            <span class="dashicons dashicons-search"></span>
                            <?php esc_html_e('Search', 'eazydocs-pro' ); ?>
                        </div>
                    </li>
                    <li class="easydocs-navitem dd-item dd3-item" data-rel="analytics-helpful" data-id="5">
                        <div class="title">
                            <span class="dashicons dashicons-editor-help"></span>
                            <?php esc_html_e( 'Helpful Docs', 'eazydocs-pro' ); ?>
                        </div>
                    </li>
                </ol>
            </div>
            <div class="easydocs-tab-content">
                <?php include dirname(__FILE__) . '/parts/overview.php'; ?>
                <?php include dirname(__FILE__) . '/parts/views.php'; ?>
                <?php include dirname(__FILE__) . '/parts/feedback.php'; ?>
                <?php include dirname(__FILE__) . '/parts/search.php'; ?>
                <?php include dirname(__FILE__) . '/parts/helpful-docs.php'; ?>
            </div>
        </div>
    </div>
</div>
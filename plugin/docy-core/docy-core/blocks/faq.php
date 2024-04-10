<?php
function docy_acf_block_faq(){
    $skins = get_field('faq_skins');
    if ( $skins == 'faq_tab' ) {
        include('inc/faqs/faq-3.php');
    }
    if ( $skins == 'faq_light1' ) {
        echo "<h1 class='text-center text-warning'>Style will coming soon</h1>";
    }
    if ( $skins == 'faq_light2' ) {
        echo "<h1 class='text-center text-warning'>Style will coming soon</h1>";
    }
}
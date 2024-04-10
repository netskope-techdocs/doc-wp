<?php
function docy_acf_block_single_doc(){
    $skins = get_field('docy_doc_skins');

    if ( $skins == 'docy_light_skin' ) {
        include('inc/single-doc/single-doc-1.php');
    }
    if ( $skins == 'docy_creative_skin' ) {
        include('inc/single-doc/single-doc-2.php');
    }
    if ( $skins == 'docy_box_skin' ) {
        include('inc/single-doc/single-doc-3.php');
    }
    if ( $skins == 'docy_topic_box_skin' ) {
        include('inc/single-doc/single-doc-4.php');
    }
}
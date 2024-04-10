<?php
function docy_acf_block_single_forum(){
    $skins = get_field('skins');
    if ( $skins == 'skin1' ) {
        include('inc/single-forum/single-forum-1.php');
    }
    if ( $skins == 'skin2' ) {
        include('inc/single-forum/single-forum-2.php');
    }
}
<?php
function docy_acf_block_forums(){
    $option = get_field("docy_forums_style");

    if ( $option == "docy_forum1" ) {
        include('inc/forums/forums-1.php');
    }
    if ( $option == "docy_forum2" ) {
        include('inc/forums/forums-2.php');
    }
}
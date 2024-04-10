<?php
function docy_acf_block_forum_topics(){
    $skins = get_field('docy_ft_skins');
    if ( $skins == 'docy_ft_list' ) {
        echo "<h1 class='text-center text-warning'>Style will coming soon</h1>";
    }
    if ( $skins == 'docy_ft_lwe' ) {
        include('inc/forum-topics/forum-topics-2.php');
    }
}
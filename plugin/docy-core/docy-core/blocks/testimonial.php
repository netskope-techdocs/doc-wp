<?php
function docy_acf_block_testimonial(){
    $skins = get_field('docy_skins_style');
    if ( $skins == 'docy_skin1' ) {
        include('inc/testimonials/testimonials-1.php');
    }
    if ( $skins == 'docy_skin2' ) {
        echo "<h1 class='text-center text-warning'>Style will coming soon</h1>";
    }
}
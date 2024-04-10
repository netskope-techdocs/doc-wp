<?php
function docy_acf_block_home_hero_search(){
    $style = get_field('docy_hero_style');
    if ( $style == 'docy_hero_creative' ) {
        include('inc/hero/hero-1.php');
    }
    if ( $style == 'docy_hero_classic' ) {
        include('inc/hero/hero-2.php');
    }
    if ( $style == 'docy_hero_minimal' ) {
        include('inc/hero/hero-3.php');
    }
    if ( $style == 'docy_hero_cool' ) {
        include('inc/hero/hero-4.php');
    }
    if ( $style == 'docy_hero_light' ) {
        include('inc/hero/hero-5.php');
    }
    if ( $style == 'docy_hero_comm' ) {
        include('inc/hero/hero-6.php');
    }
}
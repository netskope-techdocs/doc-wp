<?php
function docy_acf_block_video(){
    $skins = get_field('docy_video_skins');
    if ( $skins == 'video_skin1' ) {
        include('inc/video-playlist/video-playlist-1.php');
    }
    if ( $skins == 'video_skin2' ) {
        include('inc/video-playlist/video-playlist-2.php');
    }
}
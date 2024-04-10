<?php
function docy_acf_block_docs(){
    $skins = get_field('skins');
    if ( $skins == 'doc_skin1' ) {
        echo "<h1 class='text-center text-warning'>Style will coming soon</h1>";
    }
    if ( $skins == 'doc_skin2' ) {
        echo "<h1 class='text-center text-warning'>Style will coming soon</h1>";
    }
    if ( $skins == 'doc_skin3' ) {
        include('inc/docs/docs-3.php');
    }
}
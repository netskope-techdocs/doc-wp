<?php
function docy_acf_block_changelogs( $block ) {
    // File opening
    $import_txt_file = get_field('import_txt_file');
    $changes = !empty($import_txt_file) ? fopen($import_txt_file, "r") : '';
    $change_logs = '';
    if ( !empty($changes) ) {
        while (!feof($changes)) {
            $change_logs .= fgets($changes);
        }
        fclose($changes);
    }

     // Make an array by End of Each Line
    $change_logs = explode(PHP_EOL, $change_logs);

    // Empty line positions (keys) in the $changes array
    $empty_keys = [];
    foreach ($change_logs as $key => $value) {
        $value = trim($value);
        if (empty($value)) {
            $empty_keys[] .= $key;
        }
    }

    // Version array positions
    $version_keys = [];
    $version_keys[] .= 0;
    foreach ($empty_keys as $empty_key) {
        $version_keys[] .= $empty_key+1;
    }

    // Versions Arrays
    $versions_array = array();
    $i = 0;
    foreach( $change_logs as $k => $v ) {
        if (!empty($v)) {
            $versions_array[$i][$k] = $v;
            continue;
        }
        $i++;
    }
    $versions_array = array_values($versions_array);

    echo '<div class="changelogs changelogs-txt">';
    foreach ( $versions_array as $vls_i => $version_logs ) {
        $text_color = !empty($block['data']['text_color']) ? "color:{$block['data']['text_color']};" : '';
        $background_color = !empty($block['data']['background_color']) ? "background-color:{$block['data']['background_color']};" : '';
        $style = (!empty($text_color) || !empty($background_color)) ? "style='$text_color $background_color'" : '';
        $count = 1;
        $version_logs_count = count($version_logs);
        foreach ( $version_logs as $vl_i => $version_log ) {
            if( $count == 1 ) {
                $version = str_replace( '-', '', $version_log );
                $version = explode( '(', $version );
                $version = isset($version[0]) ? $version[0] : '';
                $version = str_replace( ' ', '', $version );
                echo "<pre id='$version' data-version='$version' $style>";
            } else {
                echo $version_log."\n";
            }
            if ( $count == $version_logs_count ) {
                echo '</pre>';
            }
            $count++;
        }
    }
    echo "</div>";
}
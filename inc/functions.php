<?php

// Return Options
function getOptions($settings) {
    global $opt;
    if (!$opt) {
        $opt = get_option($settings);
    }
    return $opt;
}


// $opt = null;
// function wphs_init() {
//    	global $opt;
//   	if (!$opt) {
//     $opt = get_option('zshortcodes_settings');
// 	}
// }
?>
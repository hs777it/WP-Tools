<?php
/*
Plugin Name: zTools v2.1
Plugin URI: https://github.com/hs777it
Description: zTools Shortcodes .Examples: [ztools-year], [ztools-font]
Version: 1.2.0
Author: Hussein Saad
Author URI: mailto:hs777it@gmail.com
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/* ADDING FUNCIONALITY
============================== */

add_action( 'wp_enqueue_scripts', 'hs_fontawesome' );
function hs_fontawesome() {
        wp_enqueue_style('hs-font-awesome', 'https://use.fontawesome.com/releases/v5.15.4/css/all.css?ver=5.7');
}

include 'inc/functions.php';
if( !class_exists('qrcode')){ include 'inc/qrcode.php'; }
include 'inc/shortcodes.php';
include 'inc/copyright.php';

// Enqueues Javascript / CSS Files
// add_action( 'wp_enqueue_scripts', function() {
//     wp_enqueue_script( 'zcontent-js', plugin_dir_url( __FILE__ ) . '/js/zcontent.js', array( 'jquery' ), '1.0', true );
//     wp_enqueue_script( 'zcontent-css', plugin_dir_url( __FILE__ ) . '/css/style.css', array( 'stylesheet' ), '1.0', true );
// });

add_action('admin_init', function()
{
    wp_register_style('zcontent', plugins_url('css/tools.css', __FILE__));
    wp_enqueue_style('zcontent');
    //wp_register_script( 'zcontent', plugins_url('script.js',__FILE__ ));
    //wp_enqueue_script('zcontent');
});

// wp_enqueue for website
add_action('wp_head', function () {
	wp_enqueue_script('zshortcodes', plugins_url('js/func.js', __FILE__));
});
/* ADDING THE ADMIN MENU 
======================================== */

add_action('admin_menu', 'ztools_menu');
    function ztools_menu(){
        //plugin_dir_url( __FILE__ ) . 'img/onesignal.png'     
        add_menu_page('zTools Settings', 'zTools', 'manage_options', 'ztools-menu', 'ztools_callback','dashicons-analytics' );
		add_submenu_page('ztools-menu', 'Content', 'Content', 'manage_options', 'content-menu','content_callback' );
		if( is_plugin_active('zShortcodes/zShortcodes.php') ){
			add_submenu_page('ztools-menu', 'Shortcodes', 'Shortcodes', 'manage_options', 'shortcodes-menu','zshortcodes_callback' );
		}

}
        
//The markup for zTools settings page
function ztools_callback()
{ ?>
<style>
    .ztool-wrap a{
        font-size: 17px;
        color: #efefef;
        background: #3e3e3e;
        text-decoration: none;
        border-radius: 5px;
        padding: 10px;
    }
    a:hover{
        color: #efefef;
    }
</style>
<div class="ztool-wrap">
    <!-- <div class="pnl"> -->

        <h1>zTools Settings<hr></h1>
        
        <div class="body">
            <div>
                <a style="" href="admin.php?page=content-menu">Content Settings</a>
                <?php 
                if ( is_plugin_active( 'zShortcodes/zShortcodes.php' ) ) { ?>
                    <a href="admin.php?page=shortcodes-menu">Shortcodes</a>    
                <?php } ?>
            </div>
        </div>
        
        <?php include 'inc/footer.php'; ?>
        

    <!-- </div> -->
</div>
<?php } 



//The markup for Content settings page
function content_callback()
{ ?>

<div class="ztool-wrap">

        <h1>Content Settings<hr></h1>

        <div class="body">
            <form id="cnt_form" action="options.php" method="post">
                <?php
                    settings_fields('hswp_content_settings');
                    do_settings_sections(__FILE__);
                    $options = get_option('hswp_content_settings'); //get the older values
                    //print_r($options);
                ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">Before Content:</th>
                        <td>
                            <fieldset>
                            <textarea id="before_cont" name="hswp_content_settings[before_cont]" rows="10" cols="70" class="input_text" ><?php 
                            echo (isset($options['before_cont']) && $options['before_cont'] != '') 
                            ? $options['before_cont'] : ''; ?></textarea> 
                            </fieldset>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">After Content:</th>
                        <td>
                            <fieldset>
                            <textarea id="after_cont" name="hswp_content_settings[after_cont]" rows="10" cols="70" class="input_text"><?php 
                            echo (isset($options['after_cont']) && $options['after_cont'] != '') 
                            ? $options['after_cont'] : ''; ?></textarea>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <?php submit_button(); ?>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <?php include 'inc/footer.php';?>

</div>
<?php } 



add_filter( 'the_content', 'wphs_paragraph' );
function wphs_paragraph( $content ) { 

    if (!is_single()) return $content;

    $new_content = '';

    $opt = get_option( 'hswp_content_settings' );
    $before = $opt['before_cont'];
    $after = $opt['after_cont'];
    
    // Before Content
    $first_para_pos = strpos( $content, '<p' );
    $content_with_before = substr_replace( $content, $before, $first_para_pos, 0 );
   
    // After Content
    $content = explode("</p>", $content_with_before); //explode("</p>", get_the_content());
    $ns =  count($content) -1; //before last paragraph

    for($i = 0; $i < count($content); $i++) {
        if ($i == $ns ) { $new_content .=  $after; }
        $new_content .= $content[$i] . "</p>";
    }
    return  $new_content ;
}


// Plugin Settings
add_filter('plugin_action_links_' . plugin_basename(__FILE__),function($links)
{
    $links[] = '<a href="' . admin_url('admin.php?page=ztools-menu') . '">' . __('Settings') . '</a>';
    return $links;
});

//Register the settings
add_action('admin_init', 'hswp_content_settings');
function hswp_content_settings()
{
    //this will save the option in the wp_options table as 'hswp_content_settings'
    //the third parameter is a function that will validate your input values
    register_setting('hswp_content_settings', 'hswp_content_settings', 'hswp_content_settings_validate');
}


//Register the Copyright
add_action( 'wp_head', 'ztool_copyright');


?>
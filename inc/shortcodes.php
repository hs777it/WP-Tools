<?php

$opt = getOptions('zshortcodes_settings');
//$link = get_bloginfo( 'url' ) ."/?p=" . get_the_ID();
//$link = wp_get_shortlink(get_the_ID());

// Plugin Settings
add_filter('plugin_action_links_' . plugin_basename(__FILE__), function($links)
{
    $links[] = '<a href="' . admin_url('admin.php?page=shortcodes-menu') . '">' . __('Settings') . '</a>';
    return $links;
});

// wp_enqueue for Dashboard
add_action('admin_init', function () {
    wp_enqueue_style('zshortcodes', plugins_url('../css/admin.css', __FILE__));
});
// wp_enqueue for website
add_action('wp_head', function () {
	wp_enqueue_style('zshortcodes', plugins_url('../css/style.css', __FILE__));
	wp_enqueue_style('zshortcodes', plugins_url('../css/style-rtl.css', __FILE__));
	wp_enqueue_script('zshortcodes', plugins_url('../js/func.js', __FILE__));
});

//Register the settings
add_action('admin_init', function(){
    //this will save the option in the wp_options table as 'zshortcodes_settings'
    //the third parameter is a function that will validate your input values
    register_setting('zshortcodes_settings', 'zshortcodes_settings', 'zshortcodes_settings_validate');
});

//Add the menu
add_action('admin_menu', 'zshortcodes_menu');
    function zshortcodes_menu(){
        add_menu_page('','zShortcodes', 'zShortcodes', 'manage_options', 'shortcodes-menu', 'zshortcodes_callback','dashicons-analytics');
}

//The markup for zShortcodes settings page
function zshortcodes_callback()
{?> 

<div class="zshortcodes-wrap">

        <h1>zShortcodes Settings<hr></h1>
		
		<?php settings_errors(); ?>
	
        <div class="body">

            <form id="cnt_form" action="options.php" method="post">
                <?php
 					settings_fields('zshortcodes_settings');
            		do_settings_sections(__FILE__);
                    $options = get_option('zshortcodes_settings'); 
                ?>
<table class="form-table">    
	
	<tr>
	<td>
		<label for="font_resize">Font Resizer</label>
		<input type="checkbox" id="font_resize" name="zshortcodes_settings[font_resize]" value="font_resize"
			   <?php checked('font_resize', (isset($options['font_resize']) && $options['font_resize'] != '') ? $options['font_resize'] : ''); ?> />
	</td><td></td>
	</tr>
	<tr>
		<td>
		<label for="cyear">Current Year</label>
		<input type="checkbox" id="cyear" name="zshortcodes_settings[cyear]" value="cyear"
			   <?php checked('cyear', (isset($options['cyear']) && $options['cyear'] != '') ? $options['cyear'] : ''); ?> />
		</td><td></td><td></td>
		</tr>	
	
<tr>
	<td></td><td></td>
	<td width="100">
		<?php submit_button(); ?>
	</td>
</tr>
                </table>
            </form>
			
			<hr>
			<table>
				<tr>
					<th>Shortcodes Usage:</th>
				</tr>
			</table>
			
        </div>
	<?php include 'footer.php';?>
	
</div>
<?php } 


// =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-=
// Font Resizer
add_action( 'init', 'ztools_shortcode' );
function ztools_shortcode() {
	wp_register_script("ztools-script", plugins_url("../js/script.js", __FILE__), array('jquery'), "1.0", false);
	if( is_rtl() ) { 
		wp_enqueue_style('ztools-style', plugins_url("../css/style-rtl.css", __FILE__), array(), "1.0", "all");
		} else { 
		wp_enqueue_style('ztools-style', plugins_url("../css/style.css", __FILE__), array(), "1.0", "all");
	}
    //wp_enqueue_style('direction-style', get_template_directory_uri()."/style.css",array(), null);
}

function wphs_font_resizer($attr , $content){
	// $a = shortcode_atts( array(
	//   'text' => ''
	// ), $attr );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script("ztools-script",array('jquery') , '1.0', true);
	wp_enqueue_style("ztools-style");	
	
	$url = urlencode(get_permalink());
    $title = str_replace(' ', '%20', get_the_title()); 
    $blog_title = get_bloginfo('name');
	$text = $title . " " . $url  ;		
	$qrode = do_shortcode('[qrcode]');
	$post_link = wp_get_shortlink(get_the_ID());

	return '<div class="ztools font-manage">
	<div class="copy_msg"><span>URL Copied</span></div>
	<a href="javascript:void(0);" class="a-pluse">+A</a>
	
	<a href="javascript:void(0);" class="a-init">A</a>
	
	<a href="javascript:void(0);" class="a-minus">-A</a>

	<a href="//twitter.com/intent/tweet?text='.$title.'&url='.$url.'&via=hs777it" class="a-twitter"><i class="fab fa-twitter"></i></a>
	
	<a href="whatsapp.com/send?text='.$text.'" data-action="share/whatsapp/share" class="a-wa"><i class="fab fa-whatsapp"></i></a>
	
	<a href="javascript:void(0);" class="a-print"><i class="fas fa-print"></i></a>
	
	<a href="'.$post_link.'" data-toggle="tooltip" title="Copy link" class="a-copy"><i class="fas fa-link"></i></a>
	
	
	<a href="javascript:void(0);" class="qricon"><i class="fas fa-qrcode"></i><span class="qrcode">' .$qrode. '</sapn></a>
		
	
	<a href="javascript:void(0);" class="a-file"><i class="fas fa-file"></i></a>
    </div>'; 
}
if(isset($opt['font_resize']) && $opt['font_resize'] == true ) 
	add_shortcode( 'ztools-font', 'wphs_font_resizer');


// =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-=
// Current Year
if(isset($opt['cyear']) && $opt['cyear'] == true ) 
	add_shortcode('year',  'ztools_year' );
function ztools_year() {
	$html = '<span class="year">';
	$html .= date('Y');
	$html .= '</span>';

	return $html;
}

// =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-=
// QR Code after content
//add_filter("the_content", "qr_code");
// function qr_code($content)
// {
// 	$url = get_permalink();
// 	$qr = new qrcode();
// 	$qr->text($url);
// 	$html = "<p><b>QR Code:</b></p><p><img src='".$qr->get_link()."' border='0'/></p>";
// 	$content .= $html;

// 	return $content;
// }

// QR Code shortcode
if(isset($opt['cyear']) && $opt['cyear'] == true ) 
	add_shortcode('qrcode',  'zqr_code' );

function zqr_code($content) {
	$url = get_permalink();
	$qr = new qrcode();
	$qr->text($url);
	//$result = "<p><b>QR Code:</b></p><p><img src='".$qr->get_link()."' border='0'/></p>";
	$result = "<span><img src='".$qr->get_link()."' border='0'/></span>";
	
	return $result;
}





 // <script>
// function copyLink(){
// 	//var cpy =  navigator.clipboard.writeText(window.location.href);
// 	return navigator.clipboard.writeText(window.location.href);
// }
// </script>
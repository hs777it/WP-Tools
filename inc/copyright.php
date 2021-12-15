<?php

// =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-=
// Add Copyright Text By Hussain Saad +965 60907666 hs777it@gmail.com
function ztool_copyright() {
    if (is_single()) { ?>
 
<script type='text/javascript'>
function addLink() {
    if (
window.getSelection().containsNode(
document.getElementsByClassName('entry-content')[0], true)) {
    var body_element = document.getElementsByTagName('body')[0];
    var selection;
    selection = window.getSelection();
    var oldselection = selection;
    
    var pagelink = "<br /><br /> :إقرأ المزيد  <?php the_title(); ?> <a href='<?php echo wp_get_shortlink(get_the_ID()); ?>'><?php echo wp_get_shortlink(get_the_ID()); ?></a>";

    
  
	var pagelink = "<br/><br /><span'> <a href='<?php echo wp_get_shortlink(get_the_ID()); ?>'><?php echo wp_get_shortlink(get_the_ID()); ?></a> إقرأ المزيد على <?php echo get_bloginfo( 'name' ) ?> </span>";
    

    var pagelink = "<br/><span>";
        pagelink += "<a href='<?php echo wp_get_shortlink(get_the_ID()); ?>'><?php the_title('',': ');echo wp_get_shortlink(get_the_ID()); ?></a>";
        pagelink += "<br/>";
        pagelink += "إقرأ المزيد على: ";
        pagelink += "<a href='<?php echo get_bloginfo( 'url' ); ?>'><?php echo get_bloginfo( 'name' ); ?></a>";
        
        // pagelink += "تابعنا"; in next update (Twitter, facebook, instagram, whatsapp , ....)
        pagelink += "<span>";


    var copy_text = selection + pagelink;
    var new_div = document.createElement('div');
    new_div.style.left='-99999px';
    new_div.style.position='absolute';
 
    body_element.appendChild(new_div );
    new_div.innerHTML = copy_text ;
    selection.selectAllChildren(new_div );
    window.setTimeout(function() {
        body_element.removeChild(new_div );
    },0);
}
}
 
document.oncopy = addLink;
</script>
 
<?php
}}
<?php


function cust_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");

    ?>
        <div>
            <label for="checkbox_push">Send Notification</label>
            <?php
                $checkbox_value = get_post_meta($object->ID, "checkbox_push", true);

                if($checkbox_value){
                    echo '<input name="checkbox_push" type="checkbox" value="true" checked />';
                }else{
                    echo '<input name="checkbox_push" type="checkbox" value="true" />';
                } 
            ?>
        </div>
    <?php  
}

add_action("add_meta_boxes", function() 
{
    add_meta_box(
        "cnt-meta-box",
        "Content AB",
        "cust_meta_box_markup",
        "post", "side", "high", null);
});

add_action("save_post", function($post_id, $post, $update){

    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
    return $post_id;

if(!current_user_can("edit_post", $post_id))
    return $post_id;

if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
    return $post_id;

$slug = "post";
if($slug != $post->post_type)
    return $post_id;

$meta_box_checkbox_value = "";

 
update_post_meta($post_id, "meta-box-dropdown", $meta_box_dropdown_value);

if(isset($_POST["checkbox_push"]))
{
    $meta_box_checkbox_value = $_POST["checkbox_push"];
}   
update_post_meta($post_id, "checkbox_push", $meta_box_checkbox_value);


}, 10, 3);



?>
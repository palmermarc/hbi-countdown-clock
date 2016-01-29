<?php 

$sizes = get_option( 'hbi_countdown_clock_sizes' );

if( !empty( $sizes ) ) :
    foreach( $sizes as $size ) :
        $field_name = strtolower( $size['name'] . '_image' ); 
        ?>
            <label for="<?php echo $lower_field_name; ?>"><?php echo $size['name']; ?></label>
            <input size="85" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" type="text" value="<?php echo get_post_meta( $object->ID, $field_name, TRUE ); ?>" />
            <div id="<?php echo $field_name;?>_uploader" data-attachment_div="#<?php echo $field_name; ?>" data-uploader_button_text="Select Image" data-uploader_title="HBI Countdown Clock Image Uploader" class="upload_item_button button button-primary">Upload Image</div>
        <hr />
        <?php
    endforeach;
endif;

$post_meta = get_post_meta( $object->ID );
$active = ( 1 == get_post_meta( $object->ID, 'countdown_use_link', TRUE ) ) ? 'active' : '';
wp_enqueue_media();
?>

<p>
    <label for="countdown_date_time">What time are we counting down to?</label>
    <input type="datetime-local" name="countdown_date_time" id="countdown_date_time" value="<?php echo get_post_meta( $object->ID, 'countdown_date_time', TRUE ); ?>" />
</p>
<p>
    <label for="countdown_use_link">Would you like the image to link off somewhere?</label>
    <select id="countdown_use_link" name="countdown_use_link">
        <option <?php selected( '0', get_post_meta( $object->ID, 'countdown_use_link', TRUE ) ); ?> value="0">No</option>
        <option <?php selected( '1', get_post_meta( $object->ID, 'countdown_use_link', TRUE ) ); ?> value="1">Yes</option>
    </select>
</p>
<p id="countdown_link_location" class="use_countdown_link <?php echo $active; ?>">
    <label for="countdown_link_location">Countdown Link URL</label>
    <input placeholder="http://" type="text" name="countdown_link_location" value="<?php echo $post_meta['countdown_link_location'][0]; ?>" size="95" />
</p>
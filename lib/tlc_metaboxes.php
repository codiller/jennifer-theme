<?php

add_filter( 'cmb_render_location', 'cmb_render_location_field', 10, 2 );
/**
 * Render Address Field
 */
function cmb_render_location_field( $field, $meta ) {

    $state_list = array( 'AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CA'=>'California','CO'=>'Colorado','CT'=>'Connecticut','DE'=>'Delaware','DC'=>'District Of Columbia','FL'=>'Florida','GA'=>'Georgia','HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois','IN'=>'Indiana','IA'=>'Iowa','KS'=>'Kansas','KY'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland','MA'=>'Massachusetts','MI'=>'Michigan','MN'=>'Minnesota','MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana','NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey','NM'=>'New Mexico','NY'=>'New York','NC'=>'North Carolina','ND'=>'North Dakota','OH'=>'Ohio','OK'=>'Oklahoma','OR'=>'Oregon','PA'=>'Pennsylvania','RI'=>'Rhode Island','SC'=>'South Carolina','SD'=>'South Dakota','TN'=>'Tennessee','TX'=>'Texas','UT'=>'Utah','VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington','WV'=>'West Virginia','WI'=>'Wisconsin','WY'=>'Wyoming' );

    // echo '<xmp>$meta: '. print_r( $meta, true ) .'</xmp>';
    // echo '<xmp>$field: '. print_r( $field, true ) .'</xmp>';
    $meta = wp_parse_args( $meta, array(
        'location-name' => '',
        'address-1' => '',
        'address-2' => '',
        'city' => '',
        'state' => '',
        'zip' => '',
    ) );

    echo
    '<div><p><label for="', $field['id'], '-location-name">Location Name</label></p>',
        '<input type="text" class="regular-text" name="', $field['id'] ,'[location-name]" id="', $field['id'], '-location-name" value="', cmb_Meta_Box_types::esc( $meta['location-name'] ), '" /></div>',
    '<div><p><label for="', $field['id'], '-address-1">Address 1</label></p>',
        '<input type="text" class="regular-text" name="', $field['id'] ,'[address-1]" id="', $field['id'], '-address-1" value="', cmb_Meta_Box_types::esc( $meta['address-1'] ), '" /></div>',
    '<div><p><label for="', $field['id'], '-address-2">Address 2</label></p>',
        '<input type="text" class="regular-text" name="', $field['id'] ,'[address-2]" id="', $field['id'], '-address-2" value="', cmb_Meta_Box_types::esc( $meta['address-2'] ), '" /></div>',
    '<div class="alignleft"><p><label for="', $field['id'], '-city">City</label></p>',
        '<input type="text" class="cmb_text_small" name="', $field['id'] ,'[city]" id="', $field['id'], '-city" value="', cmb_Meta_Box_types::esc( $meta['city'] ), '" /></div>',

    '<div class="alignleft"><p><label for="', $field['id'], '-state">State</label></p>',
        '<select name="', $field['id'] ,'[state]" id="', $field['id'], '-state">';
        foreach ( $state_list as $abrev => $state ) {
            echo '<option value="', $abrev, '" ', selected( $meta['state'], $abrev ) ,'>', $state, '</option>';
        }
        echo '
        </select></div>',
    '<div class="alignleft"><p><label for="', $field['id'], '-zip">Zip</label></p>',
        '<input type="text" class="cmb_text_small" name="', $field['id'] ,'[zip]" id="', $field['id'], '-zip', '" value="', cmb_Meta_Box_types::esc( $meta['zip'] ), '" /></div>',
    '<p class="cmb_metabox_description" style="clear:both;">'. $field['desc'] .'</p>';

} ?>
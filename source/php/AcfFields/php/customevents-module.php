<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_6552378ea7e89',
    'title' => __('Customevents', 'modularity-customevents'),
    'fields' => array(
        0 => array(
            'key' => 'field_6552378ee22a4',
            'label' => __('Date', 'modularity-customevents'),
            'name' => 'date',
            'aria-label' => '',
            'type' => 'date_picker',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'display_format' => 'Y-m-d',
            'return_format' => 'Y-m-d',
            'first_day' => 1,
        ),
        1 => array(
            'key' => 'field_6552381be22a5',
            'label' => __('Start', 'modularity-customevents'),
            'name' => 'start_time',
            'aria-label' => '',
            'type' => 'time_picker',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'display_format' => 'H:i:s',
            'return_format' => 'H:i:s',
        ),
        2 => array(
            'key' => 'field_65523838e22a6',
            'label' => __('End', 'modularity-customevents'),
            'name' => 'end_time',
            'aria-label' => '',
            'type' => 'time_picker',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'display_format' => 'H:i:s',
            'return_format' => 'H:i:s',
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'custom-events',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'left',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
    'acfe_display_title' => 'Event',
    'acfe_autosync' => array(
        0 => 'json',
    ),
    'acfe_form' => 0,
    'acfe_meta' => '',
    'acfe_note' => '',
));
}
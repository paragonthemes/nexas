<?php


/*-------------------------------------------------------------------------------------------------*/
/**
 * Slider Section
 *
 */
$wp_customize->add_section(
    'nexas_slider_section',
    array(
        'title'     => esc_html__('Slider Setting Option', 'nexas'),
        'panel'     => 'nexas_theme_options',
        'priority'  => 4,
    )
);

/**
 * Show/Hide option for Homepage Slider Section
 *
 */

$wp_customize->add_setting(
    'nexas_homepage_slider_option',
    array(
        'default'           => $default['nexas_homepage_slider_option'],
        'sanitize_callback' => 'nexas_sanitize_select',
    )
);
$hide_show_option = nexas_slider_option();
$wp_customize->add_control(
    'nexas_homepage_slider_option',
    array(
        'type'        => 'radio',
        'label'       => esc_html__('Slider Option', 'nexas'),
        'description' => esc_html__('Show/hide option for homepage Slider Section.', 'nexas'),
        'section'     => 'nexas_slider_section',
        'choices'     => $hide_show_option,
        'priority'    => 7
    )
);

/**
 * Dropdown available category for homepage slider
 *
 */
$wp_customize->add_setting(
    'nexas_slider_cat_id',
    array(
        'default'           => $default['nexas_slider_cat_id'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'absint'
    )
);
$wp_customize->add_control(new Nexas_Customize_Category_Control(
        $wp_customize,
        'nexas_slider_cat_id',
        array(
            'label'        => esc_html__('Slider Category', 'nexas'),
            'description'  => esc_html__('Select Category for Homepage Slider Section', 'nexas'),
            'section'      => 'nexas_slider_section',
            'priority'     => 8,

        )
    )
);


/**
 * Field for no of posts to display..
 *
 */
$wp_customize->add_setting(
    'nexas_no_of_slider',
    array(
        'default'           => $default['nexas_no_of_slider'],
        'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control(
    'nexas_no_of_slider',
    array(
        'type'      => 'number',
        'label'     => esc_html__('No of Slider', 'nexas'),
        'section'   => 'nexas_slider_section',
        'priority'  => 10
    )
);


/**
 * Field for Get Started button text
 *
 */
$wp_customize->add_setting(
    'nexas_slider_get_started_txt',
    array(
        'default'           => $default['nexas_slider_get_started_txt'],
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    'nexas_slider_get_started_txt',
    array(
        'type'     => 'text',
        'label'    => esc_html__('Get Started Button', 'nexas'),
        'section'  => 'nexas_slider_section',
        'priority' => 11
    )
);

/**
 * Field for Get Started button Link
 *
 */
$wp_customize->add_setting(
    'nexas_slider_get_started_link',
    array(
        'default'           => $default['nexas_slider_get_started_link'],
        'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control(
    'nexas_slider_get_started_link',
    array(
        'type'         => 'url',
        'label'        => esc_html__('Get Started Button Link', 'nexas'),
        'description'  => esc_html__('Use full url link', 'nexas'),
        'section'      => 'nexas_slider_section',
        'priority'     => 20
    )
);

/*----------------------------------------------------------------------------------------------*/
	
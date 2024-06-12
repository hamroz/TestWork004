<?php

/**
 * Enqueue parent theme styles.
 */
function enqueue_parent_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'enqueue_parent_styles');

/**
 * Enqueue jQuery.
 */
function enqueue_jquery()
{
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'enqueue_jquery');

/**
 * Include the city temperature widget.
 */
if (file_exists(get_stylesheet_directory() . '/widgets/city-temperature-widget.php')) {
    require get_stylesheet_directory() . '/widgets/city-temperature-widget.php';
} else {
    error_log('The custom widget file does not exist.');
}

/**
 * Register Custom Post Type 'Cities'.
 */
function create_cities_cpt()
{
    $labels = array(
        'name' => _x('Cities', 'Post Type General Name', 'textdomain'),
        'singular_name' => _x('City', 'Post Type Singular Name', 'textdomain'),
        'menu_name' => __('Cities', 'textdomain'),
        'name_admin_bar' => __('City', 'textdomain'),
        'archives' => __('City Archives', 'textdomain'),
        'attributes' => __('City Attributes', 'textdomain'),
        'parent_item_colon' => __('Parent City:', 'textdomain'),
        'all_items' => __('All Cities', 'textdomain'),
        'add_new_item' => __('Add New City', 'textdomain'),
        'add_new' => __('Add New', 'textdomain'),
        'new_item' => __('New City', 'textdomain'),
        'edit_item' => __('Edit City', 'textdomain'),
        'update_item' => __('Update City', 'textdomain'),
        'view_item' => __('View City', 'textdomain'),
        'view_items' => __('View Cities', 'textdomain'),
        'search_items' => __('Search City', 'textdomain'),
        'not_found' => __('Not found', 'textdomain'),
        'not_found_in_trash' => __('Not found in Trash', 'textdomain'),
        'featured_image' => __('Featured Image', 'textdomain'),
        'set_featured_image' => __('Set featured image', 'textdomain'),
        'remove_featured_image' => __('Remove featured image', 'textdomain'),
        'use_featured_image' => __('Use as featured image', 'textdomain'),
        'insert_into_item' => __('Insert into city', 'textdomain'),
        'uploaded_to_this_item' => __('Uploaded to this city', 'textdomain'),
        'items_list' => __('Cities list', 'textdomain'),
        'items_list_navigation' => __('Cities list navigation', 'textdomain'),
        'filter_items_list' => __('Filter cities list', 'textdomain'),
    );
    $args = array(
        'label' => __('City', 'textdomain'),
        'description' => __('Custom Post Type for Cities', 'textdomain'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
        'taxonomies' => array(),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );
    register_post_type('cities', $args);
}
add_action('init', 'create_cities_cpt', 0);

/**
 * Add Meta Box for Custom Fields.
 */
function cities_add_meta_box()
{
    add_meta_box(
        'cities_meta_box', // $id
        'City Details', // $title
        'cities_meta_box_callback', // $callback
        'cities', // $screen
        'normal', // $context
        'high' // $priority
    );
}
add_action('add_meta_boxes', 'cities_add_meta_box');

/**
 * Meta Box Callback Function.
 *
 * @param WP_Post $post The post object.
 */
function cities_meta_box_callback($post)
{
    wp_nonce_field(basename(__FILE__), 'cities_nonce');
    $city_latitude = get_post_meta($post->ID, '_city_latitude', true);
    $city_longitude = get_post_meta($post->ID, '_city_longitude', true);
?>
    <p>
        <label for="city_latitude">Latitude:</label>
        <input type="text" name="city_latitude" id="city_latitude" value="<?php echo esc_attr($city_latitude); ?>" />
    </p>
    <p>
        <label for="city_longitude">Longitude:</label>
        <input type="text" name="city_longitude" id="city_longitude" value="<?php echo esc_attr($city_longitude); ?>" />
    </p>
<?php
}

/**
 * Save Custom Fields Data.
 *
 * @param int $post_id The post ID.
 */
function save_cities_meta_box_data($post_id)
{
    if (!isset($_POST['cities_nonce']) || !wp_verify_nonce($_POST['cities_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    if ('cities' != $_POST['post_type'] || !current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    $city_latitude = sanitize_text_field($_POST['city_latitude']);
    $city_longitude = sanitize_text_field($_POST['city_longitude']);

    update_post_meta($post_id, '_city_latitude', $city_latitude);
    update_post_meta($post_id, '_city_longitude', $city_longitude);
}
add_action('save_post', 'save_cities_meta_box_data');

/**
 * Register Custom Taxonomy 'Countries'.
 */
function create_countries_taxonomy()
{
    $labels = array(
        'name' => _x('Countries', 'Taxonomy General Name', 'textdomain'),
        'singular_name' => _x('Country', 'Taxonomy Singular Name', 'textdomain'),
        'menu_name' => __('Countries', 'textdomain'),
        'all_items' => __('All Countries', 'textdomain'),
        'parent_item' => __('Parent Country', 'textdomain'),
        'parent_item_colon' => __('Parent Country:', 'textdomain'),
        'new_item_name' => __('New Country Name', 'textdomain'),
        'add_new_item' => __('Add New Country', 'textdomain'),
        'edit_item' => __('Edit Country', 'textdomain'),
        'update_item' => __('Update Country', 'textdomain'),
        'view_item' => __('View Country', 'textdomain'),
        'separate_items_with_commas' => __('Separate countries with commas', 'textdomain'),
        'add_or_remove_items' => __('Add or remove countries', 'textdomain'),
        'choose_from_most_used' => __('Choose from the most used', 'textdomain'),
        'popular_items' => __('Popular Countries', 'textdomain'),
        'search_items' => __('Search Countries', 'textdomain'),
        'not_found' => __('Not Found', 'textdomain'),
        'no_terms' => __('No countries', 'textdomain'),
        'items_list' => __('Countries list', 'textdomain'),
        'items_list_navigation' => __('Countries list navigation', 'textdomain'),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
    );
    register_taxonomy('countries', array('cities'), $args);
}
add_action('init', 'create_countries_taxonomy', 0);

/**
 * Add custom action hooks before and after the cities table.
 */
function before_cities_table_action()
{
    echo '<p>Custom content before the cities table.</p>';
}
add_action('before_cities_table', 'before_cities_table_action');

function after_cities_table_action()
{
    echo '<p>Custom content after the cities table.</p>';
}
add_action('after_cities_table', 'after_cities_table_action');

/**
 * Handle AJAX request for searching cities.
 */
function search_cities()
{
    global $wpdb;
    $search_term = sanitize_text_field($_POST['search_term']);

    $cities = $wpdb->get_results($wpdb->prepare("
        SELECT p.ID, p.post_title, t.name as country, pm1.meta_value as latitude, pm2.meta_value as longitude
        FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
        INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        INNER JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
        LEFT JOIN {$wpdb->postmeta} pm1 ON p.ID = pm1.post_id AND pm1.meta_key = '_city_latitude'
        LEFT JOIN {$wpdb->postmeta} pm2 ON p.ID = pm2.post_id AND pm2.meta_key = '_city_longitude'
        WHERE p.post_type = 'cities' AND p.post_status = 'publish' AND tt.taxonomy = 'countries'
        AND p.post_title LIKE '%%%s%%'
    ", $search_term));

    $output = '';

    foreach ($cities as $city) {
        // Fetch temperature from OpenWeatherMap API
        $api_key = '7ba13ff535cfce6d4409a63bb01982e6';
        $api_url = "http://api.openweathermap.org/data/2.5/weather?lat={$city->latitude}&lon={$city->longitude}&units=metric&appid={$api_key}";

        $response = wp_remote_get($api_url);
        $temperature = '';

        if (is_array($response) && !is_wp_error($response)) {
            $body = json_decode($response['body'], true);
            $temperature = $body['main']['temp'] . '°C';
        }

        $output .= '<tr>';
        $output .= '<td>' . esc_html($city->country) . '</td>';
        $output .= '<td>' . esc_html($city->post_title) . '</td>';
        $output .= '<td>' . esc_html($temperature) . '</td>';
        $output .= '</tr>';
    }

    echo $output;
    wp_die();
}
add_action('wp_ajax_search_cities', 'search_cities');
add_action('wp_ajax_nopriv_search_cities', 'search_cities');

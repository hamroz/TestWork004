<?php

/**
 * Register and load the widget.
 */
function load_city_temperature_widget()
{
    register_widget('City_Temperature_Widget');
}
add_action('widgets_init', 'load_city_temperature_widget');

/**
 * Class City_Temperature_Widget
 *
 * Widget to display city temperature.
 */
class City_Temperature_Widget extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'city_temperature_widget',
            __('City Temperature Widget', 'textdomain'),
            array('description' => __('Widget to display city temperature', 'textdomain'))
        );
    }

    /**
     * Front-end display of widget.
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        $city_id = apply_filters('widget_city_id', $instance['city_id']);

        $city_name = get_the_title($city_id);
        $latitude = get_post_meta($city_id, '_city_latitude', true);
        $longitude = get_post_meta($city_id, '_city_longitude', true);

        // Fetch temperature from OpenWeatherMap API
        $api_key = '7ba13ff535cfce6d4409a63bb01982e6';
        $api_url = "http://api.openweathermap.org/data/2.5/weather?lat={$latitude}&lon={$longitude}&units=metric&appid={$api_key}";

        $response = wp_remote_get($api_url);
        $temperature = '';

        if (is_array($response) && !is_wp_error($response)) {
            $body = json_decode($response['body'], true);
            $temperature = $body['main']['temp'] . '°C';
        }

        echo $args['before_widget'];
        echo $args['before_title'] . $city_name . $args['after_title'];
        echo '<p>Temperature: ' . $temperature . '</p>';
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        if (isset($instance['city_id'])) {
            $city_id = $instance['city_id'];
        } else {
            $city_id = '';
        }
?>
        <p>
            <label for="<?php echo $this->get_field_id('city_id'); ?>"><?php _e('Select City:', 'textdomain'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('city_id'); ?>" name="<?php echo $this->get_field_name('city_id'); ?>">
                <?php
                $cities = get_posts(array('post_type' => 'cities', 'posts_per_page' => -1));
                foreach ($cities as $city) {
                    echo '<option value="' . $city->ID . '"' . selected($city->ID, $city_id, false) . '>' . $city->post_title . '</option>';
                }
                ?>
            </select>
        </p>
<?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['city_id'] = (!empty($new_instance['city_id'])) ? strip_tags($new_instance['city_id']) : '';
        return $instance;
    }
}

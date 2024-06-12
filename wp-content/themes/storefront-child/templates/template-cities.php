<?php
/* Template Name: Cities Template */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php do_action('before_cities_table'); ?>

        <!-- Search form for filtering cities -->
        <div class="search-form">
            <input type="text" id="city-search" placeholder="Search cities...">
        </div>

        <!-- Table displaying cities with their corresponding countries and temperatures -->
        <table id="cities-table">
            <thead>
                <tr>
                    <th>Country</th>
                    <th>City</th>
                    <th>Temperature</th>
                </tr>
            </thead>
            <tbody>
                <?php
                global $wpdb;
                $cities = $wpdb->get_results("
                    SELECT p.ID, p.post_title, t.name as country, pm1.meta_value as latitude, pm2.meta_value as longitude
                    FROM {$wpdb->posts} p
                    INNER JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
                    INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                    INNER JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
                    LEFT JOIN {$wpdb->postmeta} pm1 ON p.ID = pm1.post_id AND pm1.meta_key = '_city_latitude'
                    LEFT JOIN {$wpdb->postmeta} pm2 ON p.ID = pm2.post_id AND pm2.meta_key = '_city_longitude'
                    WHERE p.post_type = 'cities' AND p.post_status = 'publish' AND tt.taxonomy = 'countries'
                ");

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

                    echo '<tr>';
                    echo '<td>' . esc_html($city->country) . '</td>';
                    echo '<td>' . esc_html($city->post_title) . '</td>';
                    echo '<td>' . esc_html($temperature) . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

        <?php do_action('after_cities_table'); ?>

    </main><!-- #main -->
</div><!-- #primary -->

<!-- JavaScript for AJAX search functionality -->
<script>
jQuery(document).ready(function($) {
    $('#city-search').on('keyup', function() {
        var searchTerm = $(this).val().toLowerCase();
        // console.log('Search Term:', searchTerm); // Debugging line

        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'search_cities',
                search_term: searchTerm
            },
            success: function(response) {
                // console.log('AJAX Response:', response); // Debugging line
                $('#cities-table tbody').html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // console.log('AJAX Error:', textStatus, errorThrown); // Debugging line
            }
        });
    });
});
</script>

<?php
get_footer();
?>

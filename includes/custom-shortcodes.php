<?php
function get_custom_excerpt($content, $word_count)
{
    $trimmed_content = wp_trim_words($content, $word_count);
    return $trimmed_content;
}

/**
 * Displays a list of related pages based on a category slug.
 *
 * This shortcode retrieves all published posts from a specified category,
 * excluding the current page/post, and displays them in a grid layout with
 * thumbnails, titles, and excerpts.
 *
 * @param array $atts Shortcode attributes.
 * @return string The rendered HTML output with related pages.
 *
 * EXAMPLE USAGE:
 * [related_pages slug="my-category" number_of_pages_list="3" excerpt_length="20"]
 */
function related_pages_shortcode($atts)
{
    // Extract shortcode attributes
    $atts = shortcode_atts(
        array(
            'slug' => '',
            'number_of_pages_list' => 4,
            'post_type' => 'page',
            'excerpt_length' => 20,  // default excerpt length in words
        ),
        $atts,
        'related_pages'
    );

    // Get the category by slug
    $category = get_category_by_slug($atts['slug']);

    // If category doesn't exist, return empty string
    if (!$category) {
        return '';
    }

    // Get the current page/post ID
    $current_id = get_queried_object_id();

    // Set up the query arguments
    $args = array(
        'cat' => $category->term_id,
        'posts_per_page' => -1,  // Get all posts, we'll filter manually
        'post_type' => $atts['post_type'],
        'post_status' => 'publish',
        'has_password' => false,
        'orderby' => 'rand',  // Order by publication date
        'order' => 'DESC',  // Descending order (latest first)
        'post__not_in' => array($current_id),  // Exclude the current page/post
    );

    // Run the query
    $query = new WP_Query($args);

    // Start output buffering
    ob_start();

    if ($query->have_posts()) {
        echo '<aside class="related-pages">';
        $count = 0;
        while ($query->have_posts() && $count < intval($atts['number_of_pages_list'])) {
            $query->the_post();

            if (!has_post_thumbnail()) {
                continue;
            }

            $count++;

            $image_id = get_post_thumbnail_id();
            $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);

            if (empty($image_alt)) {
                $image_alt = get_the_title();
            }

            $image_src = wp_get_attachment_image_src($image_id, 'thumbnail');
?>
<a href="<?php the_permalink(); ?>" target="_blank" rel="noopener noreferrer">
    <article class="related-page">
        <div class="related-page-image">
            <img src="<?php echo esc_url($image_src[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>"
                width="<?php echo esc_attr($image_src[1]); ?>" height="<?php echo esc_attr($image_src[2]); ?>"
                loading="lazy" fetchpriority="high">
        </div>
        <h1 class="related-page-title"><?php the_title(); ?></h1>
        <div class="related-page-excerpt">
            <?php echo get_custom_excerpt(get_the_excerpt(), intval($atts['excerpt_length'])); ?></div>
    </article>
</a>
<?php
        }
        echo '</aside>';
    }

    wp_reset_postdata();

    return ob_get_clean();
}

/**
 * Retrieves and displays the latest posts from a specified category.
 *
 * This shortcode allows you to display a list of the latest posts from a
 * chosen category, along with titles, excerpts, and optionally thumbnails.
 *
 * @param array $atts Shortcode attributes.
 * @return string The rendered HTML output with the latest posts.
 *
 * EXAMPLE USAGE:
 *
 * [get_latest_post_details category="business" posts_per_page="2" include_thumbnail="no"]
 *
 * This example shows the latest 2 posts from the "business" category,
 * without including thumbnails.
 */
function get_latest_post_details($atts)
{
    // Define and sanitize shortcode attributes
    $atts = shortcode_atts(array(
        'category' => 'hong-kong-law',  // Default category
        'posts_per_page' => 1,  // Default number of posts
        'include_thumbnail' => 'yes'  // Default to include thumbnail
    ), $atts, 'get_recent_post_item');

    $category = sanitize_text_field($atts['category']);
    $posts_per_page = intval($atts['posts_per_page']);
    $include_thumbnail = strtolower($atts['include_thumbnail']) === 'yes' ? true : false;

    // Check if the category name contains special characters
    if (!ctype_alnum(str_replace(['-', '_'], '', $category))) {
        // Get the term ID by name (this assumes the category exists)
        $term = get_term_by('name', $category, 'category');
        if ($term) {
            $category_slug = $term->slug;
        } else {
            return '<p>Category not found.</p>';
        }
    } else {
        // Assume it's a slug
        $category_slug = $category;
    }

    // Prepare query arguments for WP_Query
    $query_args = array(
        'posts_per_page' => $posts_per_page,  // Number of posts to retrieve
        'post_status' => 'publish',  // Only published posts
        'has_password' => false,  // Exclude password-protected posts
        'category_name' => $category_slug  // Filter posts by category
    );

    // Execute the query to get the latest posts
    $latest_posts = new WP_Query($query_args);

    // Initialize output
    $output = '';

    // Check if there are posts
    if ($latest_posts->have_posts()) {
        // Loop through the posts
        while ($latest_posts->have_posts()) {
            $latest_posts->the_post();

            // Get the post details
            $post_title = get_the_title();
            $post_excerpt = get_the_excerpt();
            $post_url = get_permalink();
            $post_thumbnail = '';

            // Check if thumbnail should be included
            if ($include_thumbnail) {
                $post_thumbnail = get_the_post_thumbnail(get_the_ID(), 'full');
            }

            // Create the output for each post
            $output .= '<div class="latest-post">';
            $output .= '<h2 class="text-white">' . esc_html($post_title) . '</h2>';

            // Output the thumbnail if included
            if ($include_thumbnail && $post_thumbnail) {
                $output .= '<div class="post-thumbnail">' . $post_thumbnail . '</div>';
            }

            $output .= '<div class="post-excerpt text-white mb-3">' . $post_excerpt . '</div>';
            $output .= '<div class="cta_wrapper"><a href="' . esc_url($post_url) . '" class="cta_btn_link white-cta" aria-label="Read full article on ' . esc_attr($post_title) . '">Read More ›</a></div>';
            $output .= '</div>';
        }

        // Reset Post Data
        wp_reset_postdata();
    } else {
        // If no posts were found, return a message
        $output = '<p>No posts found.</p>';
    }

    return $output;
}

function register_custom_shortcodes()
{
    add_shortcode('related_pages', 'related_pages_shortcode');
    add_shortcode('get_recent_post_item', 'get_latest_post_details');
}

add_action('init', 'register_custom_shortcodes');

// added some comments
